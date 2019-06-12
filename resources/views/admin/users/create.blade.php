@extends('layouts.admin')

@section('content')
	<h1>Create User</h1>
	
    
    <!-- laravelcollective/html -->
	{!! Form::open(['method'=>'POST','action'=>'admin\AdminUsersController@store','files'=>true]) !!} 

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
		{!! Form::submit('Create user', ['class' => 'btn btn-primary']) !!}
		</div>
    
	{!! Form::close() !!}

	<div class="row">	
		@include('includes.form_error')
	</div>


@endsection