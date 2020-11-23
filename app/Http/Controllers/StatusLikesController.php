<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusLikesController extends Controller
{
    public function store(Status $status){
         $status->like();
         return response()->json([
            'likes_count' => $status->likesCount()
         ]);
    }
    public function destroy(Status $status){
        $status->unliked();
        return response()->json([
         'likes_count' => $status->likesCount()
      ]);
    }
}
