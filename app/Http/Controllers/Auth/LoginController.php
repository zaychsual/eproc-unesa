<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use InseoHelper;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\User;
use App\Models\Procurement\Logs;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Closure;
use Location;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected function authenticated(Request $request, $logs)
    {
        // Chrome, IE, Safari, Firefox, ...
        $agent = new Agent();
        $browser = $agent->browser();
        // Ubuntu, Windows, OS X, ...
        $platform = $agent->platform();


        DB::table('e_log')->insert([
        'mt_rekanan_id' => Auth::user()->mt_rekanan_id,
        'last_login' => date('Y-m-d H:i:s'),
        'ip_address' => $request->getClientIp(),
        'browser_login' => $agent->browser(),
        'browser_version' => $agent->version($browser),
        'device_login' => $agent->platform(),
        'device_version' => $agent->version($platform),
        //'language' =>  $agent->languages(),
        'root' => $agent->robot(),
        'https' => $request->server('HTTP_USER_AGENT'),
        'users_id' => Auth::user()->id,
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $setting = InseoHelper::setting();
        // dd($setting);
        return view('auth.login');
    }
}