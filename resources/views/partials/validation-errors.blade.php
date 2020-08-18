@if($errors->any())
  <div dusk="validation-errors" class="alert alert-danger">
    @foreach($errors as $error)
      {{ $error }}<br>
    @endforeach
  </div>
@endif
