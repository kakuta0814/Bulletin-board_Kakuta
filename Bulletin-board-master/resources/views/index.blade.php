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
        @endforeach
    @endif
</div>
@endsection
