@extends('layouts.login')

@section('content')
    <div class="container">
        投稿者:{{ $post_data->user_id }}<br>
        タイトル:{{ $post_data->title }}<br>
        投稿内容:{{ $post_data->post }}<br>
        <a href="{{ route('post_update_form',['post_id'=>$post_data->id]) }}">
            <div class="btn btn-danger">編集</div>
        </a><br>

        @foreach ($post_comments as $comment)
        -----------------------------------<br>
            ユーザーid{{ $comment->user_id }}<br>
            {{ $comment->created_at }}<br>
            {{ $comment->comment }}<br>
            <a href="{{ route('comment_update_form',['comment_id'=>$comment->id]) }}">
            <div class="btn btn-danger">編集</div>
        </a><br>

        @endforeach

        {!! Form::open() !!}

            {{ Form::textarea('comment_create',null,['class' => 'input form-space', 'placeholder' => 'コチラからコメントできます', 'cols'=>'70' , 'rows' => '5']) }}

            {{ Form::submit('コメント',['class' => 'btn btn-danger']) }}

        {!! Form::close() !!}
    </div><br>
@endsection
