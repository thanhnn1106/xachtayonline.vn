<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@section('title') {{ get_option('site_title') }} @show</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('data-structure-json')
    @section('social-meta')
        <meta name="robots" content="index, follow" class="next-head">
        <meta name="description" content="{{ get_option('meta_description') }}" class="next-head">
        <meta property="og:title" content="{{ get_option('site_title') }}" class="next-head">
        <meta property="og:description" content="{{ get_option('meta_description') }}" class="next-head">
        <meta property="og:image" content="https://xachtayonline-vn.s3-ap-southeast-1.amazonaws.com/uploads/images/xachtayonline-vn.jpeg" class="next-head">
        <meta property="og:url" content="{{ route('home') }}" class="next-head">
        <meta name="twitter:card" content="summary_large_image">
        <!--  Non-Essential, But Recommended -->
        <meta name="og:site_name" content="{{ get_option('site_name') }}" class="next-head">
    @show

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-theme.min.css') }}">--}}
    <!-- Font awesome 4.4.0 -->
    <link rel="stylesheet" href="{{ asset('assets/font-awesome-4.4.0/css/font-awesome.min.css') }}">
    <!-- load page specific css -->

    <!-- main select2.css -->
    <link href="{{ asset('assets/select2-3.5.3/select2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/select2-3.5.3/select2-bootstrap.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/nprogress/nprogress.css') }}">

    <!-- Conditional page load script -->
@if(request()->segment(1) === 'dashboard')
        <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/metisMenu/dist/metisMenu.min.css') }}">
    @endif

    <!-- main style.css -->

<?php
            $default_style = get_option('default_style');
            $default_style = 'blue';
        ?>
    @if($default_style == 'default')
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset("assets/css/style-{$default_style}.css") }}">
    @endif
    @yield('page-css')

@if(get_option('additional_css'))
        @endif
    <style type="text/css">
        {{ get_option('additional_css') }}
    </style>

    <script src="{{ asset('assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141776126-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-141776126-1');
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/style-custom.css') }}">
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="header-nav-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12 ">
                <div class="topContactInfo">
                    <ul class="nav nav-pills">
                        @if(get_option('site_phone_number'))
                            <li>
                                <a href="tel:{{get_option('site_phone_number')}}">
                                    <i class="fa fa-phone"></i>
                                    +{{ get_option('site_phone_number') }}
                                </a>
                            </li>
                        @endif

                        @if(get_option('site_email_address'))
                            <li>
                                <a href="mailto:{{ get_option('site_email_address') }}">
                                    <i class="fa fa-envelope"></i>
                                    {{ get_option('site_email_address') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
            <div class="col-md-8 col-sm-12">
                @if(Auth::check())

                    <div class="topContactInfo">
                        <ul class="nav nav-pills navbar-right">
                            <li>
                                <a href="{{ route('profile') }}">
                                    <i class="fa fa-user"></i>
                                    @lang('app.hi'), {{ $logged_user->name }} </a>
                            </li>
                            @if($lUser->is_admin())
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <i class="fa fa-dashboard"></i>
                                    Dashboard </a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('logout') }}">
                                    <i class="fa fa-sign-out"></i>
                                    @lang('app.logout')
                                </a>
                            </li>
                        </ul>
                    </div>

                @else

                    {{--{{ Form::open(['route'=>'login','class'=> 'navbar-form navbar-right', 'role'=> 'form']) }}--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('app.email_address') }}">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<input  type="password" class="form-control" name="password" placeholder="{{ trans('app.password') }}">--}}
                    {{--</div>--}}
                    {{--<button type="submit" class="btn btn-success theme-btn">@lang('app.login')</button>--}}
                    {{--{{ Form::close() }}--}}
                @endif
                <ul class="nav nav-pills pull-right loginBar">
                    @if($header_menu_pages->count() > 0)
                        @foreach($header_menu_pages as $page)
                            <li><a class="text-white" href="{{ route('single_page', $page->slug) }}">{{ $page->title }} </a></li>
                        @endforeach
                    @endif

                    @if( ! Auth::check())
                        <li><a href="{{ route('login') }}"> <i class="fa fa-lock"></i>  {{ trans('app.login') }}  </a>  </li>
                        <li><a href="{{ route('user.create') }}"> <i class="fa fa-save"></i>  {{ trans('app.register') }}</a></li>
                    @endif
                    @if(Auth::check() && $lUser->is_admin())
                        <li><a href="{{ route('create_ad') }}"> <i class="fa fa-tag"></i> @lang('app.post_an_ad')</a></li>
                    @endif
                    @if(get_option('show_blog_in_header'))
                        <li><a href="{{ route('blog') }}"> <i class="fa fa-rss"></i> @lang('app.blog')</a></li>
                    @endif
                    <li><a href="{{ route('contact_us_page') }}"> <i class="fa fa-mail-forward"></i>@lang('app.contact_us')</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>

<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(get_option('logo_settings') == 'show_site_name')
                    {{ get_option('site_name') }}
                @else
                    @if(logo_url())
                        <img src="{{ logo_url() }}">
                    @else
                        {{ get_option('site_name') }}
                    @endif
                @endif

            </a>
        </div>
        @if (\Request::route()->getName() == 'home')
        <div class="navbar-form navbar-right">
            <form class="form-inline-block" action="{{ route('listing') }}" method="get">
                <div class="form-group">
                    <input type="text" class="form-control" id="searchTerms" name="q" value="{{ request('q') }}" placeholder="@lang('app.search___')" />
                </div>
                <button type="submit" class="btn theme-btn"> <i class="fa fa-search"></i> @lang('app.search_product')</button>
            </form>
        </div>
        @endif
    </div>
</nav>
