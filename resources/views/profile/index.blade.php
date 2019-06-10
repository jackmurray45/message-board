@extends('layouts.app')

@section('content')

<div class="container" style = 'margin-top:20px;'>
    <div class="card-body">
        @include('inc.alerts')
    </div>
    <div class="card-columns">
        @foreach ($users as $user)
            <div class="card">
                {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                <div class="card-body text-center">
                    <h5 class="card-title">{{$user->name}}</h5>
                    <p class="card-text">{{ $user->bio ? $user->bio : 'User has no bio' }}</p>
                    @if (!Auth::guest() && Auth::user()->id === $user->id)
                        <a href="{{ route('profiles.show', ['id' => $user->id]) }}" target = '_blank' class="btn btn-outline-secondary">View User</a>
                    @elseif( isset($followingProfiles) || array_key_exists($user->id, $followMap))
                        <form method="POST" action="{{ route('profiles.destroy', ['id' => $followMap[$user->id]] ) }}">
                            {{method_field('DELETE')}}
                            @csrf
                            <a href="{{ route('profiles.show', ['id' => $user->id]) }}" target = '_blank' class="btn btn-outline-secondary">View User</a>
                            {!! Form::submit('Unfollow User', ['class' => 'btn btn-dark']) !!}
                        </form>

                    @else
                        <form method="POST" action="{{ route('profiles.store') }}">
                            @csrf
                            <a href="{{ route('profiles.show', ['id' => $user->id]) }}" target = '_blank' class="btn btn-outline-secondary">View User</a>
                            {!! Form::hidden('user', $user->id) !!}
                            {!! Form::submit('Follow User', ['class' => 'btn btn-dark']) !!}
                        </form>
                    @endif
                    
                </div>
            </div>
        @endforeach
    </div>
    <br/>
    <div class = "row justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
