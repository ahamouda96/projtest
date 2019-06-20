<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostsCreateRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\PostsEditRequest;

use App\Post;
use App\User;
use App\PostMedia;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Storage;


class PostsApiController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        /*$posts = Post::all()->sortByDesc('id');
        $categories = Category::all();*/
        $posts = Post::with('Category')->get();

        return $this->apiResponse($posts);
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
        $validate = Validator::make($request->all(),
            [

                'body' => 'required|min:10|max:200',
                'user_id' => 'required',
                'category_id' => 'required'

            ]);

        if($validate->fails()){
            return $this->apiResponse(null,$validate->errors(),422);
        }
        $post = Post::create($request->all());
        if($post){

            return $this->apiResponse(new PostResource($post),null,201);
        }
        return $this->apiResponse(null,'unknown error',404);

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
        if($post){
            return $this->apiResponse(new PostResource($post));
        }
        return $this->apiResponse(null,'post not found',404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (Auth::user()->id != $post->user_id && $post == null) {
            abort(404);
        }

        $categories = Category::all();
        return view('posts.edit')->withPost($post)->withCategories($categories);
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id)
    {
        $validate = Validator::make($request->all(),
            [

                'body' => 'required|min:10|max:200',
                'user_id' => 'required',
                'category_id' => 'required'

            ]);

        if($validate->fails()){
            return $this->apiResponse(null,$validate->errors(),422);
        }
        $post = Post::find($id);
        if(!$post){
            return $this->apiResponse(null,'post not found',404);
        }

        $post->update($request->all());
        if($post){

            return $this->apiResponse(new PostResource($post),null,201);
        }
        return $this->apiResponse(null,'unknown error',404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function delete($id){

       $post = Post::find($id);
       if($post){
           $post->delete();
           return $this->apiResponse('post successfully deleted',null,200);
       }
       return $this->apiResponse(null,'post not found',404);

   }

    // public function post($id){
    //     $post = Post::findOrFail($id);
    //     return view('post', compact('post'));
    // }

}
