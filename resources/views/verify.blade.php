@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading text-center">Verify Two Factor Authentication</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/verify-2fa') }}">
                        {{ csrf_field() }}
                        <div class="alert alert-warning text-center">Download the <strong>Google Authenticator</strong> App on your phone from the Play Store or the App Store.</div><br/>
                        <div class="form-group{{ $errors->has('totp_token') ? ' has-error' : '' }}">
                            <label for="totp_token" class="col-md-4 control-label">TOTP Token</label>
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
                                <button type="submit" class="btn btn-primary">
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
<script type="text/javascript" src="{{asset('js/two-factor-authentication.js')}}"></script>
{{-- <style>
    .pincode-input-container {
    display:inline-block;
}
.pincode-input-container input.first {
    border-top-right-radius:0px;
    border-bottom-right-radius:0px;
}
.pincode-input-container input.last {
    border-top-left-radius:0px;
    border-bottom-left-radius:0px;
    border-left-width:0px;
}
.pincode-input-container input.mid {
    border-radius:0px;
    border-left-width:0px;
}
.pincode-input-text, .form-control.pincode-input-text {
    width:35px;
    float:left;
}
.pincode-input-error{
    clear:both;
}
</style> --}}
@endsection