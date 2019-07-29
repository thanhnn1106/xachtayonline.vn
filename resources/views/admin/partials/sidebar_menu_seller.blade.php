<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="parent-menu">
                <a class="text-center">QUẢN LÝ KHÁCH HÀNG</a>
            </li>
            <li> <a href="{{ route('order_history') }}"><i class="fa fa-money"></i> @lang('app.order_history')</a>  </li>
            <li> <a href="{{ route('profile') }}"><i class="fa fa-user"></i> @lang('app.profile')</a>  </li>
            <li> <a href="{{ route('change_password') }}"><i class="fa fa-lock"></i> @lang('app.change_password')</a>  </li>

            <li> <a href="{{ route('users') }}"><i class="fa fa-users"></i> @lang('app.users_management')</a>  </li>
            <li class="parent-menu">
                <a class="text-center">QUẢN LÝ SẢN PHẨM</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bullhorn"></i> @lang('app.my_ads')<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>  <a href="{{ route('my_ads') }}">@lang('app.my_ads')</a> </li>
                    <li>  <a href="{{ route('create_ad') }}">@lang('app.post_an_ad')</a> </li>
                    <li>  <a href="{{ route('pending_ads') }}">@lang('app.pending_for_approval')</a> </li>
                    <li>  <a href="{{ route('favorite_ads') }}">@lang('app.favourite_ads')</a> </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
