<?php

namespace App\Http\Controllers\Api;
use App\Category;
use App\Http\Controllers\Controller;

use App\Http\Resources\CategoriesResource;
use App\Http\Resources\PostResource;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Post;

class CategoriesApiController extends Controller
{
    use ApiResponseTrait;

    public function index() {
        $categories = CategoriesResource::collection(Category::get());
        return response($categories,200);
    }

     public function showAll($id) {

         $categories = Category::find($id);
         if($categories){
             $posts = Post::where('category_id',$categories->id)->get();
             return $this->apiResponse(PostResource::collection($posts));
         }
         return $this->apiResponse(null,'category not found',404);


    }
    /*public function show($name) {

        $categories = Category::where('name',$name);
        if($categories){
            $posts = Post::where('category_id',$categories->id)->get();
            return $this->apiResponse(PostResource::collection($posts));
        }
        return $this->apiResponse(null,'category not found',404);


    }*/


}

