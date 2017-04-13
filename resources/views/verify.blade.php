@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading text-center"><img src="https://cdn2.iconfinder.com/data/icons/metro-uinvert-dock/256/Security_Approved.png" width="20"/> Verify Two Factor Authentication</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/verify-2fa') }}">
                        {{ csrf_field() }}
                        {{-- <div class="alert alert-warning">Download the <strong>Google Authenticator</strong> App on your phone from the Play Store or the App Store.</div><br/> --}}
                        <div class="form-group{{ $errors->has('totp_token') ? ' has-error' : '' }}">
                            <label for="totp_token" class="col-md-4 control-label">Security Code</label>
                            <div class="col-md-6 pincode-input-container">
                                <input id="totp_token" autocomplete="off" type="text" class="form-control" name="totp_token" value="{{ old('totp_token') }}" autofocus>

                                @if ($errors->has('totp_token'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('totp_token') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection