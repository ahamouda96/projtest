<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use Illuminate\Http\Request;
use App\Like;
use App\Post;
use Auth;

class LikesApiController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request) {

        $likes = LikeResource::collection(Like::get());
        if(!$likes){
            return $this->apiResponse(null,'like not found',404);
        }

        return $this->apiResponse($likes);
    }
}

