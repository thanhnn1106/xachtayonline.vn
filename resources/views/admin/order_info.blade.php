@extends('layout.main')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('main')

    <div class="container">

        <div id="wrapper">

            @include('admin.sidebar_menu')

            <div id="page-wrapper">
                @if( ! empty($title))
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"> {{ $title }}  </h1>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                @endif
                @include('admin.flash_msg')
                <div class="row">
                    <div class="col-xs-12">

                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2" class="text-center">THÔNG TIN NGƯỜI MUA</th>
                            </tr>
                            <tr>
                                <th>@lang('app.name')</th>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.email')</th>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.phone')</th>
                                <td>{{ $order->user->phone }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.address')</th>
                                <td>{{ $order->shipping_address }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">THÔNG TIN NGƯỜI BÁN</th>
                            </tr>
                            <tr>
                                <th>@lang('app.seller_name')</th>
                                <td>{{ $seller->name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.seller_email')</th>
                                <td>{{ $seller->email }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.seller_phone')</th>
                                <td>{{ $seller->phone }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">THÔNG TIN ĐƠN HÀNG</th>
                            </tr>
                            <tr>
                                <th>@lang('app.product_name')</th>
                                <td>
                                    <a target="_blank" href="{{ route('single_ad', $order->ad->slug) }}">{{ $order->ad->title }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('app.price')</th>
                                <td>{{ themeqx_price_ng(number_format($order->price)) }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.quantity')</th>
                                <td>{{ $order->quantity }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.total_amount')</th>
                                <td>{{ themeqx_price_ng(number_format($order->total_amount)) }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.country')</th>
                                <td>{{ $order->user->country->country_name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.bank_reciept')</th>
                                <td>
                                    <img width="700" src="{{ get_image_url($order->bank_reciept) }}" />
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('app.note')</th>
                                <td>{{ $order->note }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.status')</th>
                                <td>{{ $order->status }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.created_at')</th>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>   <!-- /#page-wrapper -->
        </div>   <!-- /#wrapper -->
    </div> <!-- /#container -->
@endsection

@section('page-js')

@endsection