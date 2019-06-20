<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Validator;

class PostsCommentsApiController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return $this->apiResponse(CommentResource::collection($comments));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            [

                'comment' => 'required|min:10|max:200',
                'user_id' => 'required',
                'post_id' => 'required'


            ]);

        if($validate->fails()){
            return $this->apiResponse(null,$validate->errors(),422);
        }
        $comments=new Comment();
        $comments->comment=$request->comment;
        $comments->user_id=$request->user_id;
        $comments->post_id=$request->post_id;
        $comments->save();
        if($comments){

            return $this->apiResponse(new CommentResource($comments),null,201);
        }
        return $this->apiResponse(null,'unknown error',404);

    }
    /*public function edit(Request $request,$id)
    {
        $validate = Validator::make($request->all(),
            [
                'comment'=>'required'
            ]);
        if($validate->fails()){
            return $this->apiResponse(null,$validate->errors(),422);
        }
        $comment = Comment::find($id);
        if(!$comment){
            return $this->apiResponse(null,'comment not found',404);
        }
        $comment->update($request->all());
        if($comment){

            return $this->apiResponse(new CommentResource($comment),null,201);
        }
        return $this->apiResponse(null,'unknown error',404);

    }*/



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comment::find($id);
        if (!$comments){
            return $this->apiResponse(null,'comments not found');
        }
        return $this->apiResponse(new CommentResource($comments));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),
            [
                'comment' => 'required',


            ]);

        if($validate->fails()){
            return $this->apiResponse(null,$validate->errors(),422);
        }
        $comment = Comment::find($id);
        if(!$comment){
            return $this->apiResponse(null,'comment not found',404);
        }

        $comment->comment=$request->comment;
        $comment->save();
        if($comment){

            return $this->apiResponse(new CommentResource($comment),null,201);
        }
        return $this->apiResponse(null,'unknown error',404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $comments = Comment::find($id);
        if($comments){
            $comments->delete();
            return $this->apiResponse('comment successfully deleted',null,200);
        }
        return $this->apiResponse(null,'comment not found',404);
    }
}
