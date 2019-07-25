<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class TestController extends Controller
{
    //

    public function index()
    {
    	return view('test.page');
    }

    public function store(Request $request, Post $post)
    {
      $request->validate([
        'body' => 'required'
      ]);

      $newPost = $request->user()->posts()->create([
          'body' => $request->get('body')
      ]);

      //return var_dump($request->images);

      if($request->images)
      {
        foreach($request->images as $image)
        {
          $imageName = date('mdYHis').'_'.time().'.'.$image->getClientOriginalExtension();
          $image->move(public_path('images'), $imageName);

          $newPost->medias()->create([
            'name' => $imageName,
            'type' => 'photo'
          ]);
        }
      }

      return back();
 
      //return response()->json($post->with('user')->find($newPost->id));
    }
}
