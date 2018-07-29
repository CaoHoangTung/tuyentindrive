@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Settings</div>

                <div class='card-body'>

                  <div class='row'>
                    <div class='col-sm-6'>
                        @csrf

                        @if ($admin_granted)

                        <div class="form-group row">
                            <div class="col-md-6">
                              <a href='/sysadmin/settings/change/name/{{$targetUserID}}'>Change name</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <a href='/sysadmin/settings/change/password/{{$targetUserID}}'>Change password</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class='col-md-10'>
                                <a href='/sysadmin/settings/change/2fa/{{$targetUserID}}'>
                                  @if ($twofactor_is_on)
                                    Turn off Two Factor Authentication
                                  @else
                                    Turn on Two Factor Authentication
                                  @endif
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <a href='/sysadmin/settings/change/sysrole/{{$targetUserID}}'>Promote/Demote</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <a href='#'>Change role</a>
                            </div>
                        </div>
                        @else
                        <div class="form-group row">
                            <div class="col-md-6">
                              <a href='/settings/change/name'>Change name</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <a href='/settings/change/password'>Change password</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class='col-md-10'>
                                <a href='/settings/change/2fa'>
                                  @if ($twofactor_is_on)
                                    Turn off Two Factor Authentication
                                  @else
                                    Turn on Two Factor Authentication
                                  @endif
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class='col-sm-6'>
                      @yield('settings-pane')
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
