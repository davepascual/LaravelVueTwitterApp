<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\PostLikes;
use App\PostReply;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{

    public function index(Request $request, Post $post)
    {
       /* $posts = $post->whereIn('user_id', $request->user()->following()
                        ->pluck('users.id')
                        ->push($request->user()->id))
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->take($request->get('limit', 10))
                        ->get();*/


       

        /*$posts = Post::with('user')
                ->leftJoin('users',function($join){
                    $join->on('users.id','=','posts.user_id');
                    $join->rightJoin('followers','followers.user_id','=','users.id');
                })
                ->get();*/

       $posts = Post::with(['user','likes','replies','medias'])
       ->withCount('replies')
       ->orderBy('created_at','desc')
       ->take(10)
       ->get();
          
        return response()->json($posts);
    }

    public function store(Request $request,Post $post)
    {
      $request->validate([
        'body' => 'required'
      ]);

      $newPost = $request->user()->posts()->create([
          'body' => $request->get('body')
      ]);
      

      if($request->images)
      {
        $i = 0;
        foreach($request->images as $image)
        {
          $imageName = date('mdYHis').'_'.time().'.'.$i.$image->getClientOriginalExtension();
          $image->move(public_path('images'), $imageName);

          $newPost->medias()->create([
            'name' => $imageName,
            'type' => 'photo'
          ]);
          $i++;
        }
      }

      return response()->json($post->with('user','medias')->find($newPost->id));
    }

    public function byUser($username)
    {
        
        $posts =  User::where(function($u) use ($username){
          $u->where('id',$username)
          ->orWhere('username',$username);
        })
        ->first()
        ->posts()
        ->with(['user','likes'])
        ->get();

        return response()->json($posts);
    }


    public function likePost(Request $request)
    {
      $postData = $request->postData;
      $post = Post::find($postData['id']);
      if( (bool) $post->likes()->where('user_id',auth()->user()->id)->count() )
        $post->likes()->detach(auth()->user());
      else
        $post->likes()->attach(auth()->user());
       
       return $post;
    }

    public function replyPost(Request $request)
    {
       $reply = new PostReply;
       $reply->post_id = $request->postID;
       $reply->user_id = auth()->user()->id;
       $reply->content = $request->replyMessage;
       $reply->save();

       return response()->json(PostReply::where('id',$reply->id)->with(['user'])->first());
    }
}
