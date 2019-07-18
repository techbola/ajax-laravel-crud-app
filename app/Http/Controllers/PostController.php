<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    public function addPost(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'body' => 'required'
        );

        $validator = Validator::make(input::all(), $rules);
        if ($validator->fails()){
            return response()->json(array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        else{

            $post = new Post();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->save();

            return response()->json($post);
        }
    }

    public function editPost(Request $request)
    {

        $rules = array(
            'title' => 'required',
            'body' => 'required'
        );

        $validator = Validator::make(input::all(), $rules);

        if ($validator->fails()){
            return response()->json(array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        }
        else {

            $post = Post::find($request->id);
            $post->title = $request->title;
            $post->body = $request->body;
            $post->save();

            return response()->json($post);
        }
    }

    public function deletePost(Request $request)
    {

        $post = Post::find($request->id)->delete();
        return response()->json();
    }

}
