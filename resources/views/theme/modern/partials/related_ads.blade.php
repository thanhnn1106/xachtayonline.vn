@if($related_ads->count() > 0 && get_option('enable_related_ads') == 1)
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="carousel-header">
                    <h4>
                        <a href="{{ route('listing') }}">
                            SẢN PHẨM LIÊN QUAN
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
    <script>
        $(document).ready(function(){
            $(".themeqx_new_regular_ads_wrap").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });
    </script>
@endif
