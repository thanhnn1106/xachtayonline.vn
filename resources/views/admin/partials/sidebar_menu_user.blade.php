<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="parent-menu">
                <a class="text-center">QUẢN LÝ THÔNG TIN CÁ NHÂN</a>
            </li>
            <li> <a href="{{ route('order_history') }}"><i class="fa fa-money"></i> @lang('app.order_history')</a>  </li>
            <li> <a href="{{ route('profile') }}"><i class="fa fa-user"></i> @lang('app.profile')</a>  </li>
            <li> <a href="{{ route('change_password') }}"><i class="fa fa-lock"></i> @lang('app.change_password')</a>  </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
