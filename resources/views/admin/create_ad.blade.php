@extends('layout.main')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection
<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<link href="{{ asset('assets/tam-emoji/css/emoji.css') }}" rel="stylesheet">
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
                    <div class="col-md-10 col-xs-12">

                        {{ Form::open(['id'=>'adsPostForm', 'class' => 'form-horizontal', 'files' => true]) }}

                        <legend>@lang('app.ad_info')</legend>


                        <div class="form-group  {{ $errors->has('category')? 'has-error':'' }}">
                            <label for="category_name" class="col-sm-4 control-label">
                                @lang('app.category') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="category">
                                    <option value="">@lang('app.select_a_category')</option>
                                    @foreach($categories as $category)
                                        @if($category->sub_categories->count() > 0)
                                            <optgroup label="{{ $category->category_name }}">
                                                @foreach($category->sub_categories as $sub_category)
                                                    <option value="{{ $sub_category->category_slug }}" {{ old('category') == $sub_category->category_slug ? 'selected': '' }}>{{ $sub_category->category_name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                                {!! $errors->has('category')? '<p class="help-block">'.$errors->first('category').'</p>':'' !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="brand_select" class="col-sm-4 control-label">
                                @lang('app.brand') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8 {{ $errors->has('brand')? 'has-error':'' }}">
                                <select class="form-control select2" name="brand" id="brand_select">
                                    @if($previous_brands->count() > 0)
                                        @foreach($previous_brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand') == $brand->id ? 'selected':'' }}>{{ $brand->brand_name }}</option>
                                        @endforeach
                                    @endif
                                </select>


                                {!! $errors->has('brand')? '<p class="help-block">'.$errors->first('brand').'</p>':'' !!}
                                <p class="text-info">@lang('app.skip_brand_text')
                                    <span id="brand_loader" style="display: none;">
                                        <i class="fa fa-spin fa-spinner"></i> </span>
                                </p>

                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('ad_name')? 'has-error':'' }}">
                            <label for="ad_name" class="col-sm-4 control-label">
                                @lang('app.ad_name')<span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ad_name" value="{{ old('ad_name') }}"
                                       name="ad_name" placeholder="@lang('app.ad_name')">
                                {!! $errors->has('ad_name')? '<p class="help-block">'.$errors->first('ad_name').'</p>':'' !!}
                                <p class="text-info"> @lang('app.ad_name_info')</p>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('sku')? 'has-error':'' }}">
                            <label for="sku" class="col-sm-4 control-label">@lang('app.sku')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="sku" value="{{ old('sku') }}"
                                       name="sku" placeholder="@lang('app.sku')">
                                {!! $errors->has('sku')? '<p class="help-block">'.$errors->first('sku').'</p>':'' !!}
                                <p class="text-info"> @lang('app.sku_info')</p>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('ad_title')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">
                                @lang('app.ad_title') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ad_title" value="{{ old('ad_title') }}"
                                       name="ad_title" placeholder="@lang('app.ad_title')">
                                {!! $errors->has('ad_title')? '<p class="help-block">'.$errors->first('ad_title').'</p>':'' !!}
                                <p class="text-info"> @lang('app.great_title_info')</p>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('ad_description')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">
                                @lang('app.ad_description') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="ad_description" name="ad_description" class="form-control"
                                          rows="8">{{ old('ad_description') }}</textarea>
                                {!! $errors->has('ad_description')? '<p class="help-block">'.$errors->first('ad_description').'</p>':'' !!}
                                <p class="text-info"> @lang('app.ad_description_info_text')</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                @lang('app.ad_content') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8">
                                <textarea id='ad_content' name="ad_content" class="form-control" rows="8">{{ old('ad_content') }}</textarea>
                                {!! $errors->has('ad_content')? '<p class="help-block">'.$errors->first('ad_content').'</p>':'' !!}
                                <p class="text-info"> @lang('app.ad_content_info_text')</p>
                            </div>

                        </div>

                        {{--<div class="form-group required {{ $errors->has('type')? 'has-error':'' }}">--}}
                            {{--<label class="col-md-4 control-label">--}}
                                {{--@lang('app.add_type') <span class="text-danger"> (*)</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-md-8">--}}
                                {{--<label for="type_private" class="radio-inline">--}}
                                    {{--<input type="radio" value="personal" id="type_private"--}}
                                           {{--name="type" {{ old('type') == 'personal'? 'checked="checked"' : '' }}>--}}
                                    {{--@lang('app.private')--}}
                                {{--</label>--}}
                                {{--<label for="type_business" class="radio-inline">--}}
                                    {{--<input type="radio" checked="checked" value="business" id="type_business"--}}
                                           {{--name="type" {{ old('type') == 'business'? 'checked="checked"' : '' }}>--}}

                                    {{--@lang('app.business')--}}
                                {{--</label>--}}
                                {{--{!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group {{ $errors->has('condition')? 'has-error':'' }}">--}}
                            {{--<label for="condition" class="col-sm-4 control-label">--}}
                                {{--@lang('app.condition') <span class="text-danger"> (*)</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-8">--}}
                                {{--<select class="form-control select2NoSearch" name="condition" id="condition">--}}
                                    {{--<option value="new" {{ old('condition') == 'new' ? 'selected':'' }}>@lang('app.new')</option>--}}
                                    {{--<option value="used" {{ old('condition') == 'used' ? 'selected':'' }}>@lang('app.used')</option>--}}
                                {{--</select>--}}
                                {{--{!! $errors->has('condition')? '<p class="help-block">'.$errors->first('condition').'</p>':'' !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group {{ $errors->has('price_plan')? 'has-error':'' }}">
                            <label for="condition" class="col-sm-4 control-label">
                                @lang('app.price_plan') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control select2NoSearch" name="price_plan" id="price_plan">
                                    <option value="regular" {{ old('price_plan') == 'regular' ? 'selected':'' }}>@lang('app.regular')</option>
                                    <option value="premium" {{ old('price_plan') == 'premium' ? 'selected':'' }}>@lang('app.premium')</option>
                                </select>
                                {!! $errors->has('price_plan')? '<p class="help-block">'.$errors->first('price_plan').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('price')? 'has-error':'' }}">
                            <label for="price" class="col-md-4 control-label">
                                @lang('app.price') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">{{ get_option('currency_sign') }}</span>
                                    <input type="text" placeholder="@lang('app.ex_price')" class="form-control"
                                           name="price" id="price" value="{{ old('price') }}">
                                </div>
                            </div>

                            <div class="col-sm-8 col-md-offset-4">
                                {!! $errors->has('price')? '<p class="help-block">'.$errors->first('price').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('discount_price')? 'has-error':'' }}">
                            <label for="price" class="col-md-4 control-label">
                                @lang('app.discount_price') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">{{ get_option('currency_sign') }}</span>
                                    <input type="text" placeholder="@lang('app.ex_price')" class="form-control"
                                           name="discount_price" id="discount_price" value="{{ old('discount_price') ?? 0 }}">
                                </div>
                            </div>

                            <div class="col-sm-8 col-md-offset-4">
                                {!! $errors->has('discount_price')? '<p class="help-block">'.$errors->first('discount_price').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('shipping_fee')? 'has-error':'' }}">
                            <label for="shipping_fee" class="col-md-4 control-label">
                                @lang('app.shipping_fee') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">{{ get_option('currency_sign') }}</span>
                                    <input type="text" placeholder="@lang('app.ex_price')" class="form-control"
                                           name="shipping_fee" id="shipping_fee" value="{{ old('shipping_fee') ?? 0 }}">
                                </div>
                            </div>

                            <div class="col-sm-8 col-md-offset-4">
                                {!! $errors->has('shipping_fee')? '<p class="help-block">'.$errors->first('shipping_fee').'</p>':'' !!}
                            </div>

                        </div>

                        <div class="form-group  {{ $errors->has('shipping_days')? 'has-error':'' }}">
                            <label for="price" class="col-md-4 control-label">
                                @lang('app.shipping_days') <span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="number" class="form-control"
                                           name="shipping_days" id="shipping_days" min="1" value="{{ old('shipping_days') ?? 15 }}">
                                </div>
                            </div>

                            <div class="col-sm-8 col-md-offset-4">
                                {!! $errors->has('shipping_days')? '<p class="help-block">'.$errors->first('shipping_days').'</p>':'' !!}
                            </div>

                        </div>
                        <div class="form-group offset-8">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 addon-ad-charge">
                                <label class="control-label">
                                    <input type="checkbox" class="mark_ad_urgent" name="mark_ad_urgent" value="1" data-price="{{ get_option('urgent_ads_price')  }}" />
                                    @lang('app.mark_as_urgent')
                                </label>
                            </div>
                        </div>

                        <legend>@lang('app.image') <span class="text-danger"> (*)</span></legend>

                        <div class="form-group {{ $errors->has('images')? 'has-error':'' }}">
                            <div class="col-sm-12">

                                <div id="uploaded-ads-image-wrap">

                                    @if($ads_images->count() > 0)
                                        @foreach($ads_images as $img)
                                            <div class="creating-ads-img-wrap">
                                                <img src="{{ media_url($img, false) }}" class="img-responsive"/>
                                                <div class="img-action-wrap" id="{{ $img->id }}">
                                                    <a href="javascript:;" class="imgDeleteBtn"><i
                                                                class="fa fa-trash-o"></i> </a>
                                                    <a href="javascript:;" class="imgFeatureBtn"><i
                                                                class="fa fa-star{{ $img->is_feature ==1 ? '':'-o' }}"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>


                                <div class="file-upload-wrap">
                                    <label>
                                        <input type="file" name="images" id="images" style="display: none;"/>
                                        <i class="fa fa-cloud-upload"></i>
                                        <p>@lang('app.upload_image')</p>

                                        <div class="progress" style="display: none;"></div>

                                    </label>
                                </div>

                                {!! $errors->has('images')? '<p class="help-block">'.$errors->first('images').'</p>':'' !!}
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('video_url')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">@lang('app.video_url')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="video_url" value="{{ old('video_url') }}"
                                       name="video_url" placeholder="@lang('app.video_url')">
                                {!! $errors->has('video_url')? '<p class="help-block">'.$errors->first('video_url').'</p>':'' !!}
                                <p class="help-block">@lang('app.video_url_help')</p>
                                <p class="text-info">@lang('app.video_url_help_for_modern_theme')</p>
                            </div>
                        </div>


                        <legend>@lang('app.location_info')</legend>

                        <div class="form-group  {{ $errors->has('country')? 'has-error':'' }}">
                            <label for="category_name" class="col-sm-4 control-label">
                                @lang('app.country')<span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="country">
                                    <option value="">@lang('app.select_a_country')</option>

                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' :'' }}>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('country')? '<p class="help-block">'.$errors->first('country').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('state')? 'has-error':'' }}">
                            <label for="category_name" class="col-sm-4 control-label">
                                @lang('app.state')<span class="text-danger"> (*)</span>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="state_select" name="state">
                                    @if($previous_states->count() > 0)
                                        @foreach($previous_states as $state)
                                            <option value="{{ $state->id }}" {{ old('state') == $state->id ? 'selected' :'' }}>{{ $state->state_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="text-info">
                                    <span id="state_loader" style="display: none;"><i class="fa fa-spin fa-spinner"></i> </span>
                                </p>
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('city')? 'has-error':'' }}">
                            <label for="category_name" class="col-sm-4 control-label">
                                @lang('app.city')
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="city_select" name="city">
                                    @if($previous_cities->count() > 0)
                                        @foreach($previous_cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city') == $city->id ? 'selected':'' }}>{{ $city->city_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="text-info">
                                    <span id="city_loader" style="display: none;"><i class="fa fa-spin fa-spinner"></i> </span>
                                </p>
                            </div>
                        </div>


                        <legend>@lang('app.seller_info')</legend>

                        <div class="form-group {{ $errors->has('seller_name')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">@lang('app.seller_name')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="seller_name"
                                       value="{{ old('seller_name')? old('seller_name') : $lUser->name }}"
                                       name="seller_name" placeholder="@lang('app.seller_name')">
                                {!! $errors->has('seller_name')? '<p class="help-block">'.$errors->first('seller_name').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('seller_email')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">@lang('app.seller_email')</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="seller_email"
                                       value="{{ old('seller_email')? old('seller_email') : $lUser->email }}"
                                       name="seller_email" placeholder="@lang('app.seller_email')">
                                {!! $errors->has('seller_email')? '<p class="help-block">'.$errors->first('seller_email').'</p>':'' !!}
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('seller_phone')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">@lang('app.seller_phone')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="seller_phone"
                                       value="{{ old('seller_phone') ? old('seller_phone') : $lUser->phone }}"
                                       name="seller_phone" placeholder="@lang('app.seller_phone')">
                                {!! $errors->has('seller_phone')? '<p class="help-block">'.$errors->first('seller_phone').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address')? 'has-error':'' }}">
                            <label for="address" class="col-sm-4 control-label">@lang('app.address')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="address"
                                       value="{{ old('address')? old('address') : $lUser->address }}" name="address"
                                       placeholder="@lang('app.address')">
                                {!! $errors->has('address')? '<p class="help-block">'.$errors->first('address').'</p>':'' !!}
                                <p class="text-info">@lang('app.address_line_help_text')</p>
                            </div>
                        </div>


                        {{--@if(get_option('ads_price_plan') != 'all_ads_free')--}}



                        {{--<div class="panel panel-default">--}}
                        {{--<div class="panel-heading">--}}
                        {{--<h3 class="panel-title">@lang('app.payment_info')</h3>--}}
                        {{--</div>--}}
                        {{--<div class="panel-body">--}}




                        {{--<div class="form-group {{ $errors->has('price_plan')? 'has-error':'' }}">--}}
                        {{--<label for="price_plan" class="col-sm-4 control-label">@lang('app.price_plan')</label>--}}
                        {{--<div class="col-sm-8">--}}

                        {{--<div class="price_input_group">--}}

                        {{--<label><input type="radio" value="regular" name="price_plan" data-price="{{ get_ads_price() }}"  />@lang('app.regular') </label> <br />--}}

                        {{--<label><input type="radio" value="premium" name="price_plan" data-price="{{ get_ads_price('premium') }}" />@lang('app.premium') </label>--}}

                        {{--<div class="well" id="price_summery" style="display: none;">--}}
                        {{--@lang('app.payable_amount') :--}}
                        {{--<span id="payable_amount">{{ get_option('regular_ads_price') }}</span>--}}
                        {{--</div>--}}


                        {{--{!! $errors->has('price_plan')? '<p class="help-block">'.$errors->first('price_plan').'</p>':'' !!}--}}

                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group {{ $errors->has('payment_method')? 'has-error':'' }}">--}}
                        {{--<label for="payment_method" class="col-sm-4 control-label">@lang('app.payment_method')</label>--}}
                        {{--<div class="col-sm-8">--}}
                        {{--<select class="form-control select2NoSearch" name="payment_method" id="payment_method">--}}
                        {{--@if(get_option('enable_paypal') == 1)--}}
                        {{--<option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected':'' }}>@lang('app.paypal')</option>--}}
                        {{--@endif--}}
                        {{--@if(get_option('enable_stripe') == 1)--}}
                        {{--<option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected':'' }}>@lang('app.stripe')</option>--}}
                        {{--@endif--}}
                        {{--</select>--}}
                        {{--{!! $errors->has('payment_method')? '<p class="help-block">'.$errors->first('payment_method').'</p>':'' !!}--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        {{--</div>--}}
                        {{--</div>--}}


                        {{--@endif--}}


                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary">@lang('app.save_new_ad')</button>
                            </div>
                        </div>
                        {{ Form::close() }}

                    </div>

                </div>

            </div>   <!-- /#page-wrapper -->

        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->

@endsection

@section('page-js')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <script src="{{ asset('assets/tam-emoji/js/config.js') }}"></script>
    <script src="{{ asset('assets/tam-emoji/js/tam-emoji.min.js?v=1.1') }}"></script>
    <script>
        function generate_option_from_json(jsonData, fromLoad) {
            //Load Category Json Data To Brand Select
            if (fromLoad === 'category_to_brand') {
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="0" selected> <?php echo trans('app.select_a_brand') ?> </option>';
                    for (i in jsonData) {
                        option += '<option value="' + jsonData[i].id + '"> ' + jsonData[i].brand_name + ' </option>';
                    }
                    $('#brand_select').html(option);
                    $('#brand_select').select2();
                } else {
                    $('#brand_select').html('');
                    $('#brand_select').select2();
                }
                $('#brand_loader').hide('slow');
            } else if (fromLoad === 'country_to_state') {
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="0" selected> @lang('app.select_state') </option>';
                    for (i in jsonData) {
                        option += '<option value="' + jsonData[i].id + '"> ' + jsonData[i].state_name + ' </option>';
                    }
                    $('#state_select').html(option);
                    $('#state_select').select2();
                } else {
                    $('#state_select').html('');
                    $('#state_select').select2();
                }
                $('#state_loader').hide('slow');

            } else if (fromLoad === 'state_to_city') {
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="0" selected> @lang('app.select_city') </option>';
                    for (i in jsonData) {
                        option += '<option value="' + jsonData[i].id + '"> ' + jsonData[i].city_name + ' </option>';
                    }
                    $('#city_select').html(option);
                    $('#city_select').select2();
                } else {
                    $('#city_select').html('');
                    $('#city_select').select2();
                }
                $('#city_loader').hide('slow');
            }
        }

        $(document).ready(function () {
            document.emojiType = 'unicode';
            document.emojiSource = '../../../assets/tam-emoji/img';
            $('#ad_description').summernote({
                toolbar: [
                    ['insert', ['emoji']],
                    ['tool', ['undo', 'redo', 'codeview']],
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['table', ['table']],
                ],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5'],
            });
            $('#ad_content').summernote({
                toolbar: [
                    ['insert', ['emoji']],
                    ['tool', ['undo', 'redo', 'codeview']],
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['table', ['table']],
                ],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5'],
            });
            $('[name="category"]').change(function () {
                var category_slug = $(this).val();
                $('#brand_loader').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('get_brand_by_category') }}',
                    data: {category_slug: category_slug, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        generate_option_from_json(data, 'category_to_brand');
                    }
                });

                /*                $.ajax({
                                    type : 'POST',
                                    url : '{{ route('get_category_info') }}',
                    data : { category_id : category_id,  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        if (data.category_slug == 'jobs'){
                            alert('Jobs');
                        }
                    }
                });
                */
            });


            $('[name="country"]').change(function () {
                var country_id = $(this).val();
                $('#state_loader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get_state_by_country') }}',
                    data: {country_id: country_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        generate_option_from_json(data, 'country_to_state');
                    }
                });
            });

            $('[name="state"]').change(function () {
                var state_id = $(this).val();
                $('#city_loader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get_city_by_state') }}',
                    data: {state_id: state_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        generate_option_from_json(data, 'state_to_city');
                    }
                });
            });

            $("#images").change(function () {
                var fd = new FormData(document.querySelector("form#adsPostForm"));
                //$('#loadingOverlay').show();
                $('.progress').show();
                $.ajax({
                    url: '{{ route('upload_ads_image') }}',
                    type: "POST",
                    data: fd,

                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                //console.log(percentComplete);

                                var progress_bar = '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: ' + percentComplete + '%">' + percentComplete + '% </div>';

                                if (percentComplete === 100) {
                                    $('.progress').hide();
                                }

                            }
                        }, false);

                        return xhr;
                    },

                    cache: false,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,   // tell jQuery not to set contentType
                    success: function (data) {
                        //$('#loadingOverlay').hide('slow');
                        if (data.success == 1) {
                            $('#uploaded-ads-image-wrap').load('{{ route('append_media_image') }}');
                        } else {
                            toastr.error(data.msg, '<?php echo trans('app.error') ?>', toastr_options);
                        }
                    }
                });
            });

            $('body').on('click', '.imgDeleteBtn', function () {
                //Get confirm from user
                if (!confirm('{{ trans('app.are_you_sure') }}')) {
                    return '';
                }

                var current_selector = $(this);
                var img_id = $(this).closest('.img-action-wrap').attr('id');
                $.ajax({
                    url: '{{ route('delete_media') }}',
                    type: "POST",
                    data: {media_id: img_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {
                            current_selector.closest('.creating-ads-img-wrap').hide('slow');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });
            $('body').on('click', '.imgFeatureBtn', function () {
                var img_id = $(this).closest('.img-action-wrap').attr('id');
                var current_selector = $(this);

                $.ajax({
                    url: '{{ route('feature_media_creating_ads') }}',
                    type: "POST",
                    data: {media_id: img_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {
                            $('.imgFeatureBtn').html('<i class="fa fa-star-o"></i>');
                            current_selector.html('<i class="fa fa-star"></i>');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });
            /*
                        $('input[name="price_plan"]').click(function(){
                            var price = $(this).data('price');

                            $('#payable_amount').text(price);
                            $('#price_summery').show('slow');
                        });

                        */

            $(document).on('change', '.price_input_group', function () {
                var price = 0;

                var checkedValues = $('.price_input_group input:checked').map(function () {
                    return $(this).data('price');
                }).get();

                for (var i = 0; i < checkedValues.length; i++) {
                    price += parseInt(checkedValues[i]); //don't forget to add the base
                }

                $('#payable_amount').text(price);
                $('#price_summery').show('slow');
            });


        });
    </script>


    <script>
        @if(session('success'))
        toastr.success('{{ session('success') }}', '<?php echo trans('app.success') ?>', toastr_options);
        @endif
    </script>
@endsection