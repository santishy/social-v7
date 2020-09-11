@extends('layouts.app')
@section('content')
    @foreach($friendshipsRequest->get() as $friendshipRequest)
      <friendship-request-btn 
            :sender="{{$friendshipRequest->sender}}"
            friendship-status="{{$friendshipRequest->status}}">
      </friendship-request-btn>
    @endforeach
@endsection
