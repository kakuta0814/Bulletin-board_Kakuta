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
            @foreach ($all_categories as $category)
                    <option value="{{ $category->id }}">{{ $category->main_category }}</option>
            @endforeach

        </select>

        {{ Form::label('新規サブカテゴリー') }}
        {{ Form::text('sub_category',null,['class' => 'input']) }}

        {{ Form::submit('登録',['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}

    カテゴリー一覧<br><br>
    @foreach ($all_categories as $category)

        {{ $category->main_category }}
        @if($category->postSubCategories->isEmpty())
            <a href="/main/delete/{{$category->id}}" onclick="return confirm('このカテゴリを削除します。よろしいでしょうか？')">
                    <div class="btn btn-danger">削除</div>
            </a>
                <br>
        @endif

        <br>

        @foreach ($category->postSubCategories as $sub)


                {{ $sub->sub_category }}
                <a href="/sub/delete/{{$sub->id}}" onclick="return confirm('このカテゴリを削除します。よろしいでしょうか？')">
                    <div class="btn btn-danger">削除</div>
                </a>
                <br>
        @endforeach<br>


    @endforeach


</div>
@endsection
