<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\Traits\UploadTrait;
use App\User;
use App\Role;
use App\Profile;
use Controller;
use Auth;
use Image;
use Storage;
use DB;
use Validator;
class AdminUsersController extends Controller
{
    use UploadTrait;

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.create', compact('roles')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
    
        $name="default.jpg";
        if($file = $request->file('profile_image')){           
            $image = $request->file('profile_image');
            // Make a image name based on user name and current timestamp
            $name = str_slug($request->input('name')).'_'.time();
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath =  $name. '.' . $image->getClientOriginalExtension();   
            $file->move('uploads/images', $filePath);   
        }

      
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->role_id=$request->role_id;
        $user->profile_image=$filePath;
        $user->save();
        return redirect('/admin/users');
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
       $user = User::findOrFail($id);
       $roles = Role::pluck('name', 'id')->all();
       return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $file = $request->file('profile_image');
        if($file){  
            if(!empty($user->profile_image)) {
            if (file_exists(public_path('\uploads\images\\'. $user->profile_image))) {
                unlink(public_path('\uploads\images\\').$user->profile_image);
              }
            }
            // unlink(public_path('\uploads\images\\').$user->profile_image);
         
            $image = $request->file('profile_image');
            // Make a image name based on user name and current timestamp
            $name = str_slug($request->input('name')).'_'.time();
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath =  $name. '.' . $image->getClientOriginalExtension();   
            $file->move('uploads/images', $filePath);   
        }


        $user->name=$request->name;
        $user->email=$request->email;
        if($file){
            $user->profile_image=$filePath;
        }
        if($request->password){
            $user->password=bcrypt($request->password);
        }
        $user->role_id=$request->role_id;
        $user->save();
        
        
        return redirect('/admin/users');

    if(trim($request->password) == '' ){
            
        $input = $request->except('password');
    }else{
        
        $input = $request->all();
        // $input['password'] = bcrypt($request->password);
    }   

    $user = User::findOrFail($id);
    
    $user->update($input);

    return redirect('/admin/users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id); 
        // remove the file at public/images/filename and record in photos table
        // unlink(public_path().$user->photo->file);
        // Photo::findOrFail($user->photo_id)->delete();
        // Session::flash('deleted_user',$user->name);
        // $user->delete();
        // return redirect('/admin/users');


        // if ($user->image != null) {
        //     Storage::delete($user->image);
        // }

        if(!empty($user->profile_image)) {
            if (file_exists(public_path('\uploads\images\\'. $user->profile_image))) {
                unlink(public_path('\uploads\images\\').$user->profile_image);
            }
        }

        // unlink(public_path('\uploads\images\\').$user->profile_image);

        $user->delete();
        Session::flash('success', 'User was succesfully deleted');
        return redirect('/admin/users');
    }

}
