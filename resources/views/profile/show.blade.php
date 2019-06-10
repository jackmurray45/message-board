@extends('layouts.app')

@section('content')
<div class="container" style = 'margin-top:20px;'>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('inc.alerts')
            <div class="page-header">
                <h1>{{$user->name}}</h1>      
            </div>
            <div class="card">   
                <div class="card-body" style = "padding:0 !important">
                    <ul class="list-group list-group-flush">
                        @if(count($posts) > 0)
                            @foreach ($posts as $post) 
                                <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <p class="mb-1">{{$post->content}}</p>
                                    <small>posted {{date('n/j/y \a\t g:i a', strtotime($post->created_at))}}</small>
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
    <br/>
    <div class = "row justify-content-center">
        {{ $posts->links() }}
    </div>
    <div class="row justify-content-center">
        <div class = 'col-md-8'>
            @if(isset($followId))
                <form method="POST" action="{{ route('profiles.destroy', ['id' => $followId]) }}">
                    {{method_field('DELETE')}}
                    @csrf
                    <a href="{{ route('profiles.index') }}" class="btn btn-outline-secondary">Go back to profiles</a>
                    {!! Form::hidden('user', $user->id) !!}
                    {!! Form::submit('Unfollow User', ['class' => 'btn btn-dark']) !!}
                </form>
            @else
                <form method="POST" action="{{ route('profiles.store') }}">
                    @csrf
                    <a href="{{ route('profiles.index') }}" class="btn btn-outline-secondary">Go back to profiles</a>
                    {!! Form::hidden('user', $user->id) !!}
                    {!! Form::submit('Follow User', ['class' => 'btn btn-dark']) !!}
                </form>
            @endif
        </div>
    </div>
    
</div>
@endsection
