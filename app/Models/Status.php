<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Status extends Model
{
    protected $guarded = [];

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function likes(){
      return $this->morphMany(Like::class,'likeable');
    }
    public function comments(){
      return $this->hasMany(Comment::class);
    }

    public function like(){
      return $this->likes()
                    ->firstOrCreate([
                      'user_id' => auth()->id()
                     ]);
    }

    public function isLiked(){
      return $this->likes()->where('user_id',auth()->id())->exists();
    }
    public function unliked(){
      return $this->likes()->where('user_id',auth()->id())->delete();
    }
    public function likesCount(){
      return $this->likes()->count();
    }
}