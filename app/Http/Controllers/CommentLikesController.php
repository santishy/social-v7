<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentLikesController extends Controller
{
    public function store(Comment $comment){
      $comment->like();
      return response()->json([
        'likes_count' => $comment->likesCount()
      ]);
    }

    public function destroy(Comment $comment){
      $comment->unliked();
      return response()->json([
        'likes_count' => $comment->likesCount()
      ]);
    }
}
