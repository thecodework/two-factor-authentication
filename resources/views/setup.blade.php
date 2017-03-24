@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Verify Two Factor Authentication </div>
                <div class="panel-body">
                    @if($user->is_two_factor_enabled)
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/disable-2fa') }}">
                    @else
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/enable-2fa') }}">
                    @endif
                        {{ csrf_field() }}
                        {{-- <label for="email" class="col-md-4 control-label text-center">Secret Key</label> --}}
                        <div class="form-group text-center">
                        @if(! $user->is_two_factor_enabled)
                        <p>Please scan this barcode using Google Authenticator or Authy client Application and Click <b>Enable Button</b></p>
                            <img src="{{ $barcode }}" />
                        @endif
                        </div>
                        <div class="form-group text-center">
                            <div class="col-md-8 col-md-offset-2">
                            @if($user->is_two_factor_enabled)
                                <button type="submit" class="btn btn-danger">
                                    Disable Two Factor Authentication
                                </button>
                            @else
                                <button type="submit" class="btn btn-success">
                                    Enable Two Factor Authentication
                                </button>
                            @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection