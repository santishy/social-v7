    @extends('layouts.app')
    @section('content')
    <div class="container">
        <div class="row">
            @forelse ($friends as $friend)
              
                    <div class="col-md-3">
                        @include('partials.user',['user' => $friend])
                    </div>
        
            @empty
                <div class="col-md-12">
                    No tienes amigos
                </div>
             
            @endforelse
    </div>
    
</div>
        
    @endsection