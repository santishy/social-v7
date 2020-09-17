<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Friendship;

class AcceptFriendshipsController extends Controller
{
    public function index(){
      $friendshipsRequest = Friendship::with('sender')->where(['recipient_id' => auth()->id()]);
      return view('friendships.index',compact('friendshipsRequest'));
    }
    public function store(User $sender){
      Friendship::where([
        'sender_id' => $sender->id,
        'recipient_id' => auth()->id(),
      ])->update(['status' => 'accepted']);
      return response()->json(['friendship_status' => 'accepted']);
    }
    public function destroy(User $sender){
      Friendship::where([
        'sender_id' => $sender->id,
        'recipient_id' => auth()->id(),
      ])->update(['status' => 'denied']);
      return response()->json(['friendship_status' => 'denied']);
    }
}
