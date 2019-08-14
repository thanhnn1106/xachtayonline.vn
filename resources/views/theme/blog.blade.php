@extends('layout.main')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('main')

    <div class="container">
        <div class="row">
            <div class="blog-breadcrumb pull-left">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('home') }}">@lang('app.home')</a>
                    </li>
                    <li>
                        <span>@lang('app.trend')</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <h2>{{ $title }}</h2>
        <div class="row">
            <div id="blog-listing" class="col-md-10 col-sm-12">
                @foreach($posts as $post)

                    <section class="post">
                        <div class="row">

                            <div itemscope itemtype="http://schema.org/NewsArticle">
                                <div class="col-md-4">
                                    <div class="image" style="height: 196px;">
                                        <a href="{{ route('blog_single', $post->slug) }}" rel="follow">
                                            @if($post->feature_img)
                                                <img class="img-responsive" alt="{{ $post->title }}" src="{{ media_url($post->feature_img, false, 'blog-images') }}">
                                            @else
                                                <img class="img-responsive" alt="{{ $post->title }}" src="{{ asset('uploads/placeholder.png') }}">
                                            @endif
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h2 itemprop="headline"><a href="{{ route('blog_single', $post->slug) }}" class="blog-title" rel="follow">{{ $post->title }}</a></h2>
                                    <div class="clearfix">
                                        @if($post->author)
                                            <p class="author-category"  itemprop="author" itemscope itemtype="https://schema.org/Person">By <a href="{{ route('author_blog_posts', $post->author->id) }}"  itemprop="name" rel="follow">{{ $post->author->name }}</a>
                                            </p>
                                        @endif
                                        <p class="date-comments">
                                            <i class="fa fa-eye"></i> Đã xem: {{ $post->viewed }}  -
                                            <i class="fa fa-calendar"></i>   {{ $post->created_at_datetime() }}
                                        </p>
                                    </div>
                                    <p class="intro" itemprop="description"> {!! words_limit(strip_tags($post->post_content), 50) !!} </p>
                                    <p class="read-more"><a href="{{ route('blog_single', $post->slug) }}" class="btn btn-template-main" rel="follow">@lang('app.continue_reading')</a></p>
                                    <p></p>
                                </div>

                                <meta itemprop="datePublished" content="{{ $post->created_at->toW3cString() }}"/>
                            </div>
                        </div>
                    </section>
                @endforeach

            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}', '<?php echo trans('app.success') ?>', toastr_options);
        @endif
    </script>
@endsection