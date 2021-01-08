@extends('layouts.apps')

@section('content')
<div class="login-container lightmode">
    <div class="login-box animated fadeInDown">
        <div class="login-logo" style="height: 55px;"></div>
        <div class="login-body">
            <div class="login-title"><strong>Create</strong> an account</div>
            @if(Session::has('message'))
            <div class="alert alert-success" style="float:none">
            {{ Session::get('message') }}
            {{Session::forget('message')}}
            </div>
            @endif
            <form method="POST" class="form-horizontal" action="{{ route('register') }}">
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
                    @if ($errors->has('role'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <strong>{{ $errors->first('role') }}</strong>
                    </div>
                    @endif
                    <select name="role" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="laman">Penyedia</option>
                        <option value="ppk">PPK</option>
                        <option value="pokja">Pokja</option>
                        <option value="pengendali_kualitas">Pengendali Kualitas</option>
                        <option value="pejabat_pengadaan">Pejabat Pengadaan</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
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
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <a href="{{ url('/') }}" class="btn btn-link btn-block">Back</a>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-info btn-block">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
            </form>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                &copy; 2020 simbajanesa.unesa.ac.id
            </div>
            <div class="pull-right">
                <a href="#">About</a> |
                <a href="#">Privacy</a> |
                <a href="#">Contact Us</a>
            </div>
        </div>
    </div>
    
</div>


<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert alert-success" style="float:none">
                    {{ Session::get('message') }}
                    {{Session::forget('message')}}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">{{ __('Captcha') }}</label>

                            <div class="col-md-6">
                                <div class="captcha">
                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-success btn-refresh"><div class="fa fa-refresh"></div></button>
                                </div>
                                <input id="captcha" type="captcha" class="form-control mt-2 {{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" required placeholder="Enter captcha">

                                @if ($errors->has('captcha'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection