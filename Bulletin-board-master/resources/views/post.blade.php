@extends('layouts.login')

@section('content')
<div class="post-form">

        <div class="flex">
            <div class="bold">新規投稿画面</div>
            <div class="link blue"><a href="/logout">ログアウト</a></div>
        </div>


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
            {{ Form::text('title',null,['class' => 'input']) }}
            </div>
            <div class="div">
            {{ Form::label('投稿内容') }}
            </div>
            <div class="div">
            {{ Form::textarea('post',null,['class' => 'input', 'rows' => '5']) }}
            </div>
            <div class="div">
            {!! Form::button('<div class="link red">投稿</div>', ['class' => "btn", 'type' => 'submit' ]) !!}
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
