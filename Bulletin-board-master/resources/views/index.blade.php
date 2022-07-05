@extends('layouts.login')
@section('content')

<div class="container">
    @if(isset($all_posts))
        @foreach ($all_posts as $post)
            投稿者:{{ $post->user_id }}
            <a href="{{ route('post_data',['post_id'=>$post->id]) }}">
                <div>タイトル:{{ $post->title }}</div>
            </a>
            投稿内容:{{ $post->post }}<br>

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
