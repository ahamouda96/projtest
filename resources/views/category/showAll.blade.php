@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-6 col-sm-offset-3">
            @foreach ($posts as $post)
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                        Created by {{ $post->user->username }}, {{ $post->title }}
                    </h3>
                  </div>
                  <div class="panel-body">
                    {{ $post->body }} <br>
                    @if($post->postMedia)
                        @if($post->postMedia->type=="image")
                        <img src="/uploads/posts/images/{{$post->postMedia->path}}" style='width:100%;height:600px;'>
                        @endif
                        @if($post->postMedia->type=="video")
                        <video style='width:100%;height:600px;' controls>
                            <source src="/uploads/posts/video/{{$post->postMedia->path}}">
                        </video>
                        <!-- <video src="/uploads/posts/video/{{$post->postMedia->path}}" controls style='width:250px;height:250px;'> -->
                        @endif
                        <br>
                        
                        <a href="{{ route('category.showAll', [$post->category->name]) }}" class="badge">{{ $post->category->name }}</a>
                    
                        <!-- <div class="badge">{{$post->category->name}}</div> -->
                    @endif
                  </div>
                  <div class="panel-footer" data-postid="{{ $post->id }}">
                  @php
                          $i = Auth::user()->likes()->count();
                          $c = 1;
                      @endphp
                      @foreach (Auth::user()->likes as $like)
                          @if ($like->post_id == $post->id)
                              @if ($like->like)
                                  <a href="#" class="btn btn-link like active-like">Like</a>
                                  <a href="#" class="btn btn-link like">Dislike</a>
                              @else
                                  <a href="#" class="btn btn-link like">Like</a>
                                  <a href="#" class="btn btn-link like active-like">Dislike</a>
                              @endif
                              @break
                          @elseif ($i == $c)
                              <a href="#" class="btn btn-link like">Like</a>
                              <a href="#" class="btn btn-link like">Dislike</a>
                          @endif
                          @php
                              $c++;
                          @endphp
                      @endforeach
                      <a href="#" class="btn btn-link">Comment</a>
                  </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection