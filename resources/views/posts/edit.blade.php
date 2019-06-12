@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-6 col-sm-offset-3">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    {{ Session::get('success') }}
                </div>
            @endif
            {!! Form::model($post, ['method' => 'PUT', 'files' => true, 'route' => ['post.update', $post->id]]) !!}
                <div class="panel panel-default">
                    <div class="panel-body">
                        
                    @if ($post->friends()->count() > 0)
                            <small>
                                with
                                @foreach ($post->friends as $tag)
                                    {{ $tag->user2->name }},
                                @endforeach
                            </small>
                        @endif
                        <div class="pull-right">
                            <a href="{{ url('/posts') }}">Return back</a>
                        </div>
                       
                        <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                            {{ Form::textarea('body', null, ['class' => 'form-control', 'placeholder' => 'Enter your post body']) }}
                            @if ($errors->has('body'))
                                <small class="text-danger">{{ $errors->first('body') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                          <input type="file" class="form-control" name="media">
                        </div>
                        <div class="form-group">
                          <select class="form-control" name="category">
                              @foreach ($categories as $category)
                                  <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                              @endforeach
                          </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control select2-class" name="tags[]" multiple>
                                @foreach (Auth::user()->friends as $friend)
                                    <option value="{{ $friend->id }}">{{ $friend->user2->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="submit" value="Update" class="btn btn-primary btn-block">
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
