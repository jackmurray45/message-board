@extends('layouts.app')

@section('content')
<div class="container" style = 'margin-top:20px;' >
    <div class="row justify-content-center" >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Most recent posts</div>
                <div class="list-group">
                    @if(count($posts) > 0)
                        @foreach ($posts as $post)
                            <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">New Users</div>
                    <div class="list-group">
                        @if(count($users) > 0)
                            @foreach ($users as $user)
                                <a href="{{ route('profiles.show', ['id' => $user->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{$user->name}}</h5>
                                    </div>
                                    <p class="mb-1">{{$user->bio}}</p>
                                </a>
                            @endforeach
                        @else
                            <p class = "mx-auto">No users found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
