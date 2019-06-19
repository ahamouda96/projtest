@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/select2.css">
    <script src="/js/select2.js"></script>
    <div class="container">
        <div class="col-sm-6 col-sm-offset-3">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    {{ Session::get('success') }}
                </div>
            @endif
             <form method="post"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                            <textarea name="body" rows="8" cols="80" class="form-control" placeholder="Enter your post"></textarea>
                            @if ($errors->has('body'))
                                <small class="text-danger">{{ $errors->first('body') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                          <!-- <input type="file" class="form-control" name="media"> -->
                
                            <input type="file" name="media" id="file"
                            style="display: none;"/>

                            <label for="file" style="font-size: 25px; color: #83b476;">
                            <i class="fa fa-camera" aria-hidden="true"></i>
                            </label>
                            <span class="tweet-error"></span>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="category">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
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
                       
                        <input type="submit" value="Post" class="btn btn-primary btn-block">
                    </div>
                </div>
            </form>

<!-- display posts-->
            @foreach ($posts as $post)
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">  
                      <img src="/uploads/images/{{$post->user->profile_image}}" alt="user image" style="width:40px; height:40px;border-radius: 50%;">
                      <a href="{{route('front.profile', ['id'=>$post->user->id])}}" style="text-decoration: none; color: #666">
                        <span style="margin-left: 5px; font-weight: 600">{{ $post->user->name }}</span> <br>
                      </a> 
                       <span style="margin-left: 45px;">{{$post->updated_at->diffForHumans() }}</span>
                    </h3> 
                    <h3 class="panel-title">
                        @if ($post->friends()->count() > 0)
                            <small>
                                with
                                @foreach ($post->friends as $tag)
                                    {{ $tag->user2->name }},
                                @endforeach
                            </small>
                        @endif
                       
                        <div class="pull-right">
                          <div class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="{{ route('post.show', [$post->id]) }}">Show Post<a>
                              </li>
                            </ul>
                          </div>
                        </div><!-- puul right-->
                        
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
                    @endif
                    @if($post->category)
                        <a href="{{ route('category.showAll', [$post->category? $post->category->name : 'uncategoeized']) }}" class="badge">{{ $post->category->name }}</a>
                    @endif
                  </div>
                
            <div class="panel-footer" data-postid="{{ $post->id }}">
                      @php
                          $i = Auth::user()->likes()->count();
                          $c = 1;
                          $likeCount = $post->likes()->where('like', '=', true)->count();
                          
                      @endphp
                      @foreach (Auth::user()->likes as $like)
                          @if ($like->post_id == $post->id)
                              @if ($like->like)
                                  <a href="#"id="like" class="btn btn-link like active-like">Like <span class="badge">{{ $likeCount }}</span></a>
                                  
                              @else
                                  <a href="#" id="like" class="btn btn-link like">Like <span class="badge">{{ $likeCount }}</span></a>
                                  
                              @endif
                              @break
                          @elseif ($i == $c)
                              <a href="#" id="like" class="btn btn-link like">Like <span class="badge">{{ $likeCount }}</span></a>
                              
                          @endif
                          @php
                              $c++;
                          @endphp
                      @endforeach
                      @if ($i == 0)
                          <a href="#" id="like" class="btn btn-link like">Like <span class="badge">{{ $likeCount }}</span></a>
                          
                      @endif
                      <a href="{{ route('post.show', [$post->id]) }}" class="btn btn-link">Comment</a>
                  </div>
                    
                </div> 

            @if (Auth::check())
                <div class="panel panel-default" style="margin: 10px; border-radius: 0;">
                  <div class="panel-body">
                      <form action="{{ url('/comment') }}" method="POST" style="display: flex;">
                          {{ csrf_field() }}
                          <input type="hidden" name="post_id" value="{{ $post->id }}">
                          <input type="text" name="comment" placeholder="Enter your Comment" class="form-control" style="border-radius: 0;">
                          <input type="submit" value="Comment" class="btn btn-primary" style="border-radius: 0;">
                      </form>
                      @if (count($errors) > 0)
                          <div class="alert alert-danger">
                              <a href="#" class="close" data-dismiss="alert">&times;</a>
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      {{ $error }}
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                      
                      @foreach ($post->comments as $comment)
                <div class="panel panel-default" style="margin: 10px; border-radius: 0;">
                  <div class="panel-body">
                      <div class="col-sm-9" style="margin-bottom: 20px">
                        <img src="/uploads/images/{{$comment->user->profile_image}}"
                          style="width:40px; height:40px; border-radius: 50%;">
                          <a href="{{route('front.profile', ['id'=>$post->user->id])}}" style="text-decoration: none; color: #666">
                        <span style="margin-left: 5px; font-weight: 600">
                          <small >{{ $comment->user->name }}</small>
                        </span> <br>
                      </a>
                          
                          <small >{{$comment->updated_at->diffForHumans() }}</small>
                          
                      </div>
                      <div class="col-sm-12" >
                          {{ $comment->comment }}
                      </div>
                  </div>
                </div>
            @endforeach
                  </div>
                </div>
            @endif
            @endforeach
        </div>

        <div class="col-sm-3">
            @foreach ($categories as $category)
                <a href="{{ route('category.showAll', [$category->name]) }}" class="badge">{{ $category->name }}</a>
            @endforeach
        </div>

<script type="text/javascript">
        $('.like').click(function(e) {
          e.preventDefault();
          var like = e.target.previousElementSibling == null;
          var postid = e.target.parentNode.dataset['postid'];
          var data = {
              isLike: like,
              post_id: postid
          }
          axios.post('/like', data).then(response => {
              $("[data-postid='" + response['data']['post_id'] + "'] > .active-like").attr('class', 'btn btn-link like');
              e.currentTarget.className = "btn btn-link like active-like";
          })
      });
    </script>
  
@endsection