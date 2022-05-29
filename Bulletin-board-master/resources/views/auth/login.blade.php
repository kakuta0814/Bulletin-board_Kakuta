@extends('layouts.logout')

@section('content')
  <div class="logout-from">

    <div class="logout-inner">
      {!! Form::open() !!}

      <p class="white welcome">ログイン</p>

      <div class="form">
        {{ Form::label('メールアドレス') }}
        {{ Form::text('email',null,['class' => 'input']) }}


      </div>

      <div class="margin-form form">
        {{ Form::label('パスワード') }}
        {{ Form::password('password',['class' => 'input']) }}
      </div>

      <div class="btn-form">
        {{ Form::submit('ログイン',['class' => 'btn btn-danger']) }}
      </div>



      <div class="white new-user"><a href="/register">新規ユーザーの方はこちら</a></div>

      {!! Form::close() !!}
    </div>
</div>
@endsection
