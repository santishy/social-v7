@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="card border-0 bg-light shadow-sm">
          <img src="{{$user->avatar}}" class="card-img-top" alt="{{$user->name}}">
          <div class="card-body">
            @if(auth()->id() === $user->id )
              <h5 class="card-title">{{$user->name}}</h5> <span class="text-secondary">Eres tú</span>
            @else
              <h5 class="card-title">{{$user->name}}</h5>
              <friendship-btn
                  :recipient="{{$user}}"
                  friendship-status="{{$friendshipStatus}}"
                  dusk="request-friendship" 
              >
              </friendship-btn>
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <status-list url="{{route('users.statuses.index',$user)}}"></status-list>
      </div>
    </div>
  </div>
@endsection
