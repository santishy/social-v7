<?php

namespace App\Http\Controllers;

use App\Events\StatusCreated;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Http\Resources\StatusResource;
use Illuminate\Support\Facades\Event;

class StatusesController extends Controller
{
    public function index(){
      return StatusResource::collection(Status::latest()->paginate());
    }
    public function store(Request $request){
      
      $body = $request->validate(['body' => 'required|min:5']);
      $status = $request->user()->statuses()->create($body);
      $statusResource = new statusResource($status);
      StatusCreated::dispatch($statusResource);
      return $statusResource;
    }

    public function show(Status $status){
      return view('statuses.show',[
        'status' => new StatusResource($status)
      ]);
    }
}
