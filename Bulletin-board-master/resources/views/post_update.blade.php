@extends('layouts.login')

@section('content')
    <div class="container">
      {!! Form::open() !!}
        {{ Form::label('サブカテゴリー') }}

        <select name="post_sub_category_id">
            @foreach ($sub_categories as $category)
                    <option value="{{ $category->id }}">{{ $category->sub_category }}</option>
            @endforeach
        </select>

        <br>
        {{ Form::label('タイトル') }}
        {{ Form::text('title',$post_data->title,['class' => 'input']) }}<br>
        {{ Form::label('投稿内容') }}
        {{ Form::text('post',$post_data->post,['class' => 'input']) }}

        {{ Form::submit('更新',['class' => 'btn btn-danger']) }}

        <a href="{{ route('post_delete',['post_id'=>$post_data->id]) }}">
            <div class="btn btn-danger">削除</div>
        </a>

        {!! Form::close() !!}

    </div><br>
@endsection
