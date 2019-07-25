@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="float-right">

                @if(auth()->user()->isNot($user))
                    @if(auth()->user()->isFollowing($user))
                        <a href="{{ route('user.unfollow', $user) }}" class="btn btn-danger">x Unfollow</a>
                    @else
                        <a href="{{ route('user.follow', $user) }}" class="btn btn-outline-success">+Follow</a>
                    @endif
                @endif
            </div>
            <h3>{{ $user->name }}</h3>
            <h6>@ {{ $user->username }}</h6>
            

        </div>

        <user-post-component></user-post-component>
        
    </div>
</div>
@endsection