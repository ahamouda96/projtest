@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-12">
            @foreach ($users as $user)
                <div class="col-sm-3 text-center" style="padding: 5px;">
                    <div style="box-shadow: 0 0 10px 1px grey; padding: 20px;">
                        <img src="/uploads/images/{{ $user->profile_image }}" alt="Profile Picture" width="50" height="50">
                        {{ $user->name }}<br />
                        <a href="{{ route('user.show', $user->id) }}">View User</a>
                    </div>
                </div>
            @endforeach
            <div class="col-sm-12">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
