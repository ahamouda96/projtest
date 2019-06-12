<nav class="navbar navbar-default navbar-static-top"> 
            <div class="navbar">
                <div class="logo">
                    <img src="images/LOGO.png" width="45px" height="45px">
                </div>
                <div class="nav-form">
                    <form>
                        <input type="text" placeholder="Search here people or pages...">
                    </form>
                </div>
                
                <div class="notifcation">
                    <a href="home.html">
                        <i class="fa fa-home"></i>
                    </a>
                </div>
                
                <div class="notifcation">
                    <a href="#">
                    <i class="fa fa-globe"></i>
                        </a>
                </div>
                
                <div class="notifcation">
                                <a href="comptation.html">
                            <i class='fas fa-medal' style='font-size:24px'></i>
                                </a>
                        </div>
                
                <div class="profile-info">
                    <div class="nav-profile-imge">
                        <a href="I%20talent(normal%20page%20for%20all).html"><img src="images/PU2.png" alt="Oops"></a>
                    </div>
                    <div class="nav-profile-name">
                        <ul class="my-dropdown">
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="margin-top: 2px">Name of T</a>
                            <ul class="dropdown-menu">
                                <li><a href="I%20talent(normal%20page%20for%20all).html">Profile</a></li>
                                <li id="setting-button"><span>Edit profile</span></li>
                                <li><a href="../Login/Login_v6/index.html">Log out</a></li>
                            </ul>
                            </li>
                        </ul>
                    
                    </div>
                </div>
            </div>
        </nav>















@extends('layouts.app')
    @section('content')  
       
    @endsection

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
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
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