<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:admin')->only(['index']);
        // $this->middleware('auth:api')->except(['index']);
    }
    public function index(): PostCollection
    {
        return new PostCollection(
            Post::with('user')->latest()->paginate(10)
        );
    }
    public function userPosts(Request $request): PostCollection
    {
        return new PostCollection(
            $request->user()->posts()->latest()->paginate(10)
        );
    }

    public function store(StorePostRequest $request): PostResource
    {
        $post = $request->user()->posts()->create($request->validated());

        return new PostResource($post);
    }


    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());

        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(null, 204);
    }
}
