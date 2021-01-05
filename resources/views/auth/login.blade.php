@extends('layouts.apps')

@section('content')
<div class="login-container">
        
    <div class="login-box animated fadeInDown">
        <div class="login-logo" style="height: 55px;"></div>
        <div class="login-body">
            <div class="login-title"><strong>Log In</strong> to your account</div>
            <breadcrumb style="color: white">Gunakan Akun VMS Anda untuk login di E-Proc!</breadcrumb>
            @if(Session::has('message'))
            <div class="alert alert-success" style="float:none">
            {{ Session::get('message') }}
            {{Session::forget('message')}}
            </div>
            @endif
            <form action="{{ route('eproc-login') }}" class="form-horizontal" method="post">
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
            <div class="form-group" >
                <div class="col-md-12">
                    @if ($errors->has('password'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                    @endif
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required placeholder="Password">   
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    @if ($errors->has('captcha'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <strong>{{ $errors->first('captcha') }}</strong>
                    </div>
                    @endif
                    <div class="captcha">
                        <span>{!! captcha_img() !!}</span>
                        <button type="button" class="btn btn-success btn-refresh"><div class="fa fa-refresh"></div></button>
                    </div>
                    <input id="captcha" type="captcha" class="form-control mt-2 {{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" required placeholder="Enter captcha">
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-6">
                    <a href="{{ url('/') }}" class="btn btn-link btn-block">Back</a>
                    <!-- <a href="{{ route('password.request') }}" class="btn btn-link btn-block">Forgot your password?</a> -->
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-info btn-block">Log In</button>
                </div>
            </div>
            </form>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                &copy; 2020 e-proc.unesa.ac.id
            </div>
            <div class="pull-right">
                <a href="#">About</a> |
                <a href="#">Privacy</a> |
                <a href="#">Contact Us</a>
            </div>
        </div>
    </div>
    
</div>








@endsection
