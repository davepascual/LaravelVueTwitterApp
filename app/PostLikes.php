<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLikes extends Model
{
    protected $fillable = ['post_id','user_id'];

    protected $casts  = ['liked'=>'boolean'];



    public function likePost($post_id, $user_id)
    {
        $likePost = PostLikes::where(['post_id'=>$post_id,'user_id'=>$user_id])->first();
       
        if($likePost === null)
        {
            $likePost = new PostLikes;
            $likePost->post_id = $post_id;
            $likePost->user_id = $user_id;
            $likePost->liked = true;
            $likePost->save();
        }
        else
        {
                $likePost->delete();
        }
        
        return $likePost;
    }

    public function _likePost($user, $post)
    {
        if($post->isLiked())
            $user->likes()->attach($post);
        else
            $user->likes()->detach($post);

        return $post; 
    }

    public function likes()
    {
    	return $this->belongsToMany(Post::class,'post_likes','user_id','post_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }



}
