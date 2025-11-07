<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\Resource;

class PostController extends Controller
{
    function index()
    {
        $posts = Post::paginate(5);
        return response()->json($posts);
    }

    function store(Request $request)
    {
        $validated=Validator::make($request->all(), [
            'title' => 'required|string|unique:posts,title',
            'body' => 'required|string',
        ])->validate();

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    function show($id)
    {
        $validated=Validator::make(['id' => $id], [
        'id' => 'required|exists:posts,id',
        ])->validate();

        if(!$validated){
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post = Post::where('id','=',$id)->with('comments')->get();
        return response()->json($post);
    }

    function destroy($id)
    {
        // find the post first; if not found return 404
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();

        // return a JSON message with 200 so clients see the message body
        return response()->json(['message' => 'Post Deleted'], 200);
    }

    function search(Request $request)
    {
        $keyword = $request->query('search');

        $posts = Post::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('body', 'like', '%' . $keyword . '%')
            ->with('comments')
            ->get();

        return response()->json($posts);
    }
}
