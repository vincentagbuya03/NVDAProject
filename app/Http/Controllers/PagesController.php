<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function user_profiles (){
        $posts = Post::with(['user.profile'])->get();
        return view('user_profiles')->with('posts', $posts);
    }
}
