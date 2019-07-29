@if(get_option('modern_category_display_style') == 'show_top_category')
    <div class="modern-home-cat-wrap">
        <ul class="modern-home-cat-ul">
            @foreach($top_categories as $category)
                <li><a href="{{ route('listing') }}?category={{$category->id}}">
                        <i class="fa {{ $category->fa_icon }}"></i>
                        <span class="category-name">{{ $category->category_name }} </span>
                        <p class="count text-muted">({{ number_format($category->product_count) }})</p>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <div class="modern-home-cat-with-sub-wrap">

        @foreach($top_categories as $category)
            @if ($category->category_slug !== 'danh-muc-khac')
                <div class="modern-cat-list-with-sub-wrap">
                    <div class="modern-home-cat-top-item">
                        <a href="{{ route('listing') }}?category={{$category->id}}">
                            <i class="fa {{ $category->fa_icon }}"></i>
                            <span class="category-name"><strong>{{ $category->category_name }}</strong> </span>
                        </a>
                    </div>

                    <div class="modern-home-cat-sub-item">
                        @if($category->sub_categories->count())
                            <ul class="list-unstyled">

                                @foreach($category->sub_categories as $s_cat)

                                    <li><a href="{{ route('listing') }}?category={{$category->id}}&sub_category={{$s_cat->id}}">
                                            <i class="fa fa-arrow-right"></i> {{ $s_cat->category_name }}
                                        </a></li>
                                @endforeach
                            </ul>

                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endif
        @endforeach
        @foreach($top_categories as $category)
            @if ($category->category_slug == 'danh-muc-khac')
                <div class="modern-cat-list-with-sub-wrap">
                    <div class="modern-home-cat-top-item">
                        <a href="{{ route('listing') }}?category={{$category->id}}">
                            <i class="fa {{ $category->fa_icon }}"></i>
                            <span class="category-name"><strong>{{ $category->category_name }}</strong> </span>
                        </a>
                    </div>

                    <div class="modern-home-cat-sub-item">
                        @if($category->sub_categories->count())
                            <ul class="list-unstyled">

                                @foreach($category->sub_categories as $s_cat)

                                    <li><a href="{{ route('listing') }}?category={{$category->id}}&sub_category={{$s_cat->id}}">
                                            <i class="fa fa-arrow-right"></i> {{ $s_cat->category_name }}
                                        </a></li>
                                @endforeach
                            </ul>

                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endif
        @endforeach
    </div>
@endif
