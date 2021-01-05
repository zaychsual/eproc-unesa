@extends('layouts.apps')

@section('content')
<div class="login-container lightmode">
    <div class="login-box animated fadeInDown">
        <div class="login-logo" style="height: 55px;"></div>
        <div class="login-body">
            <div class="login-title"><strong>Create</strong> an account</div>
                
                    <p>
                    Email aktivasi akan di kirim ke alamat <strong>{{$request->email}}</strong>. Silahkan cek email aktivasi yang telah dikirimkan pada inbox atau spam email Anda.
                    <br>
                    Terima kasih
                    </p>
                
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
</div>
            

@endsection
