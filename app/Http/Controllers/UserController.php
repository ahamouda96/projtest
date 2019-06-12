<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('profile',compact('user',$user));
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
