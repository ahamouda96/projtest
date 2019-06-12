<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostsCreateRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\PostsEditRequest;
use Controller; 
use App\Post;
use App\User;
use App\PostMedia;
use App\Category;


class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all();
        $posts = Post::paginate(2);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name','id')->all();
        return view('admin.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        if($request->file('media')){           
            $file = $request->file('media');
            $mediaType=explode('/',$file->getMimeType())[0];
            $name = str_slug($request->input('name')).'_'.time();
            $filePath =  $name. '.' . $file->getClientOriginalExtension();  
             
            if($mediaType=="image" )
            {
                $file->move('uploads/posts/images', $filePath);   
            }
            elseif($mediaType=="video")
            {
                $file->move('uploads/posts/video', $filePath);   
            }
            else
            {
                return redirect('admin/posts')->with('error');
            }
        }

            $post=new Post();
            $post->body=$request->body;
            $post->user_id=Auth::user()->id;
            $post->category_id=$request->category_id;
            $post->save();

            if($request->file('media')){
                $Media = new PostMedia();
                $Media->type = $mediaType;
                $Media->path = $filePath;
                $Media->post_id = $post->id;
                $Media->save();
                
            }        

        return redirect('admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::pluck('name','id')->all();

        return view('admin.posts.edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$input = $request->all();
        $post = Post::findOrFail($id);
        $user = Auth::user();
        if($request->file('media')){  
            if ($post->media != null && $post->media == "video"){
                unlink(public_path('\uploads\posts\video\\').$post->postMedia->path);
            }
            if ($post->media != null && $post->media == "image"){
                unlink(public_path('\uploads\posts\images\\').$post->postMedia->path);          
            }
            $file = $request->file('media');
            $mediaType=explode('/',$file->getMimeType())[0];
            $name = str_slug($request->input('name')).'_'.time();
            $filePath =  $name. '.' . $file->getClientOriginalExtension();  
             
            if($mediaType=="image" )
            {
                $file->move('uploads/posts/images', $filePath);   
            }
            elseif($mediaType=="video")
            {
                $file->move('uploads/posts/video', $filePath);   
            }
            else
            {
                return redirect('admin/posts')->with('error');
            }
        }
        
        $post->body=$request->body;
        $post->user_id=Auth::user()->id;
        $post->category_id=$request->category_id;
        $post->save();

        if($request->file('media')){
            $Media = new PostMedia();
            $Media->type = $mediaType;
            $Media->path = $filePath;
            $Media->post_id = $post->id;
            $Media->save();
        }
        return redirect('admin/posts');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (Auth::user()->id != $post->user_id) {
            abort(404);
        }
        if ($post == null) {
            abort(404);
        }
        if ($post->image != null) {
            Storage::delete('/uploads/posts/images/'.$post->image);
        }

        if ($post->video != null) {
            Storage::delete('/uploads/posts/video/'.$post->image);
        }
           
        // $mediaType = PostMedia::type;
        // if($mediaType::type=="image" )
        // {
        //     Storage::delete('uploads/posts/images', $filePath);   
        // }
        // elseif($mediaType=="video")
        // {
        //     Storage::delete('uploads/posts/video', $filePath);   
        // }

        $post->delete();
        return redirect('/admin/posts');
    }

    public function post($id){
        $post = Post::findOrFail($id);
        return view('post', compact('post'));
    }
    
}
