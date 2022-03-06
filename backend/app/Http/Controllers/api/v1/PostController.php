<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollectionResource;
use App\Models\Post;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->orderBy('id', 'DESC')->paginate(15);
        return PostCollectionResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return new PostCollectionResource($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if(Auth::user()->can('modifyPost', Post::findOrFail($id))) {
            if ($post == true) {
                return response()->json([
                    'data' => [
                        'status' => 'ok'
                    ]
                ], Response::HTTP_OK);
            }
        }else{
            return response()->json([
                'data' => [
                    'error' => 'This post is not your post.'
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function delete($id)
    {
        if(Auth::user()->can('modifyPost', Post::findOrFail($id))) {
            $post = Post::where('id', $id)->delete();
            if ($post == true) {
                return \response()->json([
                    'data' => [
                        'status' => 'ok'
                    ]
                ], Response::HTTP_OK);
            } else {
                return \response()->json([
                    'data' => [
                        'error' => 'Post not found'
                    ]
                ], Response::HTTP_NOT_FOUND);
            }
        }else{
            return response()->json([
                'data' => [
                    'error' => 'This post is not your post'
                ]
            ], Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        return new PostCollectionResource($post);
    }
}
