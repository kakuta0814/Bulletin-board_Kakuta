@extends('layouts.login')



@section('content')
<div class="main">



    <div class="container">
        <div class="inner">
            <div class="bold post-title">掲示板投稿一覧</div>
        @if(isset($all_posts))
            @foreach ($all_posts as $post)
                <div class="post">

                    <div class="flex">
                        <div class="post-name">
                            {{ $post->user->username }}さん
                        </div>
                        <div class="post-create">
                            {{ $post->created_at->format('Y年m月d日') }}
                        </div>
                        <div class="post-view">
                            {{ $post->action_logs_count }}View
                        </div>
                    </div>

                    <div class="post-title">
                        <a href="{{ route('post_data',['post_id'=>$post->id]) }}">
                            <div>{{ $post->title }}</div>
                        </a>
                    </div>

                    <div class="flex post-center">

                        <div class="post-category link blue">
                            {{ $post->subCategories->sub_category }}
                        </div>

                        <div class="post-comment">
                            コメント数{{ $post->comment_count }}
                        </div>

                        @if(Auth::user()->isLikedBy($post->id))
                            <span class="likes">
                                <i class="far fa-heart like-toggle liked" data-review-id="{{ $post->id }}"></i>
                            <span class="like-counter">{{ $post->post_favorite_count }}</span>
                            </span><!-- /.likes -->
                        @else
                            <span class="likes">
                                <i class="far fa-heart like-toggle" data-review-id="{{ $post->id }}"></i>
                            <span class="like-counter">{{ $post->post_favorite_count }}</span>
                            </span><!-- /.likes -->
                        @endif

                    </div>

                </div>
            @endforeach
        @endif
        </div>
    </div>

    <div class="main-menu">
        <div class="side-menu">
            <div class="side-inner">



            <div class="link blue"><a href="/logout">ログアウト</a></div>
            @can('admin')
                <div class="link red"><a href="/category">カテゴリーを追加</a></div>
            @endcan
            <div class="link blue"><a href="/post">投稿</a></div>
            {!! Form::open(['url' => '/search', 'method' => 'get']) !!}

            <div class="div">
            {{ Form::text('search',null,['class' => 'input search-space', 'placeholder' => 'ユーザー名']) }}</div>

            {!! Form::button('<div class="link blue">検索</div>', ['class' => "btn", 'type' => 'submit' ]) !!}

            {!! Form::close() !!}

            <div class="link blue"><a href="like">いいねした投稿</a></div>
            <div class="link blue"><a href="my_post">自分の投稿</a></div>
        </div>


        <div id="accordion" class="accordion-container">
            @foreach ($all_categories as $category)

                        <div class="accordion-title js-accordion-title">{{ $category->main_category }}</div>
                        @if($category->postSubCategories->isEmpty())

                        @endif
                        <div class="accordion-content">
                            @foreach ($category->postSubCategories as $sub)
                            <a href=""><div class="nav-item">{{ $sub->sub_category }}</div></a>
                            @endforeach
                        </div><!--/.accordion-content-->

            @endforeach
        </div><!--/#accordion-->

        </div>

    </div>
</div>
@endsection
