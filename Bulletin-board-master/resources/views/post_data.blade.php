@extends('layouts.login')

@section('content')



    <div class="post-data">
        <div class="flex">
            <div class="bold">
                掲示板詳細画面
            </div>
            <div class="link blue"><a href="/logout">ログアウト</a></div>
        </div>

        <div class="post-area">


            <div class="flex">
                <div class="flex">
                    <div class="post-name">
                    {{ $post->user->username }}さん
                    </div>
                    <div class="div">
                    {{ $post->created_at->format('Y年m月d日') }}
                    </div>
                </div>

                <div class="post-view">
                    {{ $view_count }}View
                </div>
            </div>

            <div class="flex">
                <div class="post-title">
                    {{ $post->title }}
                </div>
                @can('admin')
                <div class="link red">
                    <a href="{{ route('post_update_form',['post_id'=>$post->id]) }}">
                        編集
                    </a>
                </div>
                @endcan
            </div>

            <div class="post-left">
                {{ $post->post }}
            </div>


            <div class="flex">
                <div class="post-category link blue">
                    {{ $post->subCategories->sub_category }}
                </div>

                <div class="flex">
                    <div class="post-comment">
                        コメント数{{ $post->comment_count }}
                    </div>
                    @if(count($favorites_judge)===1)
                        <span class="likes">
                            <i class="fas fa-heart like-toggle liked" data-review-id="{{ $post->id }}"></i>
                            <span class="like-counter">{{ $post->post_favorite_count }}</span>
                        </span>
                    @elseif(count($favorites_judge)===0)
                        <span class="likes">
                            <i class="fas fa-heart like-toggle white" data-review-id="{{ $post->id }}"></i>
                            <span class="like-counter">{{ $post->post_favorite_count }}</span>
                        </span>
                    @endif
                </div>

            </div>

        </div>


        <div class="comment-area">

            @foreach ($post_comments as $comment)
                <div class="comment-area-inner">

                    <div class="flex">

                        <div class="flex">
                            <div class="post-name">
                                {{ $comment->user->username }}さん
                            </div>
                            <div class="div">
                                {{ $comment->created_at->format('Y年m月d日') }}
                            </div>
                        </div>

                        @can('admin')
                            <div class="link red">
                                <a href="{{ route('comment_update_form',['comment_id'=>$comment->id]) }}">
                                    編集
                                </a>
                            </div>
                        @endcan

                    </div>


                    <div class="flex">
                        <div class="div">
                            {{ $comment->comment }}
                        </div>


                        @if(Auth::user()->comment_isLikedBy($comment->id))
                            <span class="likes">
                                <i class="fas fa-heart like-comment-toggle liked" data-comment-id="{{ $comment->id }}"></i>
                                <span class="comment-like-counter">{{ $comment->comment_favorite_count }}</span>
                            </span><!-- /.likes -->
                        @else
                            <span class="likes">
                                <i class="fas fa-heart like-comment-toggle white" data-comment-id="{{ $comment->id }}"></i>
                                <span class="like-counter">{{ $comment->comment_favorite_count }}</span>
                            </span><!-- /.likes -->
                        @endif



                    </div>

                </div>
            @endforeach

        </div>

        <div class="comment-form">
            {!! Form::open() !!}

                {{ Form::textarea('comment_create',null,['class' => 'input form-space', 'placeholder' => 'コチラからコメントできます', 'cols'=>'70' , 'rows' => '5']) }}

                {!! Form::button('<div class="link blue">コメント</div>', ['class' => "btn", 'type' => 'submit' ]) !!}

            {!! Form::close() !!}
        </div>

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
