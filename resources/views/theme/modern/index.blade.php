@extends('layout.main')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl.carousel/assets/owl.carousel.css') }}">
@endsection

@section('main')
    <div class="modern-top-intoduce-section">

        <div class="container">
            <div class="row">
                <div class="col-md-5">

                    <div class="mdern-top-introduce-left">
                        <div class="alert alert-warning">
                            <h2>{{ get_option('modern_home_left_title') }} </h2>
                            <?php
                                $modern_home_left_content = get_option('modern_home_left_content');
                            if ($modern_home_left_content){
                                $modern_home_left_content = explode("\n", $modern_home_left_content);
                                foreach ($modern_home_left_content as $mhlc_value){
                                    echo "<p><i class='fa fa-check'></i> {$mhlc_value} </p>";
                                }
                            }
                            ?>
                        </div>
                    </div>

                    </div>

                <div class="col-md-7">

                    <div class="mdern-top-introduce-left">
                        <h1>{{ get_option('modern_home_right_title') }}</h1>

                        <p>{{ get_option('modern_home_right_content') }}</p>
                        <a href="{{route('contact_us_page')}}" class="btn btn-info btn-lg theme-btn"> @lang('app.contact_us') </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{--Main menu--}}
    @include('theme.modern.partials.main_menu')

    {{--<div class="modern-top-hom-cat-section">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<div class="modern-home-search-bar-wrap">--}}
                        {{--<div class="search-wrapper">--}}
                            {{--<form class="form-inline" action="{{ route('listing') }}" method="get">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" id="searchTerms" name="q" value="{{ request('q') }}" placeholder="@lang('app.search___')" />--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<select class="form-control" name="sub_category">--}}
                                        {{--<option value="">@lang('app.select_a_category')</option>--}}
                                        {{--@foreach($top_categories as $category)--}}
                                            {{--@if($category->sub_categories->count() > 0)--}}
                                                {{--<optgroup label="{{ $category->category_name }}">--}}
                                                    {{--@foreach($category->sub_categories as $sub_category)--}}
                                                        {{--<option value="{{ $sub_category->category_slug }}" {{ old('category') == $sub_category->id ? 'selected': '' }}>{{ $sub_category->category_name }}</option>--}}
                                                    {{--@endforeach--}}
                                                {{--</optgroup>--}}
                                            {{--@endif--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<select class="form-control" name="country">--}}
                                        {{--<option value="">@lang('app.select_a_country')</option>--}}
                                        {{--@foreach($countries as $country)--}}
                                            {{--<option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' :'' }}>{{ $country->country_name }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<select class="form-control select2" id="state_select" name="state">--}}
                                        {{--<option value=""> @lang('app.select_state') </option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}

                                {{--<button type="submit" class="btn theme-btn"> <i class="fa fa-search"></i> @lang('app.search_product')</button>--}}
                            {{--</form>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                    {{--<div class="clearfix"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}
    <br />


    @if($enable_monetize)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    {!! get_option('monetize_code_below_categories') !!}
                </div>
            </div>
        </div>
    @endif


    @if($urgent_ads->count() > 0)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="carousel-header">
                        <h4>
                            <a href="{{ route('listing') }}">
                                @lang('app.new_urgent_ads')
                            </a>
                        </h4>
                    </div>
                    <hr />

                    @foreach($urgent_ads->chunk(10) as $chunk)
                    <div class="themeqx_new_regular_ads_wrap themeqx-carousel-ads">
                        @foreach($chunk as $ad)
                            @if ($ad->category->is_active == 1)
                                @include('theme.modern.partials.product-card', ['pageType' => 'home', 'ad' => $ad])
                            @endif
                        @endforeach
                    </div> <!-- themeqx_new_premium_ads_wrap -->
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    @if(isset($premium_ads) && $premium_ads->count() > 0)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="carousel-header">
                        <h4>
                            <a href="{{ route('listing') }}">
                                @lang('app.best_seller')
                            </a>
                        </h4>
                    </div>
                    <hr />
                    @foreach($premium_ads->chunk(4) as $chunk)
                    <div class="themeqx_new_premium_ads_wrap themeqx-carousel-ads">
                        @foreach($chunk as $ad)
                            @if ($ad->category->is_active == 1)
                                @include('theme.modern.partials.product-card', ['pageType' => 'home', 'ad' => $ad])
                            @endif
                        @endforeach
                    </div> <!-- themeqx_new_premium_ads_wrap -->
                    @endforeach
                </div>


            </div>
        </div>
        @if($enable_monetize)
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        {!! get_option('monetize_code_below_premium_ads') !!}
                    </div>
                </div>
            </div>
        @endif
    @endif



    @if($regular_ads->count() > 0)

        <div class="container">
            <div class="row">

                <div class="col-sm-12">

                    <div class="carousel-header">
                        <h4>
                            <a href="{{ route('listing') }}">
                                @lang('app.new_regular_ads')
                            </a>
                        </h4>
                    </div>
                    <hr />
                    @foreach($regular_ads->chunk(10) as $chunk)
                    <div class="themeqx_new_regular_ads_wrap themeqx-carousel-ads">
                        @foreach($chunk as $ad)
                            @if ($ad['category']['is_active'] == 1)
                                @include('theme.modern.partials.product-card', ['pageType' => 'home'])
                            @endif
                        @endforeach
                    </div> <!-- themeqx_new_premium_ads_wrap -->
                    @endforeach
                </div>

            </div>
        </div>

    @endif

    @if($enable_monetize)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    {!! get_option('monetize_code_below_regular_ads') !!}
                </div>
            </div>
        </div>
    @endif

    @if(get_option('show_latest_blog_in_homepage') == 1)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="carousel-header">
                        <h4>
                            <a href="{{ route('blog') }}">
                                @lang('app.latest_post_from_blog')
                            </a>
                        </h4>
                    </div>
                    <hr />

                    <div class="home-latest-blog themeqx-carousel-blog-post">
                        @foreach($posts as $post)
                            <div>
                                <div class="image">
                                    <a href="{{ route('blog_single', $post->slug) }}">
                                        @if($post->feature_img)
                                            <img alt="{{ $post->title }}" src="{{ media_url($post->feature_img) }}">
                                        @else
                                            <img  alt="{{ $post->title }}" src="{{ asset('uploads/placeholder.png') }}">
                                        @endif
                                    </a>
                                </div>

                                <h2><a href="{{ route('blog_single', $post->slug) }}" class="blog-title">{{ $post->title }}</a></h2>

                                <div class="blog-post-carousel-meta-info">
                                    @if($post->author)
                                        <span class="pull-left">By <a href="{{ route('author_blog_posts', $post->author->id) }}">{{ $post->author->name }}</a></span>
                                    @endif
                                    <span class="pull-right">
                                        <i class="fa fa-calendar"></i> {{ $post->created_at_datetime() }}
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                                <p class="intro"> {{ str_limit(strip_tags($post->post_content), 80) }}</p>
                                <a class="btn btn-default" href="{{ route('blog_single', $post->slug) }}" >@lang('app.continue_reading')  <i class="fa fa-external-link"></i> </a>

                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('theme.modern.partials.contact_us_section')

@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/owl.carousel/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(".themeqx_new_premium_ads_wrap").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true,
                        loop:true
                    },
                    600:{
                        items:3,
                        nav:true,
                        loop:true
                    },
                    1000:{
                        items:4,
                        nav:false,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });

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
                        nav:true
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:true,
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });
        $(document).ready(function(){
            $(".home-latest-blog").owlCarousel({
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
                        nav:true
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:true,
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });

    </script>
    <script>
        function generate_option_from_json(jsonData, fromLoad){
            //Load Category Json Data To Brand Select
            if(fromLoad === 'country_to_state'){
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="" selected> @lang('app.select_state') </option>';
                    for ( i in jsonData){
                        option += '<option value="'+jsonData[i].id+'"> '+jsonData[i].state_name +' </option>';
                    }
                    $('#state_select').html(option);
                    $('#state_select').select2();
                }else {
                    $('#state_select').html('<option value="" selected> @lang('app.select_state') </option>');
                    $('#state_select').select2();
                }
                $('#loaderListingIcon').hide('slow');
            }
        }

        var options = {closeButton: true};
        @if(session('error'))
            toastr.error('{{ session('error') }}', 'Error!', options)
        @endif
        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Success!', options)
        @endif

        $(document).ready(function(){
            $('[name="country"]').change(function(){
                var country_id = $(this).val();
                $('#loaderListingIcon').show();
                $.ajax({
                    type : 'POST',
                    url : '{{ route('get_state_by_country') }}',
                    data : { country_id : country_id,  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        generate_option_from_json(data, 'country_to_state');
                    }
                });
            });
        });
    </script>
@endsection