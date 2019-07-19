<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Users;

class Post extends Model
{

    protected $fillable = ['user_id', 'body'];

    protected $appends = ['createdDate','likeLink'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medias()
    {
        return $this->hasMany(MediaAttachment::class,'post_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class,'post_likes','post_id','user_id')->withTimestamps();
    }

    public function likedBy($user){
        return (bool) $this->where('user_id',$user->id)->count();
    }

    public function replies(){
        return $this->hasMany(PostReply::class, 'post_id','id');
    }

    public function fetchPostByUser($username)
    {
        return $this->with('users')->where('users.username','=',$username);
    }

    public function following()
    {
        $this->user()->following;
    }

    public function isUserLiked($user){

        return (bool) $user->likes()->where('post_id',$this->id)->count();         
    }

    public function isLiked($user = null)
    {
        if($user === null)
            $user = auth()->user();

        return (bool) $user->likes()->where('post_id',$this->id)->count(); 
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getLikeLinkAttribute()
    {
        return route('posts.like',$this);
    }

    public function getUnlikeLinkAttritbute(){
        return route('posts.unlike',$this);
    }


}
