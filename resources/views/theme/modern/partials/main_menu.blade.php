<!-- CSS Stylesheet -->
<link href="{{ asset('assets/css/horizontal-menu-1.css') }}" rel="stylesheet" id="menucss">

<style>
    .jumbotron {
        margin: 0px !important;
        padding: 0px !important;
    }
    .navbar {
        position: relative;
        min-height: 50px;
        margin-bottom: 0px;
        border: 1px solid transparent;
    }
    .navbar-nav {
        text-align: center;
    }
    .dropdown-menu li>a:hover {
        background-color: #ea9b27
    }
    .animatedParent {
        width: 70%;
    }
    .navbar-collapse {
        font-size: 1.2em;
    }
    .animatedParent {
        width: 100%;
        display: flex;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .navbar-nav.navbar-center {
            position: absolute;
            left: 50%;
            transform: translatex(-50%);
        }
    }
</style>

<div class="big-menu">
    <div class="jumbotron">
        <!--Bootstrap container start-->
        <div align="center">
            <!--start Navbar navigation-->
            <nav class="navbar navbar-default horizontal-menu" role="navigation">
                <div class="container" style="width: 100%;">
                    <div class="navbar-header">
                        <button type="button" data-toggle="collapse" data-target="#defaultmenu" class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                    </div>
                    <!-- End navbar-header -->
                    <div id="defaultmenu" class="navbar-collapse collapse">
                        <!-- animated Parent start -->
                        <div class="animatedParent">
                            <ul class="nav navbar-nav">
                                <li class="horizontal-menu-fw">
                                    <a href="{{ route('home') }}" class="">
                                        <i class="fa fa-home" style="color:#fff;"></i>
                                    </a>
                                </li>
                                <!-- list elements start -->
                                @foreach($top_categories as $category)
                                <li class="dropdown">
                                    <a href="{{ route('listing') }}?category={{$category->id}}" data-toggle="dropdown" class="dropdown-toggle">
                                        <i class="fa fa-life-ring"></i> {{ $category->category_name }}
                                    </a>
                                    {{--{{dump($category->sub_categories->count())}}--}}
                                    @if($category->sub_categories->count())
                                    <ul class="dropdown-menu" role="menu">
                                        @foreach($category->sub_categories as $s_cat)
                                        <li>
                                            <a href="{{ route('listing') }}?category={{$category->category_slug}}&sub_category={{$s_cat->category_slug}}">
                                                {{ $s_cat->category_name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <!-- end dropdown-submenu -->
                                    @endif
                                    <!-- end dropdown-menu -->
                                </li>
                                @endforeach
                                <li class="dropdown">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                        <i class="fa fa-life-ring"></i> HOT SALE
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- end list elements -->
                                <!-- end social drop down -->
                            </ul>
                            <!-- end nav navbar-nav -->
                        </div>
                        <!-- end nav navbar-nav navbar-right -->
                    </div>
                </div>
                <!-- end navbar  -->
            </nav>

            <!-- end navbar navbar-default horizontal-menu -->
        </div>
        <!--Bootstrap container End-->
    </div>
</div>
