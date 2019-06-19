@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <h1>{{$user->name}}</h1>
                <small>{{$user->email}}</small>

                <hr>
                <user-friend-toggle :user_id="{{$user->id}}">Follow</user-friend-toggle>
            </div>
        </div>
    </div>
</div>
@endsection