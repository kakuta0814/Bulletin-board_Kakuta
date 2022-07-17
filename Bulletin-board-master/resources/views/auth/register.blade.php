@extends('layouts.logout')

@section('content')




<!-- ------------------------------------------- -->

<div class="logout-from">

  <div class="logout-inner">

  @if (isset( $errors ))
    <div class="error-message">
      <div class="error-inner">
      @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
      @endforeach
      </div>
    </div>
  @endif
    {!! Form::open() !!}

    <p class="login-title bold">ユーザー登録</p>

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
      {!! Form::button('<div class="link blue">確認</div>', ['class' => "btn", 'type' => 'submit' ]) !!}
    </div>



    <div class="white new-user"><a href="/login">ログイン画面へ戻る</a></div>

    {!! Form::close() !!}
  </div>
</div>


@endsection
