@extends('layouts.apps')

@section('content')
<div class="login-container lightmode">
    <div class="login-box animated fadeInDown">
        <div class="login-logo" style="height: 55px;"></div>
        <div class="login-body">
            <div style="padding:10px 10px 0px 10px">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            <div class="login-title"><strong>{{ __('Reset Password') }}</strong></div>

                
                
                    <form method="POST" class="form-horizontal" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group" >
                            <div class="col-md-12">
                                @if ($errors->has('email'))
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                                @endif
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="E-mail">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <a href="{{ url('/') }}" class="btn btn-link btn-block">Back</a>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
