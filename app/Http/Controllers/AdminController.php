<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        $stats = [
            'posts' => Post::count(),
            'users' => User::count(),
            'published' => Post::where('status', 'published')->count()
        ];

        $activity = Post::latest()
            ->with('user')
            ->take(5)
            ->get()
            ->map(function ($post) {
                return [
                    'message' => "New post '{$post->title}' created",
                    'created_at' => $post->created_at
                ];
            });

        return response()->json([
            'stats' => $stats,
            'activity' => $activity
        ]);
    }
}
