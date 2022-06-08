@extends('layouts.login')

@section('content')
    <div class="container">
      {!! Form::open() !!}

        {{ Form::label('投稿内容') }}
        {{ Form::text('comment',$comment_data->comment,['class' => 'input']) }}

        {{ Form::submit('更新',['class' => 'btn btn-danger']) }}

        <a href="">
            <div class="btn btn-danger">削除</div>
        </a>

        {!! Form::close() !!}

    </div><br>
@endsection
