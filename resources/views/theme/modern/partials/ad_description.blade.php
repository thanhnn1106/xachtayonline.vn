<div class="col-sm-8 col-xs-12">
    <div class="ads-detail bg-white">
        <h2 class="ads-detail-title">THÔNG TIN SẢN PHẨM</h2>
        <p> {!! nl2br($ad->content) !!} </p>

        @if($enable_monetize)
            {!! get_option('monetize_code_below_ad_description') !!}
        @endif
    </div>
</div>
