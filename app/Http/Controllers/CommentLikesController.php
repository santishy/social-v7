<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentLikesController extends Controller
{
    public function store(Comment $comment){
      $comment->likes()->firstOrCreate([
        'user_id' => auth()->id(),
      ]);
    }

    public function destroy(Comment $comment){
      $comment->likes()->where([
        'user_id' => auth()->id(),
      ])->delete();
    }
}
