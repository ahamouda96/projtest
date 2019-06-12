@extends('layouts.blog-post')

@section('content')
	
	<!-- Title -->
    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{$post->photo ? $post->photo->file : null}}" alt="">

    <hr>

    <!-- Post Content -->
    <p>{!! $post->body !!}</p>

    <hr>

    <!-- Blog Comments -->

    <!-- Comments Form -->
	@if (Auth::check())
        {{-- true expr --}}

    	@if (Session::has('comment_message'))
    		<p class="bg-primary">{{session('comment_message')}}</p>
    	@endif

        <div class="well">
            <h4>Leave a Comment:</h4>

    		{!! Form::open(['method'=>'POST','action'=>'PostCommentsController@store']) !!}
    			
    			<input type="hidden" name="post_id" value="{{$post->id}}">
    	
    		    <div class='form-group'>
    		        {!! Form::textarea('body',null,['class'=>'form-control','rows'=>3]) !!}
    		    </div>

    		    <div class='form-group'>
    		        {!! Form::submit('Submit comment',['class'=>'btn btn-primary']) !!}
    		    </div>

    		{!! Form::close() !!}

        </div>

        <hr>

        

                    </div>
                </div>
                
           

        <!-- End Comment -->
    
        <!-- DISQUS Comment Plugin-->

        <div id="disqus_thread"></div>
            <script>
            
            /**
            *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
            *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
            /*
            var disqus_config = function () {
            this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            */
            (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://return1225.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
            })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    
        <script id="dsq-count-scr" src="//return1225.disqus.com/count.js" async></script>

        <!-- End DISQUS Comment Plugin-->
            
    @endif

@endsection



@section('scripts')
<script type="text/javascript">

    $(".comment-reply-container .toggle-reply").click(function(){
        $(this).next().slideToggle("slow");
    });

</script>
@endsection



















