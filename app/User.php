<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['profileLink','followLink','unfollowLink'];

    //protected $primaryKey = 'username';

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes(){
        return $this->belongsToMany(Post::class,'post_likes','user_id','post_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function getProfileLinkAttribute()
    {
        return route('user.show', $this);
    }

    public function getFollowLinkAttribute()
    {
        return route('user.follow', $this);
    }

    public function getUnfollowLinkAttribute()
    {
        return route('user.unfollow', $this);
    }

    public function isNot($user)
    {
        return $this->id !== $user->id;
    }

    public function isFollowing($user)
    {
        return (bool) $this->following()->where('user_id', $user->id)->count();
    }

    public function canFollow($user)
    {
        if(!$this->isNot($user)) {
            return false;
        }
        return !$this->isFollowing($user);
    }

    public function canUnFollow($user)
    {
        return $this->isFollowing($user);
    }



}
