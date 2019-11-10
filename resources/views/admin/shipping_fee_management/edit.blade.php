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
                    <div class="col-sm-8 col-sm-offset-1 col-xs-12">
                        {{ Form::open(['class' => 'form-horizontal']) }}
                        <input type="hidden" name="id" value="{{$shippingFeeInfo->id}}" />
                        <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
                            <label for="name" class="col-sm-4 control-label">@lang('app.shipping_fee_name')</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name" class="form-control" rows="6" value="{{ old('name')? old('name') : $shippingFeeInfo->name }}" />
                                {!! $errors->has('name')? '<p class="help-block">'.$errors->first('name').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('fee')? 'has-error':'' }}">
                            <label for="fee" class="col-sm-4 control-label">@lang('app.shipping_fee')</label>
                            <div class="col-sm-8">
                                <input type="text" name="fee" id="fee" class="form-control" rows="6" value="{{ old('fee')? old('fee') : $shippingFeeInfo->fee }}" />
                                {!! $errors->has('fee')? '<p class="help-block">'.$errors->first('fee').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('discount')? 'has-error':'' }}">
                            <label for="discount" class="col-sm-4 control-label">@lang('app.shipping_fee_discount')</label>
                            <div class="col-sm-8">
                                <input type="text" name="discount" id="discount" class="form-control" rows="6" value="{{ old('discount')? old('discount') : $shippingFeeInfo->discount }}" />
                                {!! $errors->has('discount')? '<p class="help-block">'.$errors->first('discount').'</p>':'' !!}

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
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

@section('page-js')

@endsection