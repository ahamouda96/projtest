@extends('layouts.admin')

@section('content')
    <table class="table">
	  <thead>
	    <tr>
	      <th>Id</th>
	      <th>Owner</th>
	      <th>Category</th>
	      <th>Body</th>
	      <th>Post</th>
	      <!-- <th>Comments</th> -->
	      <th>Created</th>
	      <th>Updated</th>
				<th>Edit</th>
	      <th>Delete</th>
	    </tr>
	  </thead>
	  <tbody>
    
    @if($posts)
        @foreach($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
								<!-- <td><img height="50" src="{{$post->photo ? $post->photo->file : '/images/default.png'}}" alt=""></td> -->
                <td>{{$post->user ? $post->user->name : ''}}</td>
                <td>{{$post->category? $post->category->name : 'uncategoeized'}}</td>
								<td>{{str_limit($post->body,9)}}</td>
								<td><a href="{{route('posts.edit',$post->id)}}">View Post</a></td>
								<!-- <td><a href="{{route('comments.show',$post->id)}}">View Comments</a></td> -->
								<td>{{$post->created_at->diffForHumans()}}</td>
								<td>{{$post->updated_at->diffForHumans()}}</td>
								<td>
									<a href="{{route('posts.edit',$post->id)}}" class="btn btn-success" style="text-decoration:none; color:#fff ">Edit</a>
								</td>
								<td>
									{!! Form::open(['method'=>'DELETE','action'=>['admin\AdminPostsController@destroy',$post->id]]) !!}
									{!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}
									{!! Form::close() !!}
								</td>
            </tr>
        @endforeach
    @endif
        </tbody>
	</table>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-5">
				{{$posts->render()}}
		</div>
	</div>
@endsection