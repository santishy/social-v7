<?php

namespace App\Http\Controllers;
use App\User;
use App\Models\Friendship;

use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function show(User $user){
      return view('users.show',compact('user'));
    }
}
