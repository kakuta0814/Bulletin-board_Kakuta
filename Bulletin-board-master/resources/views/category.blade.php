@extends('layouts.login')

@section('content')

<div class="main">

    <div class="container">
        <div class="inner">
            <div class="category-from">


                <div class="bold">
                    カテゴリー追加画面<br><br>
                </div>

                {!! Form::open() !!}
                <div class="div">
                    {{ Form::label('新規メインカテゴリー') }}
                </div>
                <div class="div">
                    {{ Form::text('main_category',null,['class' => 'input']) }}
                </div>
                    {!! Form::button('<div class="link red">登録</div>', ['class' => "btn", 'type' => 'submit' ]) !!}
                {!! Form::close() !!}


                {!! Form::open() !!}
                    <div class="div">
                    {{ Form::label('メインカテゴリー') }}
                    </div>
                    <select name="main_category_id">
                        @foreach ($all_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->main_category }}</option>
                        @endforeach

                    </select>

                    <div class="div">
                    {{ Form::label('新規サブカテゴリー') }}
                    </div>

                    <div class="div">
                    {{ Form::text('sub_category',null,['class' => 'input']) }}
                    </div>

                    {!! Form::button('<div class="link red">登録</div>', ['class' => "btn", 'type' => 'submit' ]) !!}
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
        </div>
    </div>

    <div class="main-menu category-list">
        <div class="link blue logout"><a href="/logout">ログアウト</a></div><br>
        <div class="bold">
        カテゴリー一覧
        </div><br>
        @foreach ($all_categories as $category)

        <div class="flex main-flex">
            <div class="div">{{ $category->main_category }}</div>
            @if($category->postSubCategories->isEmpty())
            <div class="link red">
                <a href="/main/delete/{{$category->id}}" onclick="return confirm('このカテゴリを削除します。よろしいでしょうか？')">
                        削除
                </a>
            </div><br>
            @endif
        </div>



            @foreach ($category->postSubCategories as $sub)


            <div class="flex sub-flex">
                <div class="sub-margin">{{ $sub->sub_category }}</div>

                @if ($sub->posts->isEmpty())
                <div class="link red">
                    <a href="/sub/delete/{{$sub->id}}" onclick="return confirm('このサブカテゴリを削除します。よろしいでしょうか？')">
                        削除
                    </a>
                </div>
                @endif
            </div>
            @endforeach

        @endforeach


    </div>

</div>
@endsection
