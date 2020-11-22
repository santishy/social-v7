    @extends('layouts.app')
    @section('content')
    @forelse ($friends as $friend)
     <p>{{$friend->name}}</p>
    @empty
        No tienes amigos
    @endforelse
    @endsection