<?php

namespace App\Http\Controllers\Sso;


use Illuminate\Http\Request;
use App\MasPeriodeModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use DB;
use Session;
use Validator;
use Input;
use Uuid;
use Crypt;
use Response;
use InseoHelper;
use Encryption;
use GuzzleHttp\Client as GuzzleHttpClient;
use App\User;
use Alert;

class AuthSSOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function index(Request $request, $email, $session_id)
    {   
        $setting = InseoHelper::setting();
        
        // Get Token
        try {
            $clientauthscsso = new GuzzleHttpClient();
            $apiRequestauthscsso = $clientauthscsso->request('GET', 'https://sso.unesa.ac.id/check-secret-token/'.$session_id);
            $cektoken = json_decode($apiRequestauthscsso->getBody()->getContents());
        } catch (\Exception $apiRequestauthscsso) {
            $error = 'Token Tidak Ditemukan';
            return $error;
        }

        // Check Validation Token
        try {
            $clientauthtknsso = new GuzzleHttpClient();
            $apiRequestauthtknsso = $clientauthtknsso->request('GET', 'https://sso.unesa.ac.id/check-token/'.$cektoken);
            $checkakses = json_decode($apiRequestauthtknsso->getBody()->getContents());
        } catch (\Exception $apiRequestauthtknsso) {
            $error = 'Token Tidak Valid';
            return $error;
        }

        // Get Account
        try {
            $clientbiodata = new GuzzleHttpClient();
            $apiRequestbiodata = $clientbiodata->request('GET', 'https://sso.unesa.ac.id/userid/'.$checkakses->email);
            $aksessso = json_decode($apiRequestbiodata->getBody()->getContents());
        } catch (\Exception $apiRequestbiodata) {
            $gagal_login = "Data Tidak Ditemukan";
            return $error;
        }

        return $this->checkUser($aksessso[0]->email, $aksessso);
    }

    private function checkUser($email, $aksessso)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            return $this->login($user);
        }

        return $this->addUser($aksessso);
    }

    private function login($user)
    {
        Auth::loginUsingId($user->id);

        return redirect()->intended('home');
    }

    private function addUser($aksessso)
    {
        $isdm = $this->isdm($aksessso);

        if (!$isdm) {
            Alert::error('Data Tidak ditemukan', 'Error');
            return redirect()->back();
        }

        $user['id'] = Uuid::generate();
        $user['name'] = $aksessso[0]->nama;
        $user['email'] = $aksessso[0]->email;
        $user['password'] = bcrypt($aksessso[0]->userid . 'r3p0s1t0ryK3y');

        if ($isdm[0]->isdosen == 1) {
            $user['role'] = 'dosen';
        } elseif ($isdm[0]->isdosen == 0) {
            $user['role'] = 'tendik';
        }

        $user['is_active'] = 1;

        User::create($user);

        return $this->checkUser($user['email'], $aksessso);
    }

    private function isdm($aksessso)
    {
        $client = new GuzzleHttpClient();
        $apiRequest = $client->request('GET', 'https://i-sdm.unesa.ac.id/biodataumum/' . $aksessso[0]->userid);
        $isdm = json_decode($apiRequest->getBody()->getContents());
        
        return $isdm;
    }

    // public function login() {
    //   header("Location: https://sso.unesa.ac.id/login");
    //   die();
    // }

}