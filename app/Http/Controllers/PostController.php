<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::with('user')->orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        $query = Post::create([
            'post' => $request->post,
            'type' => $request->type,
            'user_id' => Auth::id()
        ]);


        return Post::with('user')->find($query->id);

    }
}
