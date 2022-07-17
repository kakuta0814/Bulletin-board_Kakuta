@extends('layouts.login')

@section('content')
<div class="post-form">

        <div class="flex">
            <div class="bold">投稿編集画面</div>
            <div class="link blue"><a href="/logout">ログアウト</a></div>
        </div>

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
            <div class="div">
                {{ Form::label('サブカテゴリー') }}
            </div>


            <div class="div">
                <select name="post_sub_category_id">
                    @foreach ($sub_categories as $category)
                            <option value="{{ $category->id }}">{{ $category->sub_category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="div">
            {{ Form::label('タイトル') }}
            </div>
            <div class="div">
            {{ Form::text('title',$post_data->title,['class' => 'input']) }}
            </div>
            <div class="div">
            {{ Form::label('投稿内容') }}
            </div>
            <div class="div">
            {{ Form::textarea('post',$post_data->post,['class' => 'input', 'rows' => '5']) }}
            </div>


            {!! Form::button('<div class="link red">更新</div>', ['class' => "btn", 'type' => 'submit' ]) !!}
            <div class="link red">
                <a href="{{ route('post_delete',['post_id'=>$post_data->id]) }}" onclick="return confirm('この投稿を削除します。よろしいでしょうか？')">
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
