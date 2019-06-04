<div class="@if ($pageType !== 'home') col-md-4 col-sm-6 col-xs-12 owl-carousel @endif">
    <div itemscope itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-{{$ad->price_plan}}">
        <div class="ads-thumbnail owl-item">
            <a href="{{ route('single_ad', $ad->slug) }}">
                <img itemprop="image" src="{{ media_url($ad->feature_img) }}" class="img-responsive"
                     alt="{{ $ad->title }}">

                <span class="modern-img-indicator">
                    @if(! empty($ad->video_url))
                        <i class="fa fa-file-video-o"></i>
                    @else
                        <i class="fa fa-file-image-o"> {{ $ad->media_img->count() }}</i>
                    @endif
                </span>
            </a>
        </div>

        <div class="caption">
            <h4>
                <a href="{{ route('single_ad', $ad->slug) }}" title="{{ $ad->title }}">
                    <span itemprop="name">{{ str_limit($ad->title, 40) }} </span>
                </a>
            </h4>
            <a class="price text-muted" href="{{ route('listing', ['category' => $ad->category->id]) }}">
                <i class="fa fa-folder-o"></i>
                {{ $ad->category->category_name }}
            </a>

            @if($ad->country)
                <a class="location text-muted" href="{{ route('listing', ['country' => $ad->country->id]) }}">
                    <i class="fa fa-location-arrow"></i>
                    {{ $ad->country->country_name }}
                </a>
            @endif
            <p class="date-posted text-muted hidden">
                <i class="fa fa-clock-o"></i>
                {{ $ad->created_at->diffForHumans() }}
            </p>
            <p class="price">
                <span class="@if ($ad->discount_price > 0) text-decorate-line-thought text-info @endif" itemprop="price" content="{{$ad->price}}">
                    {{ themeqx_price_ng(number_format($ad->price), $ad->is_negotiable) }}
                </span>&nbsp;
                @if ($ad->discount_price > 0)
                    <span class="text-danger">-{{ number_format(100 - ($ad->discount_price / $ad->price * 100)) }}%</span>
                @endif
            </p>
            @if ($ad->discount_price > 0)
                <p class="price text-danger">
                    <span itemprop="price" content="{{$ad->discount_price}}">
                        {{ themeqx_price_ng(number_format($ad->discount_price), $ad->is_negotiable) }}
                    </span>
                </p>
            @endif
            <link itemprop="availability" href="http://schema.org/InStock"/>
        </div>
        <div class="caption btn-order">
            <a type="button" href="{{ route('order', [$ad->id]) }}" class="btn btn-info btn-xl font-weight-bold text-capitalize">
                <span>{{ trans('app.order_quickly') }}</span>
            </a>
        </div>
        @if($ad->price_plan == 'premium')
            <div class="ribbon-wrapper-green">
                <div class="ribbon-green">{{ ucfirst($ad->price_plan) }}</div>
            </div>
        @endif
        @if($ad->mark_ad_urgent == '1')
            <div class="ribbon-wrapper-red">
                <div class="ribbon-red">@lang('app.urgent')</div>
            </div>
        @endif
    </div>
</div>