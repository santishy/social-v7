<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Friendship;

class AcceptFriendshipsController extends Controller
{
  public function index()
  {
    //$friendshipsRequest = Friendship::with('sender')->where(['recipient_id' => auth()->id()])->get();
    return view('friendships.index', [
      'friendshipsRequest' => request()->user()->friendshipRequestsReceived
    ]);
  }
  public function store(User $sender)
  {

    request()->user()->acceptFriendRequestFrom($sender);

    return response()->json(['friendship_status' => 'accepted']);
  }
  public function destroy(User $sender)
  {

    request()->user()->denyFriendRequestFrom($sender);
    return response()->json(['friendship_status' => 'denied']);
  }
}
