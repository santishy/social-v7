<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Status;
use App\Http\Resources\CommentResource;

class StatusCommentsController extends Controller
{
    public function store(Status $status,Request $request){
      $comment = Comment::create(['body' => $request->body,
                              'user_id' => auth()->id(),
                              'status_id' => $status->id]);
      return CommentResource::make($comment);
    }
}
