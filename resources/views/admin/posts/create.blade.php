@extends('layouts.admin')

@section('content')
<h1>Create post</h1>
	
		{!! Form::open(['method'=>'POST','action'=>'admin\AdminPostsController@store','files'=>true]) !!}
			
			<div class='form-group'>
		        {!! Form::label('body','Body:') !!}
		        {!! Form::textarea('body',null,['class'=>'form-control', 'rows'=>5]) !!}
		    </div>

			<div class='form-group'>
		        {!! Form::label('media','media:') !!}
		        {!! Form::file('media',null,['class'=>'form-control']) !!}
		    </div>

			<div class='form-group'>
		        {!! Form::label('category_id','Category:') !!}
		        {!! Form::select('category_id',[''=>'Choose Category']+$categories,null,['class'=>'form-control']) !!}
		    </div>
			
		    <div class='form-group'>
		        {!! Form::submit('Create Post',['class'=>'btn btn-primary']) !!}
		    </div>

		{!! Form::close() !!}

    <div class="row">
		@include('includes.form_error')
	</div>

@endsection