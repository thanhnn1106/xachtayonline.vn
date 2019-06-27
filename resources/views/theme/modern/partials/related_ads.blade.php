@if($related_ads->count() > 0 && get_option('enable_related_ads') == 1)
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="carousel-header">
                    <h4><a href="{{ route('listing') }}">
                            @lang('app.new_premium_ads')
                        </a>
                    </h4>
                </div>
                <hr />
                <div class="themeqx_new_regular_ads_wrap themeqx-carousel-ads">
                    @foreach($related_ads as $rad)
                        @include('theme.modern.partials.product-card', ['pageType' => 'home', 'ad' => $rad])
                    @endforeach
                </div> <!-- themeqx_new_premium_ads_wrap -->
            </div>

        </div>
    </div>
@endif