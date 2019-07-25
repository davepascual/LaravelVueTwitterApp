<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostReply extends Model
{
    //
    protected $fillable = ['post_id','user_id','content'];

    protected $appends = ['createdDate'];

    public function post(){
    	return $this->belongsTo(Post::class);
    }

    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }


}
