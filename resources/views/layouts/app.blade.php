<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }
        .fa-btn {
            margin-right: 6px;
        }
        .active-like{
            text-decoration: underline;
            color: red;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else

                    <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Friend Request <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @foreach (Auth::user()->friends1->where('approved', '=', false) as $friend1)
                                        <li>
                                            <img src="/uploads/images/{{ $friend1->user1->profile_image }}" alt="Profile Picture" width="50" height="50">
                                            <div style="display: inline-block">
                                                {{ $friend1->user1->name }}
                                                <div data-userid="{{ $friend1->user1->id }}">
                                                    <a href="#" class="btn btn-success btn-sm request">Accept</a>
                                                    <a href="#" class="btn btn-danger btn-sm request">Cancel</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    @if (Auth::user()->friends1->where('approved', '=', false)->count() == 0)
                                        You Don't have any Friend Request
                                    @endif
                                </ul>
                            </li>


                           

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    View Tags <span class="caret"></span>
                                </a>
                            
                                <ul class="dropdown-menu" role="menu">
                            @foreach (Auth::user()->friends1 as $friend)
                                @foreach ($friend->user1->posts as $post)
                                    @foreach ($post->friends as $tag)
                                        @php
                                            $user = App\Friend::find($tag->id);
                                        @endphp
                                        @if($user->user_id_2 == Auth::user()->id)
                                        
                                            <div class="panel panel-default">
                                              <div class="panel-heading">
                                                <h3 class="panel-title">
                                                   
                                                    <div class="pull-right">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                                <span class="caret"></span>
                                                            </a>

                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a href="{{ route('post.show', [$post->id]) }}">Show Post</a></li>
                                                                <li><a href="{{ route('post.edit', [$post->id]) }}">Edit Post</a></li>
                                                                <li>
                                                                    <a href="#" onclick="document.getElementById('delete').submit()">Delete Post</a>
                                                                    {!! Form::open(['method' => 'DELETE', 'id' => 'delete', 'route' => ['post.delete', $post->id]]) !!}
                                                                    {!! Form::close() !!}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </h3>
                                              </div>
                                              <div class="panel-body">
                                                {{ $post->body }}
                                                <br />
                                                Category: <div class="badge">{{ $post->category->name }}</div>
                                              </div>
                                            </div>
                                            @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </ul>

                            </li>





                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative; padding-left:50px;">
                            @if (auth()->user()->image)
                                <img src="/uploads/images/{{ (auth()->user()->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                            @endif
                                <!-- <img src="Auth::user()->profile ? Auth::user()->profile->file : '/uploads/avatars/default.png' }}" style="width:32px; height:32px; position:absolute; top:10px; left:10px; border-radius:50%"> -->
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>  

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('front.profile', ['id'=>auth()->user()->id]) }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                                <li><a href="{{ url('/editprofile') }}"><i class="fa fa-btn fa-user"></i>Edit Profile</a></li>
                                <li><a href="{{ url('/posts') }}"><i class="fa fa-btn fa-user"></i>Posts</a></li>
                                <li><a href="{{ url('/users') }}"><i class="fa fa-btn fa-user"></i>Users</a></li>
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fa fa-btn fa-sign-out"></i>Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                    </form>        
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="'js/main.js"></script>
    
    
    <script>
        $(document).ready(function(){
        
        $('.like').click(function(e) {
            e.preventDefault();
            var like = e.target.previousElementSibling == null;
            var postid = e.target.parentNode.dataset['postid'];
            var data = {
                isLike: like,
                post_id: postid
            }
            axios.post('/like', data).then(reponse => {
                e.currentTarget.className = "btn btn-link like active"
            })
        });
        $('.friend').click(function(e){
            e.preventDefault();
            var friendid = e.target.parentNode.dataset['friendid'];
            var data ={
                friend_id : friendid
            };   
            axios.post('/friend', data).then(reponse => {
                e.currentTarget.className = "btn btn-link active-like"
            })
        });
        
        
    });
    $('.remove-friend').click(function(e) {
    e.preventDefault();
    var friendid = e.target.parentNode.dataset['friendid'];
    var data = {
        friend_id: friendid
    }
    axios.post('/friend/remove', data).then(response => {
        e.target.innerHTML = "Add Friend";
        e.currentTarget.className = "btn btn-link friend";
    })
});
$('.request').click(function(e) {
    e.preventDefault();
    var request = e.target.previousElementSibling == null;
    var userid = e.target.parentNode.dataset['userid'];
    var data = {
        isRequest: request,
        user_id: userid
    }
    axios.post('/request', data).then(response => {
        console.log(e);
        if (response.data['true']) {
            e.currentTarget.parentElement.innerHTML = "<span class='success'>You are now Friends</span>";
        }
        else {
            e.currentTarget.parentElement.innerHTML = "<span class='danger'>You canceled the friend request</span>";
        }
    })
});
    
    </script>
</body>
</html>
