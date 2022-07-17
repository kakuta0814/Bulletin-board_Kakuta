@extends('layouts.login')

@section('content')
    <div class="post-form">

        <div class="flex">
            <div class="bold">コメント編集画面</div>
            <div class="link blue"><a href="/logout">ログアウト</a></div>
        </div>



      {!! Form::open() !!}

        {{ Form::label('コメント') }}
        <div class="div">
            {{ Form::textarea('comment',$comment_data->comment,['class' => 'input', 'rows' => '5']) }}
        </div>

        {!! Form::button('<div class="link red">更新</div>', ['class' => "btn", 'type' => 'submit' ]) !!}


        <div class="link red">
            <a href="{{ route('comment_delete',['comment_id'=>$comment_data->id]) }}" onclick="return confirm('この投稿を削除します。よろしいでしょうか？')">
                削除
            </a>
        </div>

        {!! Form::close() !!}

        @if (isset( $errors ))
            <div class="error-message bold">
                <div class="error-inner">
                @foreach ($errors->all() as $error)
                    <div>※{{$error}}</div>
                @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
