@extends('settings')

@section('settings-pane')

@if(!$admin_granted)
<form id='twofactor-form' method="POST" action="/settings/change/2fa">
  @csrf
  <input type='hidden' name='id' value='{{$id}}'>
  <p>Two factor authentication</p>

  <label class="switch">
    <input type="checkbox" name="twofactor_status" {{$twofactor_is_on?'checked':''}} >
    <span class="slider"></span>
  </label><br>
  
  <label for ='password'>Password</label>
  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
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
<form id='twofactor-form' method="POST" action="/sysadmin/settings/change/2fa">
  @csrf
  <input type='hidden' name='id' value='{{$targetUserID}}'>
  <p>Two factor authentication</p>

  <label class="switch">
    <input type="checkbox" name="twofactor_status" {{$twofactor_is_on?'checked':''}} >
    <span class="slider"></span>
  </label><br>

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

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
