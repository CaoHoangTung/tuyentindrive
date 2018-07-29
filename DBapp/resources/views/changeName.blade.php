@extends('settings')

@section('settings-pane')

@if (!$admin_granted)
<form method="POST" action = "/settings/change/name" id='changename-form'>
  @csrf
  <input name='id' value={{$id}} type='hidden'>

  <label for='name'>Your name:</label>
  <input id='name' name='name' class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  value='{{$name}}' required autofocus>

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
<form method="POST" action = "/sysadmin/settings/change/name" id='changename-form'>
  @csrf
  <input name='id' value={{$id}} type='hidden'>

  <label for='name'>Name:</label>
  <input id='name' name='name' class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  value='{{$name}}' required autofocus>

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
