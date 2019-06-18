<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation;

use App\Order;
use App\Ad;
use App\User;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order($adId)
    {
        $ad = Ad::where('id', $adId)->first();
        $userId = Auth::user() ? Auth::user()->id : '';
        if(empty($userId)) {
            return redirect(route('login'))->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        return view('theme.modern.order',['ad' => $ad]);
    }

    public function submitOrder(Request $request)
    {
        $userId = Auth::user() ? Auth::user()->id : '';
        $ad = Ad::where('id', $request->ad_id)->first();

        if(empty($userId)) {
            return redirect(route('login'))->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $rules = [
            'quantity' => 'required',
            'bank_reciept' => 'required',
            'shipping_address' => 'required',
            'phone'  => 'required|numeric'
        ];

        $validator = $this->validate($request, $rules);

        if (!$validator) {
            return redirect(route('submit_order'))
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('bank_reciept');
        $name = time() . '_' . $file->getClientOriginalName();
        $filePath = 'bank-reciept/' . $name;
        Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');

        $data = [
            'user_id' => $userId,
            'ad_id' => $request->ad_id,
            'seller_id' => $request->seller_id,
            'price' => $ad->price,
            'quantity' => $request->quantity,
            'total_amount' => $ad->price * $request->quantity,
            'bank_reciept' => $filePath,
            'note' => $request->note_to_seller ?? '',
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'status' => '0'
        ];

        $orderCreate = Order::create($data);
        if ($orderCreate) {
            return redirect(route('home'))
                ->with('success', 'Đặt hàng thành công!');
        } else {
            return back()->withInput()->with('error', trans('app.error_msg'));
        }
    }

    public function orderHistory()
    {
        $data = [
            "title" => trans('app.order_history')
        ];

        return view('admin.orders', $data);
    }

    public function orderHistoryData()
    {
        $user = Auth::user();
        if ($user->is_admin()){
            $orders = Order::select
                (
                    'id',
                    'ad_id',
                    'user_id',
                    'seller_id',
                    'price',
                    'quantity',
                    'total_amount',
                    'bank_reciept',
                    'note',
                    'shipping_address',
                    'phone',
                    'status',
                    'created_at'
            )->with('ad', 'user')->get();
        }else{
            $orders = Order::select
                (
                    'id',
                    'ad_id',
                    'user_id',
                    'seller_id',
                    'price',
                    'quantity',
                    'total_amount',
                    'bank_reciept',
                    'note',
                    'shipping_address',
                    'phone',
                    'status',
                    'created_at'
                )->where('user_id', $user->id)->with('ad', 'user')->get();
        }

        return Datatables::of($orders)
            ->editColumn('id', function($orders){
                return '<a href="' . route('order_info', $orders->id) . '">' . $orders->id . '</a>' ;
            })
            ->editColumn('ad_id', function($orders){
                return '<a href="' . route('single_ad', $orders->ad->slug) . '" target="_blank">'
                    . $orders->ad->title . '</a>';
            })
            ->editColumn('seller_id', function($orders){
                return '<a href="' . route('listing', $orders->ad->user->id) . '" target="_blank">'
                    . $orders->ad->user->name . '</a>';
            })
            ->editColumn('price', function($orders){
                return themeqx_price_ng(number_format($orders->price));
            })
            ->editColumn('quantity', function($orders){
                return $orders->quantity;
            })
            ->editColumn('total_amount', function($orders){
                return themeqx_price_ng(number_format($orders->total_amount));
            })
            ->editColumn('status', function($orders){
                return $this->getOrderStatus($orders->status);
            })
            ->editColumn('created_at', function($orders){
                return $orders->created_at;
            })
            ->removeColumn('user_id', 'bank_reciept', 'note', 'shipping_address', 'phone')
            ->escapeColumns(['*'])
            ->make(false);
    }

    private function getOrderStatus($status)
    {
        switch ($status) {
            case 0:
                return trans('app.waiting_for_confirm');
                break;
            case 1:
                return trans('app.processing');
                break;
            case 2:
                return trans('app.shipping');
                break;
            default:
                return trans('app.done');
                break;
        }
    }

    public function orderInfo($id)
    {
        $title = trans('app.order_info');
        $order = Order::find($id);
        $seller = User::find($order->seller_id);

        return view('admin.order_info', compact('title', 'order', 'seller'));
    }
}
