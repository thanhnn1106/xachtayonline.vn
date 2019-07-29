@extends('layout.main')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('data-structure-json')
    @include('theme.modern.partials.data-structure-json', ['ad' => $ad])
@endsection

@section('social-meta')
    <meta name="robots" content="index, follow" class="next-head">
    <meta property="og:title" content="{{ $ad->title }}">
    <meta property="og:description" content="{{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($ad->description) )),0,160) }}">
    @if($ad->media_img->first())
        <meta property="og:image" content="{{ media_url($ad->media_img->first(), true) }}">
    @else
        <meta property="og:image" content="{{ asset('uploads/placeholder.png') }}">
    @endif
    <meta property="og:url" content="{{ route('single_ad', $ad->slug) }}">
    <meta name="twitter:card" content="summary_large_image">
    <!--  Non-Essential, But Recommended -->
    <meta name="og:site_name" content="{{ get_option('site_name') }}">
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl.carousel/assets/owl.carousel.css') }}">
@endsection

@section('main')

    <div class="modern-single-ad-top-description-wrap">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="modern-single-ad-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">@lang('app.home')</a></li>
                            <li><a href="{{ route('listing', ['category' => $ad->category->category_slug]) }}">  {{ $ad->category->category_name }} </a></li>
                            <li>{{ $ad->title }}</li>
                        </ol><!-- breadcrumb -->
                        <h1 class="modern-single-ad-top-title h1-custom">{{ $ad->title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="modern-single-ad-top-description">

                    <div class="col-sm-7 col-xs-12">
                        @if ( ! $ad->is_published())
                            <div class="alert alert-warning"> <i class="fa fa-warning"></i> @lang('app.ad_not_published_warning')</div>
                        @endif


                            @if( ! empty($ad->video_url))
                                <?php
                                $video_url = $ad->video_url;
                                if (strpos($video_url, 'youtube') > 0) {
                                    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
                                    if ( ! empty($matches[1])){
                                        echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$matches[1].'" frameborder="0" allowfullscreen></iframe></div>';
                                    }

                                } elseif (strpos($video_url, 'vimeo') > 0) {
                                    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $video_url, $regs)) {
                                       if (!empty($regs[3])){
                                           echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$regs[3].'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
                                       }
                                    }
                                }
                                ?>

                            @else

                                <div class="ads-gallery">
                                    <div class="fotorama" data-nav="thumbs">
                                    @foreach($ad->media_img as $img)
                                        <img class="img-responsive" src="{{ media_url($img, true) }}" alt="{{ $ad->title }}">
                                    @endforeach
                                    </div>
                                </div>

                            @endif

                        @if($enable_monetize)
                            {!! get_option('monetize_code_below_ad_image') !!}
                        @endif
                    </div>

                    <div class="col-sm-5 col-xs-12">
                        <h1 class="h1-custom">
                            <strong>{{ $ad->title }}</strong>
                        </h1>
                        <div class="ads-detail-meta">
                            <p class="text-muted">
                                <i class="fa fa-folder-o"></i><a href="{{ route('listing', ['category' => $ad->category->category_slug]) }}">  {{ $ad->category->category_name }} </a> |

                                @if($ad->brand)
                                    <i class="fa fa-industry"></i><a href="{{ route('listing', ['brand' => $ad->brand->brand_slug]) }}">  {{ $ad->brand->brand_name }} </a> |
                                @endif

                                <i class="fa fa-eye"></i> Đã xem: {{ $ad->view }}
                                @if ($ad->sku) | SKU: {{ $ad->sku }} @endif
                            </p>
                        </div>
                        <div class="ads-detail-meta">
                            <span class="modern-single-ad-price text-danger">Thời gian giao hàng dự kiến: {{ $ad->shipping_days }} ngày</span>
                        </div>
                        <span class="d-inline-block">
                            <h3 class="d-inline-block modern-single-ad-price @if ($ad->discount_price > 0) text-decorate-line-thought text-info @endif">
                                {{ trans('app.store_price') }}: {{ themeqx_price_ng(number_format($ad->price)) }}
                            </h3>
                            @if ($ad->discount_price > 0)
                                <h3 class="d-inline-block text-danger">-{{ number_format(100 - ($ad->discount_price / $ad->price * 100)) }}%</h3>
                            @endif
                        </span>

                        @if ($ad->discount_price > 0)
                            <h3 class="modern-single-ad-price text-danger">Giá gốc: {{ themeqx_price_ng(number_format($ad->discount_price)) }}</h3>
                            <h3  style="color: #00505F;" class="d-inline-block modern-single-ad-price">
                                {{ trans('app.ship_to_vn_price') }}: {{ themeqx_price_ng(number_format($ad->discount_price + $ad->shipping_fee)) }}
                            </h3>
                        @else
                            <h3 style="color: #00505F;" class="d-inline-block modern-single-ad-price @if ($ad->discount_price > 0) text-decorate-line-thought text-info @endif">
                                {{ trans('app.ship_to_vn_price') }}: {{ themeqx_price_ng(number_format($ad->price + $ad->shipping_fee)) }}
                            </h3>
                        @endif


                        @if($enable_monetize)
                            {!! get_option('monetize_code_below_ad_title') !!}
                        @endif


                        @if($enable_monetize)
                            {!! get_option('monetize_code_above_general_info') !!}
                        @endif

                        {{--<h3>@lang('app.general_info')</h3>--}}
                        {{--<p><strong><i class="fa fa-money"></i> @lang('app.price')</strong> {{ themeqx_price_ng($ad->price) }} </p>--}}
                        {{--<p><strong><i class="fa fa-map-marker"></i>  @lang('app.location') </strong> {!! $ad->full_address() !!} </p>--}}
                        {{--<p><strong><i class="fa fa-check-circle-o"></i> @lang('app.condition')</strong> {{ $ad->ad_condition }} </p>--}}

                        @if($enable_monetize)
                            {!! get_option('monetize_code_below_general_info') !!}
                        @endif

                        <div class="modern-social-share-btn-group">
                            <h4>@lang('app.share_this_ad')</h4>
                            <a href="#" class="btn btn-default share s_facebook"><i class="fa fa-facebook"></i> </a>
                            <a href="#" class="btn btn-default share s_plus"><i class="fa fa-google-plus"></i> </a>
                            <a href="#" class="btn btn-default share s_twitter"><i class="fa fa-twitter"></i> </a>
                            <a href="#" class="btn btn-default share s_linkedin"><i class="fa fa-linkedin"></i> </a>
                        </div>
                        <br>
                        <div class="row t-5">
                            <div class="t-5 col-sm-8 col-xs-12">
                                {{--<a type="button" href="{{ route('order', [$ad->id]) }}" class="btn btn-info btn-lg theme-btn">{{ trans('app.order') }}</a>--}}
                                <a type="button" target="_blank" href="https://m.me/xachtayonlinevn.vn/"" class="btn btn-info btn-lg theme-btn">{{ trans('app.order') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
    </div>


    <div class="container">
        <div class="row">
            @include('theme.modern.partials.ad_description')

            @include('theme.modern.partials.seller_info')
        </div>
    </div>

    @include('theme.modern.partials.related_ads', ["related_ads" => $related_ads])

    @include('theme.modern.partials.contact_us_section')

    <div class="modal fade" id="reportAdModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('app.report_ad_title')</h4>
                </div>
                <div class="modal-body">

                    <p>@lang('app.report_ad_description')</p>

                    <form>

                        <div class="form-group">
                            <label class="control-label">@lang('app.reason'):</label>
                            <select class="form-control" name="reason">
                                <option value="">@lang('app.select_a_reason')</option>
                                <option value="unavailable">@lang('app.item_sold_unavailable')</option>
                                <option value="fraud">@lang('app.fraud')</option>
                                <option value="duplicate">@lang('app.duplicate')</option>
                                <option value="spam">@lang('app.spam')</option>
                                <option value="wrong_category">@lang('app.wrong_category')</option>
                                <option value="offensive">@lang('app.offensive')</option>
                                <option value="other">@lang('app.other')</option>
                            </select>

                            <div id="reason_info"></div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <div id="email_info"></div>

                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea class="form-control" id="message" name="message"></textarea>
                            <div id="message_info"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn btn-primary" id="report_ad">@lang('app.report_ad')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="replyByEmail" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>

                {!! Form::open(['id' => 'replyByEmailForm']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">@lang('app.name'):</label>
                        <input type="text" class="form-control" id="name" name="name" data-validation="required">
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">@lang('app.email'):</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="control-label">@lang('app.phone_number'):</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number">
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="control-label">@lang('app.message'):</label>
                        <textarea class="form-control" id="message" name="message"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="ad_id" value="{{ $ad->id }}" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="submit" class="btn btn-primary" id="reply_by_email_btn">@lang('app.send_email')</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script src="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.js') }}"></script>
    <script src="{{ asset('assets/plugins/SocialShare/SocialShare.js') }}"></script>
    <script src="{{ asset('assets/plugins/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-validator/form-validator.min.js') }}"></script>

    <script>
        $('.share').ShareLink({
            title: '{{ $ad->title }}', // title for share message
            text: '{{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($ad->description) )),0,160) }}', // text for share message

            @if($ad->media_img->first())
            image: '{{ media_url($ad->media_img->first(), true) }}', // optional image for share message (not for all networks)
            @else
            image: '{{ asset('uploads/placeholder.png') }}', // optional image for share message (not for all networks)
            @endif
            url: '{{ route('single_ad', $ad->slug) }}', // link on shared page
            class_prefix: 's_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
            width: 640, // optional popup initial width
            height: 480 // optional popup initial height
        })
    </script>
    <script>
        $.validate();
    </script>
    <script>
        $(document).ready(function(){
            $(".themeqx_new_regular_ads_wrap").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });

        });
    </script>

    <script>
        $(function(){
            $('#onClickShowPhone').click(function(){
                $('#ShowPhoneWrap').html('<i class="fa fa-phone"></i> <a href="tel:{{ $ad->seller_phone }}"> {{ $ad->seller_phone }} </a>');
            });

            $('#save_as_favorite').click(function(){
                var selector = $(this);
                var slug = selector.data('slug');

                $.ajax({
                    type : 'POST',
                    url : '{{ route('save_ad_as_favorite') }}',
                    data : { slug : slug, action: 'add',  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        if (data.status == 1){
                            selector.html(data.msg);
                        }else {
                            if (data.redirect_url){
                                location.href= data.redirect_url;
                            }
                        }
                    }
                });
            });

            $('button#report_ad').click(function(){
                var reason = $('[name="reason"]').val();
                var email = $('[name="email"]').val();
                var message = $('[name="message"]').val();
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                var error = 0;
                if(reason.length < 1){
                    $('#reason_info').html('<p class="text-danger">Reason required</p>');
                    error++;
                }else {
                    $('#reason_info').html('');
                }
                if(email.length < 1){
                    $('#email_info').html('<p class="text-danger">Email required</p>');
                    error++;
                }else {
                    if ( ! regex.test(email)){
                        $('#email_info').html('<p class="text-danger">Valid email required</p>');
                        error++;
                    }else {
                        $('#email_info').html('');
                    }
                }
                if(message.length < 1){
                    $('#message_info').html('<p class="text-danger">Message required</p>');
                    error++;
                }else {
                    $('#message_info').html('');
                }

                if (error < 1){
                    $('#loadingOverlay').show();
                    $.ajax({
                        type : 'POST',
                        url : '{{ route('report_ads_pos') }}',
                        data : { reason : reason, email: email,message:message, slug:'{{ $ad->slug }}',  _token : '{{ csrf_token() }}' },
                        success : function (data) {
                            if (data.status == 1){
                                toastr.success(data.msg, '@lang('app.success')', toastr_options);
                            }else {
                                toastr.error(data.msg, '@lang('app.error')', toastr_options);
                            }
                            $('#reportAdModal').modal('hide');
                            $('#loadingOverlay').hide();
                        }
                    });
                }
            });

            $('#replyByEmailForm').submit(function(e){
                e.preventDefault();
                var reply_email_form_data = $(this).serialize();

                $('#loadingOverlay').show();
                $.ajax({
                    type : 'POST',
                    url : '{{ route('reply_by_email_post') }}',
                    data : reply_email_form_data,
                    success : function (data) {
                        if (data.status == 1){
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }else {
                            toastr.error(data.msg, '@lang('app.error')', toastr_options);
                        }
                        $('#replyByEmail').modal('hide');
                        $('#loadingOverlay').hide();
                    }
                });
            });

        });
    </script>

@endsection
