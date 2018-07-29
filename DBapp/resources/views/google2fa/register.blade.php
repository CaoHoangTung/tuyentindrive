@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Set up Google Authenticator</div>

                <div class="card-body" style="text-align: center;">
                    <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                    <div>
                        <img src="{{ $QR_Image }}">
                    </div>
                    <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                    <div>
                      @if(!$admin_granted)
                      <form method='post' action='/settings/change/complete-enable-2fa'>
                        @csrf
                        <input name='id' type='hidden' value={{$targetUserID}}>
                        <input name='id' type='hidden' value={{$targetUserID}}>
                        <input name='qr' type='hidden' value='{{$QR_Image}}'>
                        <input name='secret' type='hidden' value='{{$secret}}'>
                        <input name='one-time-password' placeholder='Confirm' type='number'>
                        <button class="btn-primary">Confirm</button>
                      </form>
                      @else
                      <form method='post' action='/sysadmin/settings/change/complete-enable-2fa'>
                        @csrf
                        <input name='id' type='hidden' value={{$targetUserID}}>
                        <input name='qr' type='hidden' value='{{$QR_Image}}'>
                        <input name='secret' type='hidden' value='{{$secret}}'>
                        <input name='one-time-password' placeholder='Confirm' type='number'>
                        <button class="btn-primary">Confirm</button>
                      </form>
                      @endif
                      <p style='color:red'>{{$err}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
