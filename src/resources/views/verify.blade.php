@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Verify Two Factor Authentication</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/verify-2fa') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('totp_token') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">TOTP Token</label>

                            <div class="col-md-6">
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
@endsection