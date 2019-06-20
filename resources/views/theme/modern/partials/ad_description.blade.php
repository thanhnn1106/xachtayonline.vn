<div class="col-sm-8 col-xs-12">
    <div class="ads-detail bg-white">
        <h4 class="ads-detail-title">@lang('app.description')</h4>
        <p> {!! nl2br($ad->content) !!} </p>

        @if($enable_monetize)
            {!! get_option('monetize_code_below_ad_description') !!}
        @endif
    </div>
</div>
