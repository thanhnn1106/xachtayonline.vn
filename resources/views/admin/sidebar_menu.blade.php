@if($lUser->is_admin())
    @include('admin.partials.sidebar_menu_admin')
@elseif ($lUser->is_seller())
    @include('admin.partials.sidebar_menu_seller')
@else
    @include('admin.partials.sidebar_menu_user')
@endif