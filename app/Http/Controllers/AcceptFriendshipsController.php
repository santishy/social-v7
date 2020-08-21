<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Friendship;

class AcceptFriendshipsController extends Controller
{
    public function store(User $sender){
      Friendship::where([
        'sender_id' => $sender->id,
        'recipient_id' => auth()->id(),
      ])->update(['status' => 'accepted']);
    }

    public function destroy(User $sender){
      Friendship::where([
        'sender_id' => $sender->id,
        'recipient_id' => auth()->id(),
      ])->update(['status' => 'denied']);
    }
}
