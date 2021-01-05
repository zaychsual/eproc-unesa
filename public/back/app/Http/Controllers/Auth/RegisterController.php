<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Redirect;
use Uuid;
use Crypt;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

// EMAIL
use App\Mail\RegisterEmail;
use Illuminate\Support\Facades\Mail;

// RULE
use Illuminate\Validation\Rule;

// use statement untuk memanggil custom rules UsersExists
use App\Rules\UsersExists;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                new UsersExists(),
                // Rule::exists('users')->where(function ($query) {
                //     $query->where('is_active', null)
                //         ->orWhere('is_active', 0);
                // }),
            ],
            'id' => 'string',
            'role' => 'laman',
            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // return redirect($this->redirectTo)->with('message', 'Registered successfully, please login...!');
        return view('auth.register_info', compact('request'));
        // return $this->registered($request, $user)
        //     ?: redirect($this->redirectPath());
    }

    protected function create(array $data)
    {
        $user = User::where('email', '=', $data['email'])
            ->where(function ($query) {
                $query->where('is_active', null)
                    ->orWhere('is_active', 0);
            })->first();

        if (!empty($user)) {
            $uuid = $user['id'];
            // return Redirect::back()->withInfo(['msg', 'The Message']);
            // return User::select('email', 'id', 'role')->where('email', $data['email'])->get();
        } else {
            $uuid = Uuid::generate();

            User::create([
                // 'name' => $data['name'],
                'email' => $data['email'],
                // 'password' => Hash::make($data['password']),
                'id' => $uuid,
                'role' => 'laman',
            ]);
        }

        // $user_name = 'VMS UNESA';
        $objSend = new \stdClass();
        $objSend->email = $data['email'];
        $objSend->id = Crypt::encrypt($uuid);
        $to = $data['email'];
        Mail::to($to)->send(new RegisterEmail($objSend));
    }

    public function refreshCaptcha()
    {
        return captcha_img();
    }
}
