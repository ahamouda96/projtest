<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use Controller;
use App\User;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.admin');
    }

    public function listUser() {
        $users = User::orderBy('id', 'desc')->paginate(40);
        return view('user.index')->withUsers($users);
    }
    public function showUser($id) {
        $user = User::find($id);
        return view('user.show')->withUser($user);
    }
}
