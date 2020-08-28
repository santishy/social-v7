@extends('layouts.app')
@section('content')
    @foreach($friendshipsRequest->get() as $friendshipRequest)
      {{$friendshipRequest->sender->name}}
      <friendship-request-btn :sender="{{$friendshipRequest->sender}}"
                              friendship-status="{{$friendshipRequest->status}}"
                              dusk="accept-friendship"
      >
      </friendship-request-btn>
    @endforeach
@endsection
