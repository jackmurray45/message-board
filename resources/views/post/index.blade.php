@extends('layouts.app')

@section('content')
<div class="container" style = 'margin-top:20px;'>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('inc.alerts')
            <div class="card">
                <div class="card-header">
                    <div class = "row">
                        <div class = "col">
                            @if(isset($followingPosts))
                                Posts of users you are following
                            @else
                                All Posts
                            @endif
                        </div>
                        <div class = "col text-right" >
                            <button class="btn btn-dark" data-toggle="modal" data-target="#createPostModal">Create Post</button>
                        </div>
                    </div>
                </div>
                <div class="list-group">
                    @if(count($posts) > 0)
                        @foreach ($posts as $post)
                            <a href="{{ route('posts.show', ['id' => $post->id]) }}" target = '_blank' class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{$post->user->name}}</h5>
                                <small>posted {{date('n/j/y \a\t g:i a', strtotime($post->created_at))}}</small>
                                </div>
                                <p class="mb-1">{{$post->content}}</p>
                            </a>
                        @endforeach
                    @else
                        <p class = "mx-auto">No posts found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class = "row justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@include('modals.create_post');
@endsection
