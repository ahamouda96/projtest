@extends('layouts.admin')

@section('content')
	<h1>Edit User</h1>
	
    <div class="row">

		<div class="col-sm-3">
			
			<img src="/uploads/images/{{$user->profile_image ? $user->profile_image : 'default.png'}}" style="width:250px; height:250px;" alt="user image" class="img-responsive img-rounded">

		</div>

		<div class="col-sm-9">
		<!-- laravelcollective/html -->
		{!! Form::model($user, ['method'=>'PATCH','action'=>['admin\AdminUsersController@update', $user->id],'files'=>true]) !!} 

			<div class='form-group'>
				{!! Form::label('name','Name:') !!}
				{!! Form::text('name',null,['class'=>'form-control']) !!}
			</div>

			<div class='form-group'>
				{!! Form::label('email','Email:') !!}
				{!! Form::text('email',null,['class'=>'form-control']) !!}
			</div>

			<div class='form-group'>
				{!! Form::label('password','Password:') !!}
				{!! Form::password('password', ['class'=>'form-control']) !!}
			</div>

			<div class='form-group'>
				{!! Form::label('role_id','Role:') !!}
				{!! Form::select('role_id',[''=>'Choose Options']+ $roles ,null, ['class'=>'form-control']) !!}
			</div>

			<div class='form-group'>
		    {!! Form::label('profile_image','Choose Image:') !!}
		    {!! Form::file('profile_image', null, ['class'=>'form-control']) !!}
		</div> 

			<div class="form-group">
			{!! Form::submit('Update user', ['class' => 'btn btn-primary']) !!}
			</div>

			{!! Form::close() !!}

			<!-- delete user form -->
			<!-- {!! Form::open(['method'=>'DELETE','action'=>['admin\AdminUsersController@destroy',$user->id] ]) !!}
			    <div class='form-group'>
			        {!! Form::submit('Delete User',['class'=>'btn btn-danger']) !!}
			    </div> -->

			<!-- {!! Form::close() !!} -->
		

		</div>
	</div>
	<div class="row">	
		@include('includes.form_error')
	</div>


@endsection