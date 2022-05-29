@extends('layouts.login')

@section('content')
<div class="container">


    カテゴリー追加画面
    {!! Form::open() !!}
        {{ Form::label('新規メインカテゴリー') }}
        {{ Form::text('main_category',null,['class' => 'input']) }}

        {{ Form::submit('登録',['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}


    {!! Form::open() !!}
        {{ Form::label('メインカテゴリー') }}
        <select name="main_category_id">
            @foreach ($main_categories as $category)
                    <option value="{{ $category->id }}">{{ $category->main_category }}</option>
            @endforeach
        </select>

        {{ Form::label('新規サブカテゴリー') }}
        {{ Form::text('sub_category',null,['class' => 'input']) }}

        {{ Form::submit('登録',['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}


    カテゴリー一覧<br><br>
    @foreach ($main_categories as $main)

        {{ $main->main_category }}

        <br>

        @foreach ($sub_categories as $sub)
            @if($main->id == $sub->post_main_category_id)
                {{ $sub->sub_category }}
                <a href="/category/{{$sub->id}}" onclick="return confirm('この投稿を削除します。よろしいでしょうか？')">
                    <div class="btn btn-danger">削除</div>
                </a>
                <br>
            @endif
        @endforeach<br>
    @endforeach


</div>
@endsection
