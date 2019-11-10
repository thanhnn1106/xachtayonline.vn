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

                <div class="row">
                    <div class="col-xs-12">

                        {{ Form::open(['class' => 'form-horizontal']) }}

                        <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
                            <div class="col-sm-12">
                                <label>@lang('app.shipping_fee_name')</label>
                                <input type="text" class="form-control" id="title" value="{{ old('name') }}" name="name">
                                {!! $errors->has('name')? '<p class="help-block">'.$errors->first('name').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('fee')? 'has-error':'' }}">
                            <div class="col-sm-12">
                                <label>@lang('app.shipping_fee')</label>
                                <input type="text" class="form-control" id="title" value="{{ old('fee') }}" name="fee">
                                {!! $errors->has('fee')? '<p class="help-block">'.$errors->first('fee').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('discount')? 'has-error':'' }}">
                            <div class="col-sm-12">
                                <label>@lang('app.shipping_fee_discount')</label>
                                <input type="text" class="form-control" id="title" value="{{ old('discount') }}" name="discount">
                                {!! $errors->has('discount')? '<p class="help-block">'.$errors->first('discount').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">@lang('app.save')</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>   <!-- /#page-wrapper -->
        </div>   <!-- /#wrapper -->
    </div> <!-- /#container -->
@endsection
