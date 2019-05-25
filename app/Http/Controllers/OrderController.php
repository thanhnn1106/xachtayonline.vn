<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Order;
use App\Ad;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order($adId)
    {
        dd(config('filesystems.disks.s3'));
        $ad = Ad::whereId($adId)->first();
        $userId = Auth::user() ? Auth::user()->id : '';
        if(empty($userId)) {
            return redirect(route('login'))->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        return view('theme.modern.order',['ad' => $ad]);
    }

    public function submitOrder(Request $request)
    {
        $userId = Auth::user() ? Auth::user()->id : '';
        $ad = Ad::whereId($request->ad_id)->first();
        if(empty($userId)) {
            return redirect(route('login'))->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $rules = [
            'quantity'  => 'required',
            'bank_reciept'  => 'required',
        ];

        $validator = $this->validate($request, $rules);

        if (!is_null($validator)) {
            return redirect(route('submit_order'))
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('bank_reciept');
        dd(Storage::disk('s3'));
        $name = time() . $file->getClientOriginalName();
        $filePath = getenv('AWS_URL') . '/' . getenv('AWS_BUCKET') . '/' . $name;
        dd($filePath);
        Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');

        $data = [
            'user_id' => $userId,
            'ad_id' => $request->ad_id,
            'price' => $ad->price,
            'quantity' => $request->quantity,
            'total_amount' => $ad->price * $request->quantity,
            'bank_reciept' => $filePath,
            'status' => 0
        ];
dd($data);
        $orderCreate = Order::create($data);
        if ($orderCreate) {
            return redirect(route('home'))
                ->with('success', 'Đặt hàng thành công!');
        } else {
            return back()->withInput()->with('error', trans('app.error_msg'));
        }
    }
}
