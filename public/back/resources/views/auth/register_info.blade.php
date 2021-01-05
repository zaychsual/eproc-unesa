@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <p>
                    Email telah kami kirimkan ke alamat <strong>{{$request->email}}</strong>. Langkah pendaftaran berikutnya terdapat pada email tersebut.
                    <br>
                    Kadang-kadang email tersebut masuk ke folder spam.
                    <br>
                    Terima kasih
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
