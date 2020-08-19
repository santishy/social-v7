<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;
use App\User;

class UsersStatusesController extends Controller
{
    public function index(User $user){
      return StatusResource::collection($user->statuses()->latest()->paginate());
    }
}
