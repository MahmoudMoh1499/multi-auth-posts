<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Example: Fetch post stats. Adjust according to your Post model.
        $published = $user->posts()->where('status', 'published')->count();
        $draft = $user->posts()->where('status', 'draft')->count();
        $total = $user->posts()->count();

        $recent = $user->posts()->latest()->take(5)->get(['id', 'title', 'status']);

        return response()->json([
            'stats' => [
                'published_posts' => $published,
                'draft_posts' => $draft,
                'total_posts' => $total,
            ],
            'recent_posts' => $recent,
        ]);
    }}
