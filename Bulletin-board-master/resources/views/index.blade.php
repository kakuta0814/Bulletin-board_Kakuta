@extends('layouts.login')



@section('content')
<div id="accordion" class="accordion-container">
@foreach ($all_categories as $category)

            <h4 class="accordion-title js-accordion-title">{{ $category->main_category }}</h4>
            @if($category->postSubCategories->isEmpty())
            <br>
            @endif
            <div class="accordion-content">
                @foreach ($category->postSubCategories as $sub)
                <a href=""><div class="nav-item">{{ $sub->sub_category }}</div></a>
                @endforeach
            </div><!--/.accordion-content-->

@endforeach
</div><!--/#accordion-->
@foreach ($all_categories as $category)
        {{ $category->main_category }}
        @if($category->postSubCategories->isEmpty())
        <br>
        @endif
        <br>
        @foreach ($category->postSubCategories as $sub)
                {{ $sub->sub_category }}<br>
        @endforeach<br>
@endforeach

<div class="container">
    @if(isset($all_posts))
        @foreach ($all_posts as $post)
            投稿者:{{ $post->user_id }}
            <a href="{{ route('post_data',['post_id'=>$post->id]) }}">
                <div>タイトル:{{ $post->title }}</div>
            </a>
            投稿内容:{{ $post->post }}<br>
            閲覧数:{{ $post->action_logs_count }}

            @if(Auth::user()->isLikedBy($post->id))
                <span class="likes">
                    <i class="far fa-heart like-toggle liked" data-review-id="{{ $post->id }}"></i>
                <span class="like-counter">{{ $post->post_favorite_count }}</span>
                </span><!-- /.likes -->
            @else
                <span class="likes">
                    <i class="far fa-heart like-toggle" data-review-id="{{ $post->id }}"></i>
                <span class="like-counter">{{ $post->post_favorite_count }}</span>
                </span><!-- /.likes -->
            @endif
        @endforeach
    @endif
</div>
@endsection
