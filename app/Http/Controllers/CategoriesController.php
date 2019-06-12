<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;
use Auth;
use App\Post;

class CategoriesController extends Controller
{
    // public function index()
    // {
    //     $categories = Category::all();
    //     return view('admin.categories.index', compact('categories'));
    // }
    public function index() {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('category.index')->withCategories($categories);
    }
    
    public function showAll($name) {
        $categories = Category::all()->where('name', '=', $name)->first();
        if ($categories != null) {
            $posts = Post::all()->where('category_id', '=', $categories->id)->sortByDesc('id');
            return view('category.showAll')->withPosts($posts);
        }
        return redirect('/post');
    }
}
