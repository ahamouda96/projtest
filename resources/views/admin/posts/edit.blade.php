@extends('layouts.admin')

@section('content')
		
	<h1>Edit Post</h1>
	<div class="row">

		

		<div class="col-sm-9">
	
			{!! Form::model($post, ['method'=>'PATCH','action'=>['admin\AdminPostsController@update',$post->id],'files'=>true]) !!}
			    
			<div class='form-group'>
		        {!! Form::label('media','media:') !!}
		        {!! Form::file('media',null,['class'=>'form-control']) !!}
		    </div>
			<div class="form-group">
			@if($post->postMedia)
				@if($post->postMedia->type=="image")
				<img src="/uploads/posts/images/{{$post->postMedia->path}}" style='width:250px;height:250px;'>
				@endif
				@if($post->postMedia->type=="video")
				<video width="320" height="240" controls>
					<source src="/uploads/posts/video/{{$post->postMedia->path}}" controls style='width:250px;height:250px;'>
				</video>
				<!-- <video src="/uploads/posts/video/{{$post->postMedia->path}}" controls style='width:250px;height:250px;'> -->
				@endif
			@endif
			
			</div>
			
			<div class='form-group'>
		        {!! Form::label('body','Body:') !!}
		        {!! Form::textarea('body',null,['class'=>'form-control', 'rows'=>5]) !!}
		    </div>
			    <div class='form-group'>
			        {!! Form::label('category_id','Category:') !!}
			        {!! Form::select('category_id',$categories,null,['class'=>'form-control']) !!}
			    </div>
				
				

			    
			
			

			
			

			    <div class='form-group'>
			        {!! Form::submit('Update Post',['class'=>'btn btn-primary col-sm-6']) !!}
			    </div>

			{!! Form::close() !!}

			
		</div>

	</div>

	<div class="row">

		@include('includes.form_error')
	</div>

@endsection