@extends('layouts.admin')

@section('content')

  @if(Session::has('deleted_user'))
  <p class="bg-danger">{{session('deleted_user').' has been deleted.'}}</p>

    <!-- <p class="bg-danger">{{session('deleted_user')}}</p> -->
  @endif
    	<h1>Users</h1>

<table class="table">
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>photo</th>
      <th>Created</th>
      <th>Updated</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>

  @if ($users)
      @foreach ($users as $user)
          <tr>
          <th>{{$user->id}}</th>
          <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
          <td>{{$user->email}}</td>
          <td>{{$user->role_id == NULL ? 'User has no role' : $user->role->name}}</td>
          <td><img height="30px" src="/uploads/images/{{$user->profile_image ? $user->profile_image : 'default.png'}}"></td>
          <td>{{$user->created_at->diffForHumans()}}</td>
          <td>{{$user->updated_at->diffForHumans()}}</td>
          <td>
            <a href="{{route('users.edit', $user->id)}}" class="btn btn-success" style="text-decoration:none; color:#fff ">Edit</a>
          </td>
          <td>
			  		{!! Form::open(['method'=>'DELETE','action'=>['admin\AdminUsersController@destroy',$user->id]]) !!}
						{!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}
					  {!! Form::close() !!}
				</td>
        
        </tr>
      @endforeach
  @endif
    
  </tbody>
</table>

@endsection