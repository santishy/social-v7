<div class="card border-0 bg-light shadow-sm">
    <img src="{{$user->avatar}}" class="card-img-top" alt="{{$user->name}}">
    <div class="card-body">
      @if(auth()->id() === $user->id )
        <h5 class="card-title">
          <a href="{{route('users.show',$user)}}">{{$user->name}}</a>
        </h5> 
        <span class="text-secondary">Eres tú</span>
      @else
        <h5 class="card-title">
          <a href="{{route('users.show',$user)}}">{{$user->name}}</a>
        </h5>
        <friendship-btn
            :recipient="{{$user}}"
           
            dusk="request-friendship" 
        >
        </friendship-btn>
      @endif
    </div>
</div>