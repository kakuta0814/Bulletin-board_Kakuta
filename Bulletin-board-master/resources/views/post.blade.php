@extends('layouts.login')

@section('content')

{!! Form::open() !!}
    {{ Form::label('サブカテゴリー') }}
    <select name="post_sub_category_id">
        @foreach ($sub_categories as $category)
                <option value="{{ $category->id }}">{{ $category->sub_category }}</option>
        @endforeach
    </select>

    {{ Form::label('タイトル') }}
    {{ Form::text('title',null,['class' => 'input']) }}

    {{ Form::label('投稿内容') }}
    {{ Form::text('post',null,['class' => 'input']) }}

    {{ Form::submit('登録',['class' => 'btn btn-danger']) }}
{!! Form::close() !!}

@endsection
