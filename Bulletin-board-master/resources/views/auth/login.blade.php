@extends('layouts.logout')

@section('content')
  <div class="logout-from">

    <div class="logout-inner">
      {!! Form::open() !!}

        <div class="login-title bold">ログイン</div>




        <div class="div">
          {{ Form::label('メールアドレス') }}
        </div>
        <div class="div">
          {{ Form::text('email',null,['class' => 'input']) }}
        </div>


        <div class="div">
          {{ Form::label('パスワード') }}
        </div>
        <div class="div">
          {{ Form::password('password',['class' => 'input']) }}
        </div>

        <div class="btn-form">
          {!! Form::button('<div class="link blue">ログイン</div>', ['class' => "btn", 'type' => 'submit' ]) !!}
        </div>


        <div>新規ユーザーの方は<a href="/register">こちら</a></div>

      {!! Form::close() !!}
    </div>
</div>
@endsection
