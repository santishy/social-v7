<?php

namespace App\Traits;

use App\Events\ModelLiked;
use App\Events\ModelUnliked;
use App\Models\Like;
use Illuminate\Support\Str;

trait HasLikes
{
    public function likes(){
      return $this->morphMany(Like::class,'likeable');
    }

    public function like(){
      ModelLiked::dispatch($this,auth()->user());
      return $this->likes()->firstOrCreate([
        'user_id' => auth()->id()
      ]);
        
    }

    public function unliked(){
      $this->likes()->where([
        'user_id' => auth()->id()
      ])->delete();
      ModelUnliked::dispatch($this);
    }

   public function isLiked(){
     return $this->likes()->where([
       'user_id' => auth()->id()
     ])->exists();
   }
   
   public function likesCount(){
     return $this->likes()->count();
   }

   public function eventChannelName(){
     return strtolower(str::plural(class_basename($this))).'.'.$this->id.'.likes';
   }

   abstract function path();
}
