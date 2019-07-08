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
                            <h1 class="page-header"> {{ $title }}  </h1>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                @endif

                @include('admin.flash_msg')
                {{ Form::open(['class' => 'form-horizontal']) }}
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered">
                            <tr>
                                <th>@lang('app.category_name') (@lang('app.total_products')) </th>
                                <th>Sắp xếp</th>
                            </tr>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <strong>{{ $category->category_name }} ({{ $category->product_count }})</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" name="{{ $category->id . '-order' }}" value="{{ $category->ordering }}" />
                                    </td>
                                </tr>
                                @if($category->sub_categories->count() > 0)
                                    @foreach($category->sub_categories as $sub_cat)
                                        <tr>
                                            <td>
                                                <div class="clearfix">
                                                    -- {{ $sub_cat->category_name }} ({{ $category->product_count }})
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" name="{{ $sub_cat->id . '-order' }}" value="{{ $sub_cat->ordering }}"/>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn theme-btn btn-block btn-group-lg" type="submit">Cập nhật</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{ Form::close() }}
            </div>   <!-- /#page-wrapper -->
        </div>   <!-- /#wrapper -->
    </div> <!-- /#container -->
@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            $('.btn-danger').on('click', function (e) {
                if (!confirm("Are you sure? its can't be undone")) {
                    e.preventDefault();
                    return false;
                }

                var selector = $(this);
                var data_id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('delete_categories') }}',
                    data: {data_id: data_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {
                            selector.closest('div').hide('slow');
                        }
                    }
                });
            });
        });
    </script>
@endsection