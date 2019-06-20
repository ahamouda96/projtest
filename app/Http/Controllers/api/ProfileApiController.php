<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

use App\User;
use Illuminate\Support\Facades\Validator;

class ProfileApiController extends Controller
{
    use UploadTrait;
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function update(Request $request, $id)
    {

        $validate = Validator::make($request->all(),
            [

                'name' => 'required',
                'email' => 'required',
                /*'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'*/

            ]);

        if ($validate->fails()) {
            return $this->apiResponse(null, $validate->errors(), 422);
        }
        $user = User::find($id);
        if (!$user) {
            return $this->apiResponse(null, 'user not found', 404);
        }

        $user->update($request->all());
        if ($user) {

            return $this->apiResponse(new UsersResource($user), null, 201);
        }
        return $this->apiResponse(null, 'unknown error', 404);


        /**
         * Follow the user.
         *
         * @param $profileId
         *
         */


    }
}
