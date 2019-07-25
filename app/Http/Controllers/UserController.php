<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follower;
use App\PostLikes;

class UserController extends Controller
{
    public function show(User $user)
    {
        //$user = User::find($user->username);
        return view('user', ['user'=>$user]);
    }

    public function currentUser(Request $request)
    {
        return json_encode(auth()->user());
    }

    public function follow(Request $request, User $user)
    {
        //return response()->json($request->user()->following()->get());
        if($request->user()->canFollow($user)) {
            $request->user()->following()->attach($user);
        }
        else if($request->user()->canUnFollow($user)) {
            $request->user()->following()->detach($user);
        }
        return redirect()->back();
    }

    public function unFollow(Request $request, User $user)
    {
        if($request->user()->canUnFollow($user)) {
            Follower::where(function($q) use ($user){
                $q->where('user_id',$user->id)
                ->where('follower_id', auth()->user()->id);
            })->delete();
        }
        return redirect()->back();
    }

    public function showFollowers(User $user)
    {
        
    }

    public function isUserLikedPost($post_id)
    {
        //return auth()->user()->likedPost()->where('post_id',$post_id)->get();
        $postLiked =  auth()->user()->likedPost()->where('post_id',$post_id)->first();
        return response()->json($postLiked);
    }
}
