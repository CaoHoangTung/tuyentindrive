@extends('settings')

@section('settings-pane')

@if($admin_granted)

<form method="POST" action = "{{route('change_sys_role')}}" id='changename-form'>
  @csrf
  <input type='hidden' name='id' value='{{$id}}'>

  <select id="sysRole" class="form-control" name="sysRole">
    @foreach ($sysRoles as $key => $value)
      <option value='{{$value->id}}' @if($userSysRole==$value->id) selected @endif>{{$value->name}}</option>
    @endforeach
  </select>


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
