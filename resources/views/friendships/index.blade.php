@extends('layouts.app')
@section('content')
  <div class="container">
    @foreach($friendshipsRequest as $friendshipRequest)
    <friendship-request-btn 
          :sender="{{$friendshipRequest->sender}}"
          friendship-status="{{$friendshipRequest->status}}">
    </friendship-request-btn>
  @endforeach
  </div>
   
@endsection
