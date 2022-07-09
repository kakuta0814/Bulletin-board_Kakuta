@extends('layouts.login')

@section('content')



    <div class="container">
        投稿者:{{ $post->user_id }}<br>
        タイトル:{{ $post->title }}<br>
        投稿内容:{{ $post->post }}<br>
        閲覧数:{{ $view_count }}
        <a href="{{ route('post_update_form',['post_id'=>$post->id]) }}">
            <div class="btn btn-danger">編集</div>
        </a><br>

        @if(count($favorites_judge)===1)
            <span class="likes">
                <i class="far fa-heart like-toggle liked" data-review-id="{{ $post->id }}"></i>
                <span class="like-counter">{{ $favorites_count }}</span>
            </span>
        @elseif(count($favorites_judge)===0)
            <span class="likes">
                <i class="far fa-heart like-toggle" data-review-id="{{ $post->id }}"></i>
                <span class="like-counter">{{ $favorites_count }}</span>
            </span>
        @endif


        @foreach ($post_comments as $comment)
        -----------------------------------<br>
            ユーザーid:{{ $comment->user_id }}<br>
            投稿日時:{{ $comment->created_at }}<br>
            コメント:{{ $comment->comment }}<br>

            <a href="{{ route('comment_update_form',['comment_id'=>$comment->id]) }}">
            <div class="btn btn-danger">編集</div>
            </a><br>

            @if(Auth::user()->comment_isLikedBy($comment->id))
                <span class="likes">
                    <i class="far fa-heart like-comment-toggle liked" data-comment-id="{{ $comment->id }}"></i>
                    <span class="comment-like-counter">{{ $comment->comment_favorite_count }}</span>
                </span><!-- /.likes -->
            @else
                <span class="likes">
                    <i class="far fa-heart like-comment-toggle" data-comment-id="{{ $comment->id }}"></i>
                    <span class="like-counter">{{ $comment->comment_favorite_count }}</span>
                </span><!-- /.likes -->
            @endif

        @endforeach

        {!! Form::open() !!}

            {{ Form::textarea('comment_create',null,['class' => 'input form-space', 'placeholder' => 'コチラからコメントできます', 'cols'=>'70' , 'rows' => '5']) }}

            {{ Form::submit('コメント',['class' => 'btn btn-primary']) }}

        {!! Form::close() !!}
    </div><br>
@endsection
