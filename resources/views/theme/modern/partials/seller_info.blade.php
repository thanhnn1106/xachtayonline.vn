<div class="col-sm-4 col-xs-12">
    <div class="sidebar-widget">
        @if($enable_monetize)
            {!! get_option('monetize_code_above_seller_info') !!}
        @endif

        <h3>@lang('app.seller_info')</h3>
        <div class="sidebar-user-info">
            <div class="row">
                <div class="col-xs-3">
                    <img src="{{ $ad->user->get_gravatar() }}" class="img-circle img-responsive" />
                </div>
                <div class="col-xs-9">
                    <h5>{{ $ad->user->name }}</h5>
                    <p class="text-muted"><i class="fa fa-map-marker"></i> {{ $ad->user->get_address()}}</p>
                </div>
            </div>
        </div>

        <div class="sidebar-user-link">
            <button class="btn btn-block" id="onClickShowPhone">
                <strong> <span id="ShowPhoneWrap"></span> </strong> <br />
                <span class="text-muted">@lang('app.click_to_show_phone_number')</span>
            </button>

            {{--@if($ad->user->email)--}}
                {{--<button class="btn btn-block" data-toggle="modal" data-target="#replyByEmail">--}}
                    {{--<i class="fa fa-envelope-o"> @lang('app.reply_by_email')</i>--}}
                {{--</button>--}}
            {{--@endif--}}

            <ul class="ad-action-list">
                <li><a href="{{ route('listing', ['user_id'=>$ad->user_id]) }}"><i class="fa fa-user"></i> @lang('app.more_ads_by_this_seller')</a></li>
                <li><a href="javascript:;" id="save_as_favorite" data-slug="{{ $ad->slug }}">
                        @if( ! $ad->is_my_favorite())
                            <i class="fa fa-star-o"></i> @lang('app.save_ad_as_favorite')
                        @else
                            <i class="fa fa-star"></i> @lang('app.remove_from_favorite')
                        @endif
                    </a></li>
                <li><a href="#" data-toggle="modal" data-target="#reportAdModal"><i class="fa fa-ban"></i> @lang('app.report_this_ad')</a></li>
            </ul>

        </div>

        @if($enable_monetize)
            {!! get_option('monetize_code_below_seller_info') !!}
        @endif

    </div>

</div>
