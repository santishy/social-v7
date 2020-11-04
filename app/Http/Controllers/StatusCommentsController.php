<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Status;
use App\Http\Resources\CommentResource;

class StatusCommentsController extends Controller
{
    public function store(Status $status,Request $request){
      $validateRequest = $request->validate([
        'body' => 'required'
      ]);
      
      $comment = $request->user()->comments()->create(
        array_merge($validateRequest,['status_id' => $status->id])
      );
      
      $commentResource = CommentResource::make($comment);
      CommentCreated::dispatch($commentResource);
      return $commentResource;
    }
}
