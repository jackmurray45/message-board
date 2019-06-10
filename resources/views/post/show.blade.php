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
                            <a href = '{{route('profiles.show', ['id' => $post->user->id] )}}'> 
                                {{$post->user->name}}
                            </a>
                        </div>
                        @if(!Auth::guest() && $post->user_id === Auth::user()->id)
                            <div class = "col text-right">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePostModal">Delete Post</button>
                            </div>
                        @endif
                        
                    </div>
                </div>
                <div class="card-body">
                    <p class="mb-1">{{$post->content}}</p>
                    <small>posted {{date('n/j/y \a\t g:i a', strtotime($post->created_at))}}</small>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <h3>Comments</h3>

    @if(count($comments) < 1)
        <p>No comments found</p>

    @else
        <div class="card">
            <div class="list-group">
                @foreach($comments as $comment)
                
                    <div  class="list-group-item flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <a href="{{ route('profiles.show', ['id' => $comment->user->id]) }}">   
                                <h5 class="mb-1">{{$comment->user->name}}</h5>
                            </a>
                            @if(!Auth::guest() && $comment->user->id === Auth::user()->id)
                                <button type="button" class="close delete-comment" data-toggle="modal" data-target="#deleteCommentModal" id = "deleteComment{{$comment->id}}" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            @endif
                            
                        </div>
                        <p class="mb-1">{{$comment->content}}</p>
                        <small>posted {{date('n/j/y \a\t g:i a', strtotime($comment->created_at))}}</small>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <br>
    <div class = "row justify-content-center">
        {{ $comments->links() }}
    </div>

    <br>


    <form method="POST" action="{{ route('comments.store') }}">
        @csrf

        @if(!Auth::guest())
            <div class="form-group">
                <label for="comment">Write a comment:</label>
                {!! Form::textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Nice post!', 'rows' => '5', 'required']) !!}
                {!! Form::hidden('post', $post->id) !!}
            </div>
        @endif
        <br>
        <div class="row justify-content-center">
            <div>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Back to posts</a>
                {!! Form::submit( !Auth::guest() ? 'Submit Comment' : 'Login to comment', ['class' => 'btn btn-dark']) !!}
            </div>
        </div>
    </form>
    
</div>

<script>
    $('.delete-comment').click(function(){
        var commentId = $(this).attr('id').split('deleteComment')[1];
        $('#deleteCommentForm').attr('action', window.location.origin + '/comments/'+commentId);  
    });
</script>

@if(count($comments) > 0)
    @include('modals.delete_comment')
@endif
@include('modals.delete_post')
@endsection
