@extends('layout.main')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('page-css')
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" />
@stop


@section('main')

    <div class="container">

        <div id="wrapper">

            @include('admin.sidebar_menu')

            <div id="page-wrapper">
                @if( ! empty($title))
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"> {{ $title }}
                                <a href="{{ route('users_add_new', ['userType' => 'seller']) }}" class="btn theme-btn">Thêm mới</a>
                            </h1>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                @endif

                @include('admin.flash_msg')


                <div class="row">
                    <div class="col-xs-12">

                        <table class="table table-bordered table-striped" id="jDataTable">
                            <thead>
                                <tr>
                                    <th>@lang('app.name')</th>
                                    <th>@lang('app.email')</th>
                                    <th>@lang('app.mobile')</th>
                                    <th>@lang('app.created_at')</th>
                                    <th>@lang('app.actions')</th>
                                </tr>
                            </thead>

                        </table>

                    </div>
                </div>




            </div>   <!-- /#page-wrapper -->




        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->
@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#jDataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: '{{ route('get_users_data', ['userType' => 'seller']) }}',
                language: {
                    url : '//cdn.datatables.net/plug-ins/1.10.10/i18n/Vietnamese.json'
                },
                "aaSorting": []
            });
        });

        function updateUserStatus(obj)
        {
            var selector = $(obj);
            var userId = selector.data('user-id');
            var userStatus = selector.data('user-status');
            $.ajax({
                url: '{{ route('update_user_status') }}',
                type: "POST",
                data: {user_id: userId, status: userStatus, _token: '{{ csrf_token() }}'},
                success: function (data) {
                    if (data.success == 1) {
                        var html = '';
                        if (userStatus == 1) {
                            html = '<a href="#" onclick="updateUserStatus(this)" class="btn btn-warning blockUser" data-user-id="' + userId + '" data-user-status="2"><i class="fa fa-ban"></i></a>';
                        } else {
                            html = '<a href="#" onclick="updateUserStatus(this)" class="btn btn-success activeUser" data-user-id="' + userId + '" data-user-status="1"><i class="fa fa-check-circle-o"></i></a>';
                        }
                        selector.closest('a').replaceWith(html);

                        toastr.success(data.msg, '@lang('app.success')', toastr_options);
                    }
                }
            });
        }

        function deleteUser(obj)
        {
            if (!confirm('{{ trans('app.are_you_sure') }}')) {
                return 0;
            }
            var selector = $(obj);
            var userId = selector.data('user-id');
            console.log(userId);
            $.ajax({
                url: '{{ route('delete_user') }}',
                type: "POST",
                data: {user_id: userId, _token: '{{ csrf_token() }}'},
                success: function (data) {
                    if (data.success == 1) {
                        selector.closest('tr').hide('slow');
                        toastr.success(data.msg, '@lang('app.success')', toastr_options);
                    }
                }
            });
        }

    </script>
    <script>
        @if(session('success'))
        toastr.success('{{ session('success') }}', '{{ trans('app.success') }}', toastr_options);
        @endif
        @if(session('error'))
        toastr.error('{{ session('error') }}', '{{ trans('app.success') }}', toastr_options);
        @endif
    </script>
@endsection