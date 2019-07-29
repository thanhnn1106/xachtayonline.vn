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
                            <h1 class="page-header"> {{ $title }} </h1>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                @endif

                @include('admin.flash_msg')

                    {{ Form::open([ 'method'=>'get', 'id' => 'listingFilterForm']) }}

                    <div class="">
                        <div class="col-xs-12">
                            <p class="listingSidebarLeftHeader">@lang('app.filter_ads')
                                <span id="loaderListingIcon" class="pull-right" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                            </p>
                        </div>
                    </div>

                    <div class="form-group col-md-3 col-xs-12">
                        <input id="name" type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="@lang('app.search___')" />
                    </div>

                    <div class="form-group col-md-3 col-xs-12">
                        <select class="form-control" name="category" onchange="this.form.submit()">
                            <option value="">@lang('app.select_a_category')</option>
                            @if (count($categories) > 0)
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_slug }}" {{ request('category') ==  $category->category_slug ? 'selected':'' }}>{{ $category->category_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-3 col-xs-12">
                        <select class="form-control" id="sub_category_select" name="sub_category" onchange="this.form.submit()">
                            <option value="">@lang('app.select_a_sub_category')</option>
                            @if (isset($selected_sub_categories) && !empty($selected_sub_categories))
                                @foreach($selected_sub_categories as $sub_category)
                                    <option value="{{ $sub_category->category_slug }}" {{ request('sub_category') ==  $sub_category->category_slug ? 'selected':'' }} >{{ $sub_category->category_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-3 col-xs-12">
                        <select class="form-control" name="brand" id="brand_select" onchange="this.form.submit()">
                            <option value=""> @lang('app.select_a_brand') </option>
                            @if (isset($selected_brands) && !empty($selected_brands))
                                @foreach($selected_brands as $brand)
                                    <option value="{{ $brand->brand_slug }}" {{ request('brand') ==  $brand->brand_slug ? 'selected':'' }} >{{ $brand->brand_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-xs-12">
                        <select class="form-control" name="country" onchange="this.form.submit()">
                            <option value="">@lang('app.select_a_country')</option>
                            @if (count($countries) > 0)
                                @foreach($countries as $country)
                                    <option value="{{ $country->country_name }}" {{ request('country') == $country->country_name ? 'selected' :'' }}>{{ $country->country_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-xs-12">
                        {{--<label>@lang('app.price_min_max')</label>--}}

                        <div class="row">
                            <div class="col-xs-6">
                                <input type="number" class="form-control" name="min_price" value="{{ request('min_price') }}" placeholder="@lang('app.min_price')" />
                            </div>
                            <div class="col-xs-6">
                                <input type="number" class="form-control" name="max_price" value="{{ request('max_price') }}" placeholder="@lang('app.max_price')" />
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <div class="clearfix"></div>
                <div class="row">
                    <div class="col-xs-12">


                        @if($ads->total() > 0)
                            <table class="table table-bordered table-striped table-responsive">

                                @foreach($ads as $ad)
                                    <tr>
                                        <td width="100">
                                            <img src="{{ media_url($ad->feature_img) }}" class="thumb-listing-table"
                                                 alt="">
                                        </td>
                                        <td>
                                            <h5><a href="{{ route('single_ad', $ad->slug) }}"
                                                   target="_blank">{{ $ad->title }}</a> ({!! $ad->status_context() !!})
                                            </h5>
                                            <p class="text-muted">
                                                <i class="fa fa-map-marker"></i> {!! $ad->full_address()  !!} <br/> <i
                                                        class="fa fa-clock-o"></i> {{ $ad->posting_datetime()  }}
                                            </p>
                                            <p class="text-muted">
                                                {{ trans('app.store_price') . ': ' . themeqx_price_ng(number_format($ad->price)) }}
                                            </p>
                                            <p class="@if ($ad->discount_price > 0) text-danger @else text-muted  @endif">
                                                {{ trans('app.discount_price') . ': ' . ($ad->discount_price > 0 ? themeqx_price_ng(number_format($ad->discount_price)) : 0) }}
                                            </p>
                                            <p class="text-muted">
                                                {{ trans('app.ship_to_vn_price') . ': ' . ($ad->discount_price > 0 ? themeqx_price_ng(number_format($ad->shipping_fee + $ad->discount_price)) : themeqx_price_ng(number_format($ad->shipping_fee + $ad->price))) }}
                                            </p>
                                        </td>

                                        <td>

                                            <a href="{{ route('reports_by_ads', $ad->slug) }}">
                                                <i class="fa fa-exclamation-triangle"></i> @lang('app.reports')
                                                : {{ $ad->reports->count() }}
                                            </a>

                                            <hr/>

                                            <a href="{{ route('edit_ad', $ad->id) }}" class="btn btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @if($ad->status == 1)
                                                <a href="javascript:;" class="btn btn-warning blockAdv"
                                                   data-slug="{{ $ad->slug }}" data-value="2">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            @else
                                                <a href="javascript:;" class="btn btn-success approveAds"
                                                   data-slug="{{ $ad->slug }}" data-value="1">
                                                    <i class="fa fa-check-circle-o"></i>
                                                </a>
                                            @endif

                                            <a href="javascript:;" class="btn btn-danger deleteAds"
                                               data-slug="{{ $ad->slug }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>

                        @else
                            <h2>@lang('app.there_is_no_ads')</h2>
                        @endif

                        {!! $ads->links() !!}

                    </div>
                </div>

            </div>   <!-- /#page-wrapper -->

        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->
@endsection

@section('page-js')

    <script>
        $(document).ready(function () {
            $('.deleteAds').on('click', function () {
                if (!confirm('{{ trans('app.are_you_sure') }}')) {
                    return '';
                }
                var selector = $(this);
                var slug = selector.data('slug');
                $.ajax({
                    url: '{{ route('delete_ads') }}',
                    type: "POST",
                    data: {slug: slug, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {
                            selector.closest('tr').hide('slow');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });

            $('.approveAds, .blockAdv').on('click', function () {
                var selector = $(this);
                var slug = selector.data('slug');
                var value = selector.data('value');
                $.ajax({
                    url: '{{ route('ads_status_change') }}',
                    type: "POST",
                    data: {slug: slug, value: value, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {
                            selector.closest('tr').hide('slow');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });
        });

    </script>

    <script>
        // Using jQuery.

        $(function() {
            $('form').each(function() {
                $(this).find('input').keypress(function(e) {
                    // Enter pressed?
                    if(e.which == 10 || e.which == 13) {
                        this.form.submit();
                    }
                });

                $(this).find('input[type=submit]').hide();
            });
        });
        @if(session('success'))
        toastr.success('{{ session('success') }}', '{{ trans('app.success') }}', toastr_options);
        @endif
        @if(session('error'))
        toastr.error('{{ session('error') }}', '{{ trans('app.success') }}', toastr_options);
        @endif
    </script>

@endsection