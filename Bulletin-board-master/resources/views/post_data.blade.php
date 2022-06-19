@extends('layouts.login')

@section('content')



    <div class="container">
        投稿者:{{ $post->user_id }}<br>
        タイトル:{{ $post->title }}<br>
        投稿内容:{{ $post->post }}<br>
        <a href="{{ route('post_update_form',['post_id'=>$post->id]) }}">
            <div class="btn btn-danger">編集</div>
        </a><br>

        @if(auth()->user())
            @if(isset($post->like_products[0]))
                <a class="toggle_wish" post_id="{{ $post->id }}" like_product="1">
                    <i class="fas fa-heart"></i>
                </a>
            @else
                <a class="toggle_wish" post_id="{{ $post->id }}" like_product="0">
                    <i  class="far fa-heart"></i>
                </a>
            @endif
        @endif





        @foreach ($post_comments as $comment)
        -----------------------------------<br>
            ユーザーid:{{ $comment->user_id }}<br>
            投稿日時:{{ $comment->created_at }}<br>
            コメント:{{ $comment->comment }}<br>
            <a href="{{ route('comment_update_form',['comment_id'=>$comment->id]) }}">
            <div class="btn btn-danger">編集</div>
        </a><br>
        @endforeach

        {!! Form::open() !!}

            {{ Form::textarea('comment_create',null,['class' => 'input form-space', 'placeholder' => 'コチラからコメントできます', 'cols'=>'70' , 'rows' => '5']) }}

            {{ Form::submit('コメント',['class' => 'btn btn-primary']) }}

        {!! Form::close() !!}
    </div><br>
@endsection
