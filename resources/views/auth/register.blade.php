@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        @if($errors->any())
          <div dusk="validation-errors">
            @foreach($errors as $error)
              {{ $error }}

            @endforeach
          </div>
        @endif
        <div class="card border-0 px-4 py-2">
          <div class="card-body">
            <form  action="{{route('register')}}" method="post">
              @csrf
            <div class="form-group">
              <label for="">Username:</label>
              <input class="form-control border-0" placeholder="tu nombre de usuario..." type="text" name="name">
            </div>
            <div class="form-group">
              <label for="">Nombre:</label>
              <input class="form-control border-0" placeholder="tu primer nombre..." type="text" name="first_name">
            </div>
            <div class="form-group">
              <label for="">Apellido:</label>
              <input class="form-control border-0" placeholder="tu apellido..." type="text" name="last_name">
            </div>
            <div class="form-group">
              <label for="">Email:</label>
              <input class="form-control border-0" placeholder="tu email..." type="email" name="email">
            </div>
            <div class="form-group">
              <label for="">Contraseña:</label>
              <input class="form-control border-0" placeholder="tu password..." type="password" name="password">
            </div>
            <div class="form-group">
              <label for="">Repite la contraseña:</label>
              <input class="form-control border-0" placeholder="repite la contraseña..." type="password" name="password_confirmation">
            </div>
            <button dusk="register-btn" class="btn btn-primary btn-block" name="button">Registro</button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
