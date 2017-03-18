@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Verify Two Factor Authentication</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/enable-2fa') }}">
                        {{ csrf_field() }}
                        {{-- <label for="email" class="col-md-4 control-label text-center">Secret Key</label> --}}
                        <div class="form-group text-center">
                        <p>Please scan this barcode using Google Authenticator or Authy client Application and Click <b>Enable Button</b></p>
                            <img src="{{ $barcode }}" />
                        </div>
                        <div class="form-group text-center">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-success">
                                    Enable Two Factor Authentication
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