<div class="@if ($pageType !== 'home') col-md-3 col-sm-6 col-xs-12 owl-carousel @endif">
    <div itemscope itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-{{$ad->price_plan}}">

        <meta itemprop="name" content="{{$ad->title}}" />
        <meta itemprop="description" content="{{strip_tags($ad->description)}}" />

        <div class="ads-thumbnail @if ($pageType !== 'home') owl-item @endif">
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

        <div class="caption" itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
            <link itemprop="url" href="{{ route('listing', ['category' => $ad->category->id]) }}" />
            <meta itemprop="availability" content="https://schema.org/InStock" />
            <meta itemprop="priceCurrency" content="VND" />
            <meta itemprop="itemCondition" content="https://schema.org/UsedCondition" />
            <meta itemprop="price" content="{{$ad->price}}" />
            <meta itemprop="priceValidUntil" content="{{date('Y-m-d', strtotime('+5 years'))}}" />
            <div itemprop="seller" itemtype="http://schema.org/Organization" itemscope>
                <meta itemprop="name" content="{{$ad->seller_name}}" />
            </div>
            <h4>
                <a href="{{ route('single_ad', $ad->slug) }}" title="{{ $ad->title }}">
                    <span class="text-info">{{ str_limit($ad->title, 60) }} </span>
                </a>
            </h4>
            <p>
                <a class="price text-muted" href="{{ route('listing', ['category' => $ad->category->category_slug]) }}">
                    <i class="fa fa-folder-o"></i>
                    {{ $ad->category->category_name }}
                </a>

                @if($ad->country)
                    <a class="location text-muted" href="{{ route('listing', ['country' => $ad->country->country_name]) }}">
                        <i class="fa fa-location-arrow"></i>
                        {{ $ad->country->country_name }}
                    </a>
                @endif
            </p>
            <p class="text-muted">
                <a href="{{ route('listing', ['user_id' => $ad->user_id]) }}">{{ $ad->seller_name }}</a>
            </p>
            <p class="date-posted text-muted hidden">
                <i class="fa fa-clock-o"></i>
                {{ $ad->created_at->diffForHumans() }}
            </p>
            <p class="price">
                <span class="@if ($ad->discount_price > 0) text-decorate-line-thought text-info @endif" itemprop="price" content="{{$ad->price}}">
                    {{ themeqx_price_ng(number_format($ad->price), $ad->is_negotiable) }}
                </span>&nbsp;
                @if ($ad->discount_price > 0)
                    <span class="text-danger">-{{ number_format(100 - ($ad->discount_price / $ad->price * 100)) }}%</span><br/>
                @endif
            </p>
            @if ($ad->discount_price > 0)
                <p class="price text-danger">
                    <span itemprop="price" content="{{$ad->discount_price}}">
                        {{ themeqx_price_ng(number_format($ad->discount_price), $ad->is_negotiable) }}
                    </span>
                </p>
            @endif
        </div>
        <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
            <meta itemprop="reviewCount" content="89" />
            <meta itemprop="ratingValue" content="4.4" />
        </div>
        <div itemprop="review" itemtype="http://schema.org/Review" itemscope>
            <div itemprop="author" itemtype="http://schema.org/Person" itemscope>
                <meta itemprop="name" content="{{$ad->seller_name}}" />
            </div>
            <div itemprop="reviewRating" itemtype="http://schema.org/Rating" itemscope>
                <meta itemprop="ratingValue" content="4" />
                <meta itemprop="bestRating" content="5" />
            </div>
        </div>
        <meta itemprop="sku" content="{{$ad->sku}}" />
        <div itemprop="brand" itemtype="http://schema.org/Thing" itemscope>
            <meta itemprop="name" content="{{$ad->brand->brand_name}}" />
        </div>
        <div class="caption btn-order">
            {{--<a type="button" href="{{ route('order', [$ad->id]) }}" class="btn btn-info theme-btn btn-xl font-weight-bold text-capitalize">--}}
                {{--<span>{{ trans('app.order_quickly') }}</span>--}}
            {{--</a>--}}
            <a type="button" target="_blank" href="https://m.me/xachtayonlinevn.vn/" class="btn btn-info theme-btn btn-xl font-weight-bold text-capitalize">
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