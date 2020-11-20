<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Traits\HasLikes;

class Comment extends Model
{
    protected $guarded = [];

    use HasLikes;

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function path(){
      return route('statuses.show',$this->status_id)."#comment-{$this->id}";
    }

    public function status(){
      return $this->belongsTo(Status::class);
    }

}
