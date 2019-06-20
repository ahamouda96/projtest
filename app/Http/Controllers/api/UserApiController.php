<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Image;

class UserApiController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $user = UsersResource::collection(User::orderBy('id','desc')->paginate(20));
        return $this->apiResponse($user);
    }
    public function showUser($id){

        $user = User::find($id);
        if($user){
            return $this->apiResponse(new UsersResource($user));
        }
        return $this->apiResponse(null,'user not found',404);


    }
    public function update(Request $request, $id)
    {

        $validate = Validator::make($request->all(),
            [

                'name' => 'required',
                'email' => 'required',
                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'

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



    }


    // public function update_avatar(Request $request){
    // 	Handle the user upload of avatar
    // 	if($request->hasFile('avatar')){
    // 		$avatar = $request->file('avatar');
    // 		$filename = time() . '.' . $avatar->getClientOriginalExtension();
    // 		Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
    // 		$user = Auth::user(); // to get the current logged in user
    // 		$user->avatar = $filename; // to store the file name inside avatar row
    // 		$user->save();
    // 	}
    // 	return view('profile', array('user' => Auth::user()) ); // redirect to current profile
    // }
}
