@extends('settings')

@section('settings-pane')

@if(!$admin_granted)
<form method="POST" action = "/settings/change/password" id='changename-form'>
  @csrf
  <input type='hidden' name='id' value='{{$id}}'>

  <label for='old_password'>Old password:</label>
  <input type='password'  id='old_password' name='old_password' class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required>

  <label for='password'>New password:</label>
  <input type='password'  id='password' name='password' minlength="6" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required>

  <label for='cf_password'>Confirm new password:</label>
  <input type='password' id='cf_password' name='cf_password' minlength="6" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required>


      <p style='color:red'>
        @if (\Session::has('msg'))
          {!! \Session::get('msg') !!}
        @endif
      </p>

  <button type="submit" class="btn btn-primary">
      {{ __('Save change') }}
  </button>
</form>
@else

<form method="POST" action = "/sysadmin/settings/change/password" id='changename-form'>
  @csrf
  <input type='hidden' name='id' value='{{$id}}'>

  <label for='password'>New password:</label>
  <input type='password'  id='password' name='password' minlength="6" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required>

  <label for='cf_password'>Confirm new password:</label>
  <input type='password' id='cf_password' name='cf_password' minlength="6" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required>


      <p style='color:red'>
        @if (\Session::has('msg'))
          {!! \Session::get('msg') !!}
        @endif
      </p>

  <button type="submit" class="btn btn-primary">
      {{ __('Save change') }}
  </button>
</form>

@endif

@endsection
