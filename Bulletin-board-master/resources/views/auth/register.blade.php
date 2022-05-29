@extends('layouts.logout')

@section('content')

@if (isset( $errors ))
  <div class="error-message">
    <div class="error-inner">
    @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
    </div>
  </div>
@endif


<!-- ------------------------------------------- -->

<div class="register-from">

  <div class="logout-inner">
    {!! Form::open() !!}

    <p class="white welcome">新規ユーザー登録</p>

    <div class="form">
      {{ Form::label('ユーザー名') }}
      {{ Form::text('username',null,['class' => 'input']) }}
    </div>

    <div class="margin-form form">
      {{ Form::label('メールアドレス') }}
      {{ Form::text('email',null,['class' => 'input']) }}
    </div>

    <div class="margin-form form">
      {{ Form::label('パスワード') }}
      {{ Form::password('password',['class' => 'input']) }}
    </div>

    <div class="margin-form form">
      {{ Form::label('パスワード確認') }}
      {{ Form::password('password_confirmation',null,['class' => 'input']) }}
    </div>

    <div class="btn-form">
      {{ Form::submit('確認',['class' => 'btn btn-danger']) }}
    </div>



    <div class="white new-user"><a href="/login">ログイン画面へ戻る</a></div>

    {!! Form::close() !!}
  </div>
</div>


@endsection
