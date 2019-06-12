<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostsCreateRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\PostsEditRequest;

use App\Post;
use App\User;
use App\PostMedia;
use App\Category;
use Storage;

class PostsController extends Controller
{
    //

    public function index()
    {
        $posts = Post::all()->sortByDesc('id');
        $categories = Category::all();
        return view('posts.index')->withPosts($posts)->withCategories($categories);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
                return redirect('posts')->with('error');
            }
        }

            $post=new Post();
            $post->body=$request->body;
            $post->user_id=Auth::user()->id;
            $post->category_id=$request->category;
            $post->save();

            if($request->file('media')){
                $Media = new PostMedia();
                $Media->type = $mediaType;
                $Media->path = $filePath;
                $Media->post_id = $post->id;
                $Media->save(); 
            }  
            if (isset($request->tags)) {
                $post->friends()->sync($request->tags, false);
            }       
        Session::flash('success', 'Post was successfully added');
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
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
        if (Auth::user()->id != $post->user_id) {
            abort(404);
        }
        if ($post == null) {
            abort(404);
        }
        $categories = Category::all();
        return view('posts.edit')->withPost($post)->withCategories($categories);
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
        $post = Post::find($id);
        $Media = PostMedia::all();
        $user = Auth::user();
        if($request->file('media')){  
            $file = $request->file('media');
            if($file){  
                if(!empty($filePath) && $mediaType == "video") {
                    if (file_exists(public_path('\uploads/posts/video\\'. $filePath))) {
                        unlink(public_path('\uploads/posts/video\\').$filePath);
                        $Media->delete();
                  }
                }
                elseif(!empty($filePath) && $mediaType == "image"){
                    if (file_exists(public_path('\uploads/posts/images\\'. $filePath))) {
                        unlink(public_path('\uploads/posts/images\\').$filePath);
                        $Media->delete();
                      }
                }
                
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
                    return redirect('/posts')->with('error');
                }
            }
            
        }

        if($request->file('media')){

            $Media = new PostMedia();
            
            $Media->type = $mediaType;
            $Media->path = $filePath;
            $Media->post_id = $post->id;
            $Media->save();
        }

        $post->body=$request->body;
        $post->user_id=Auth::user()->id;
        $post->category_id=$request->category;
        $post->save();
        
        if (isset($request->tags)) {
            $post->friends()->sync($request->tags);
        }
        
        Session::flash('success', 'Post was successfully added');
        return redirect()->back();
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
            Storage::delete('uploads/posts/images/'.$post->image);
        }

        if ($post->video != null) {
            Storage::delete('uploads/posts/video/'.$post->image);
        }

        $post->delete();
        Session::flash('success', 'Post was succesfully deleted');
        return redirect('/posts');
           
        // $mediaType = PostMedia::type;
        // if($mediaType::type=="image" )
        // {
        //     Storage::delete('uploads/posts/images', $filePath);   
        // }
        // elseif($mediaType=="video")
        // {
        //     Storage::delete('uploads/posts/video', $filePath);   
        // }

        
    }

    // public function post($id){
    //     $post = Post::findOrFail($id);
    //     return view('post', compact('post'));
    // }
    
}
