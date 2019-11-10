<?php

namespace App\Http\Controllers;

use App\Media;
use App\Post;
use App\ShippingFee;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ShippingFeeController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $title = 'Quản lý phí ship';

        return view('admin.shipping_fee_management.index', compact('title'));
    }

    public function list()
    {
        $shippingFee = ShippingFee::select('id', 'name', 'fee', 'discount')->get();

        return  Datatables::of($shippingFee)
            ->addColumn('actions', function($shippingFee) {

                $button = '';
                $button .= '<a href="'.route('edit_shipping_fee',['id' => $shippingFee->id]).'" class="btn btn-primary"><i class="fa fa-edit"></i> </a>  <a href="javascript:;" class="btn btn-danger deleteShippingFee" data-id="'.$shippingFee->id.'"><i class="fa fa-trash"></i> </a>';
                return $button;
            })
            ->removeColumn('id')
            ->escapeColumns(['*'])
            ->make(false);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = trans('app.create_new_shipping_fee');

            return view('admin.shipping_fee_management.create', compact('title'));
        } else {
            $rules = [
                'name'  => 'required|unique:shipping_fee',
                'fee' => 'required|numeric',
                'discount' => 'required|numeric'
            ];
            $this->validate($request, $rules);

            $data = [
                'name'     => $request->name,
                'fee'      => $request->fee ?: 0,
                'discount' => $request->discount ?: 0,
            ];

            $shippingFeeCreated = ShippingFee::create($data);

            if ($shippingFeeCreated){

                return redirect(route('shipping_fee'))->with('success', trans('app.created_successfully'));
            }

            return redirect()->back()->with('error', trans('app.error_msg'));
        }
    }

    public function edit()
    {
        $id = $this->request->id;
        $shippingFeeInfo = ShippingFee::find($id);
        if ($this->request->isMethod('GET')) {

            $title = trans('app.edit_new_shipping_fee');
            return view('admin.shipping_fee_management.edit', compact('title', 'shippingFeeInfo'));
        } else {
            $rules = [
                'fee' => 'required|numeric',
                'discount' => 'required|numeric'
            ];
            $this->validate($this->request, $rules);

            $data = [
                'fee'      => $this->request->fee ?: 0,
                'discount' => $this->request->discount ?: 0,
            ];

            $id = $this->request->id;
            $shippingFeeInfo = ShippingFee::find($id);
            $shippingFeeInfo->fee = $data['fee'];
            $shippingFeeInfo->discount = $data['discount'];
            $shippingFeeInfo->save();

            return redirect(route('shipping_fee'))->with('success', trans('app.updated_successfully'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        $id = $this->request->id;
        $shippingFee = ShippingFee::where('id', $id)->first();
        if ($shippingFee){
            $shippingFee->delete();
            return ['success' => 1, 'msg' => trans('app.operation_success')];
        }
        return ['success' => 0, 'msg' => trans('app.error_msg')];
    }
}
