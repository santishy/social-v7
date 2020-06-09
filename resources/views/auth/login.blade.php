@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card border-0 px-4 py-2">
          <div class="card-body">
            <form  action="{{route('login')}}" method="post">
              @csrf
              <div class="form-group">
                <label for="">Email:</label>
                <input class="form-control border-0" placeholder="tu email" type="text" name="email" value="">
              </div>
              <div class="form-group">
                <label for="">Contraseña:</label>
                <input class="form-control border-0" type="password" placeholder="tu contraseña" name="password" value="">
              </div>

              <button id="login-btn" class="btn btn-primary btn-block" name="button">Login</button>
            </form>
          </div>

        </div>
@endsection
