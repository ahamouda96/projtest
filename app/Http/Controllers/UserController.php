<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use App\User;

class UserController extends Controller
{

    public function index()
    {
        return view('test');
    }

    public function show()
    {
        return view('profile');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile',compact('user',$user));
    }


    public function viewProfile($id)
    {
        $user = User::find($id);
        return view('user.profile')->withUser($user);
    }

    public function addFollower(User $user)
    {
        $friend = auth()->user()->addFollower($user);

        if($friend === null){
            return response()->json(['message' => 'Already a friend'], 500);
        }

        return response()->json($friend);
    }

    // // 
    // public function viewProfile(User $user)
    // {
    //     return view('user.profile', ['
    //         'user' => $user,
    //         ']);
    // }


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
