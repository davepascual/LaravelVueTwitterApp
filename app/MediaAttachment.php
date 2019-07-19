<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaAttachment extends Model
{
    //
    protected $table = "media_attachments";

    protected $fillable = ['post_id','name','type'];
}
