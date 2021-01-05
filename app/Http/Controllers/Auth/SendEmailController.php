<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Mail\RegisterEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index()
    {


        $user_name = 'Name';
        $to = 'novanbagus@gmail.com';
        Mail::to($to)->send(new RegisterEmail($user_name));
        return 'Mail sent successfully';

        // Mail::to("novanbagus@gmail.com")->send(new RegisterEmail());

        // return "Email telah dikirim";
    }
}
