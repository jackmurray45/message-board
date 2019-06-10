@extends('layouts.app')

@section('content')
<div class="container" style = 'margin-top:20px;'>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('inc.alerts')
            <div class="page-header">
                <h1>Profile Info</h1>      
            </div>

            <form method="POST" action="{{ route('profiles.update', ['id' => $user->id]) }}">
                {{method_field('PUT')}}
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        {!! Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'name', 'required', 'autocomplete' => 'name', 'maxlength' => '255']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        {!! Form::text('email', $user->email, ['class' => 'form-control', 'id' => 'email', 'required', 'autocomplete' => 'email', 'maxlength' => '255']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                    <div class="col-sm-10">
                        {!! Form::textarea('bio', $user->bio, ['class' => 'form-control', 'id' => 'bio', 'autocomplete' => 'bio', 'maxlength' => '255', 'rows' => '3']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::submit('Update info', ['class' => 'btn btn-dark mx-auto col-sm-2']) !!}
                </div>
                <div class="form-group row">
                    <a href='#' class = "mx-auto" data-toggle="modal" data-target="#changePasswordModal" >change password</a>
                </div>

            </form>

            <div class="page-header">
                <h1>Posts</h1>      
            </div>
            <div class="card">   
                <div class="card-body" style = "padding:0 !important">
                    <ul class="list-group list-group-flush">
                        @if(count($posts) > 0)
                            @foreach ($posts as $post) 
                                <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <p class="mb-1">{{$post->content}}</p>
                                    <small>posted {{date('n/j/y \a\t g:i a', strtotime($post->created_at))}}</small>
                                    <button type="button" class="close delete-post" data-toggle="modal" data-target="#deletePostModal" id = "deletePost{{$post->id}}" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </a>
                            @endforeach
                        @else
                            <li class="list-group-item">
                                <p class="mb-1">User has no posts.</p>
                            </li>
                        @endif
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.delete-post').click(function(){
    var postId = $(this).attr('id').split('deletePost')[1];
    $('#deleteForm').attr('action', window.location.origin + '/posts/'+postId);  
});


</script>
@if(count($posts) > 0)
    @include('modals.delete_post')
@endif
@include('modals.reset');
@endsection
