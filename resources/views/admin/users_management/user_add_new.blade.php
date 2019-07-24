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
                    <div class="col-md-10 col-xs-12">

                        {{ Form::open(['url' => route('users_admin_add_new'), 'method' => 'post' ,'class' => 'form-horizontal', 'files' => true]) }}

                        <legend>Thông tin user</legend>

                        <div class="form-group {{ $errors->has('first_name')? 'has-error':'' }}">
                            <label for="first_name" class="col-sm-4 control-label">@lang('app.first_name')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="first_name" value="{{ old('first_name') ? old('first_name') : '' }}" name="first_name" placeholder="@lang('app.first_name')">
                                {!! $errors->has('first_name') ? '<p class="help-block">' . $errors->first('first_name') . '</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('last_name')? 'has-error':'' }}">
                            <label for="last_name" class="col-sm-4 control-label">@lang('app.last_name')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="last_name" value="{{ old('last_name') ? old('last_name') : '' }}" name="last_name" placeholder="@lang('app.last_name')">
                                {!! $errors->has('last_name')? '<p class="help-block">'.$errors->first('last_name').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email')? 'has-error':'' }}">
                            <label for="email" class="col-sm-4 control-label">@lang('app.email')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" value="{{ old('email') ? old('email') : '' }}" name="email" placeholder="@lang('app.email')">
                                {!! $errors->has('email')? '<p class="help-block">'.$errors->first('email').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password')? 'has-error':'' }}">
                            <label for="password" class="col-sm-4 control-label">@lang('app.password')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="password" value="{{ old('password') ? old('password') : '' }}" name="password" placeholder="@lang('app.password')">
                                {!! $errors->has('password')? '<p class="help-block">'.$errors->first('password').'</p>':'' !!}
                            </div>
                        </div>

                        <legend>@lang('app.location_info')</legend>

                        <div class="form-group  {{ $errors->has('country')? 'has-error':'' }}">
                            <label for="category_name" class="col-sm-4 control-label">@lang('app.country')</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="country">
                                    <option value="">@lang('app.select_a_country')</option>

                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('country')? '<p class="help-block">'.$errors->first('country').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('mobile')? 'has-error':'' }}">
                            <label for="mobile" class="col-sm-4 control-label">@lang('app.mobile')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="phone" value="{{ old('mobile') ? old('mobile') : '' }}" name="mobile" placeholder="@lang('app.mobile')">
                                {!! $errors->has('mobile')? '<p class="help-block">'.$errors->first('mobile').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('phone')? 'has-error':'' }}">
                            <label for="phone" class="col-sm-4 control-label">@lang('app.phone')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="phone" value="{{ old('phone') ? old('phone') : '' }}" name="phone" placeholder="@lang('app.phone')">
                                {!! $errors->has('phone')? '<p class="help-block">'.$errors->first('phone').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('gender')? 'has-error':'' }}">
                            <label for="gender" class="col-sm-4 control-label">@lang('app.gender')</label>
                            <div class="col-sm-8">
                                <select id="gender" name="gender" class="form-control select2">
                                    <option value="">Chọn giới tính</option>
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                    <option value="third_gender">Khác</option>
                                </select>
                                {!! $errors->has('gender')? '<p class="help-block">'.$errors->first('gender').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address')? 'has-error':'' }}">
                            <label for="address" class="col-sm-4 control-label">@lang('app.address')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="phone" value="{{ old('address') ? old('address') : '' }}" name="address" placeholder="@lang('app.address')">
                                {!! $errors->has('address')? '<p class="help-block">'.$errors->first('address').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('website')? 'has-error':'' }}">
                            <label for="website" class="col-sm-4 control-label">@lang('app.website')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="website" value="{{ old('website') ? old('website') : '' }}" name="website" placeholder="@lang('app.website')">
                                {!! $errors->has('website')? '<p class="help-block">'.$errors->first('website').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('photo')? 'has-error':'' }}">
                            <label class="col-sm-4 control-label">@lang('app.change_avatar')</label>
                            <div class="col-sm-8">
                                <input type="file" id="photo" name="photo" class="filestyle" >
                                {!! $errors->has('photo')? '<p class="help-block">'.$errors->first('photo').'</p>':'' !!}
                            </div>
                        </div>

                        <input type="hidden" name="user_type" value="{{ $userType }}" />

                        <hr />

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary">@lang('app.edit_user')</button>
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