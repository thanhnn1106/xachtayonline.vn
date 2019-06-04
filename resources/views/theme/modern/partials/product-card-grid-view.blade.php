<tr class="ad-{{ $ad->price_plan }}">
    <td width="100">
        <img src="{{ media_url($ad->feature_img) }}" class="img-responsive" alt="">
        <span class="modern-img-indicator">
            @if(! empty($ad->video_url))
                <i class="fa fa-file-video-o"></i>
            @else
                <i class="fa fa-file-image-o"> {{ $ad->media_img->count() }}</i>
            @endif
        </span>
    </td>
    <td>
        <h5><a href="{{ route('single_ad', $ad->slug) }}" >{{ $ad->title }}</a> </h5>
        <p class="text-muted">
            <a class="price text-muted" href="{{ route('listing', ['category' => $ad->category->id]) }}">
                <i class="fa fa-folder-o"></i>
                {{ $ad->category->category_name }}
            </a>
            @if($ad->country)
                <i class="fa fa-map-marker"></i>
                <a class="location text-muted" href="{{ route('listing', ['country'=>$ad->country->id]) }}">
                    {{ $ad->country->country_name }}
                </a>
            @endif
            <p class="hidden">
                <i class="fa fa-clock-o"></i> {{ $ad->created_at->diffForHumans() }}
            </p>
        </p>
        <p class="text-muted">
            <a href="{{ route('listing', ['user_id' => $ad->user_id]) }}">{{ $ad->seller_name }}</a>
        </p>
    </td>
    <td>

        <h5>
            <span class="@if($ad->discount_price > 0) text-decorate-line-thought text-info @endif">
                {{ themeqx_price_ng(number_format($ad->price)) }}
            </span>&nbsp;
            @if($ad->discount_price > 0)
                <span class="text-danger">
                    -{{ number_format(100 - ($ad->discount_price / $ad->price * 100)) }}%
                </span><br/>
            @endif
        </h5>
        @if($ad->discount_price > 0)
            <h5 class="text-danger">{{ themeqx_price_ng(number_format($ad->discount_price)) }}</h5>
        @endif
        @if($ad->price_plan == 'premium')
            <div class="ribbon-green-bar">{{ ucfirst($ad->price_plan) }}</div>
        @endif
        @if($ad->mark_ad_urgent == '1')
            <div class="ribbon-red-bar">@lang('app.urgent')</div>
        @endif
        <div class="caption btn-order-grid">
            <a type="button" href="{{ route('order', [$ad->id]) }}" class="btn btn-info theme-btn btn-xl font-weight-bold text-capitalize">
                <span>{{ trans('app.order_quickly') }}</span>
            </a>
        </div>
    </td>
</tr>