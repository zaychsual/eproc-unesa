<?php

namespace App\Http\Controllers\Webprofile\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use View,DB;
use App\User;
use Uuid;
use Session;
use Alert;
use Auth;

class PpkController extends Controller
{
    const PPK = 'ppk';
    const Active = 1;
    const NotActive = 0;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name', 'DESC')
            ->where('role',Self::PPK) 
            ->where('is_active',Self::Active)
            ->get();

        return view('webprofile.backend.users.ppk.index', compact('users'))->withTitle('PPK');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listValidate()
    {
        $users = User::orderBy('name', 'DESC')
            ->where('role',Self::PPK) 
            ->where('is_active', Self::NotActive)
            ->where('is_validate',User::WaitingForValidate)
            ->get();

        return view('webprofile.backend.users.ppk.index-validate', compact('users'))->withTitle('PPK');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.users.ppk.create')->withTitle('Tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        );
        $errormessage = array(
            'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
            'min' => 'Password minimal 8 karakter',
            'password_confirmation.same' => 'Password tidak sama',
        );

        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('ppk.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $uuid = Uuid::generate();
            $file = $request->file('file_sertifikat');
            $ext = $file->getClientOriginalExtension();
            $newName = rand(100000,1001238912).".".$ext;
            $file->move('uploads/file',$newName);
            $data['id'] = $uuid;
            $data['password'] = bcrypt($request->input('password'));
            $data['is_active'] = Self::Active;
            $data['userid_created'] = Session::get('ss_nama');
            $data['userid_updated'] = Session::get('ss_nama');
            $data['prodi'] = Auth::user()->prodi;
            $data['role']  = Self::PPK;
            $data['file_sertifikat'] = $newName;

            User::create($data);

            Alert::success('Data berhasilk disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah User Berhasil !!";
            return redirect()->route('ppk.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail(\Crypt::decrypt($id));

        return view('webprofile.backend.users.ppk.show',\compact('user'))->withTitle('Show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('ppk.index')->with('successMessage', 'Berhasil menghapus user');
        } catch (\Exception $id) {
            return redirect()->route('ppk.index')->with('successMessage', 'Berhasil menghapus user');
        }
    }

    /**
     * store validate 
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response\Json
    */
    public function validatePpk(Request $request)
    {
        $message['is_error']   = true;
        $message['error_msg' ] = "";
        $message['success_msg'] = "";

        if( $request->id == "" ) {
            $message['is_error']   = true;
            $message['error_msg'] = "ID not found";
            return response()->json($message, 200);
        }

        if( $request->is_validate == User::ValidateYes ) {
            $user = User::find($request->id);
            $user->is_active = Self::Active;
            $user->is_validate = User::ValidateYes;

            $user->update();
            $message['is_error']   = false;
            $message['success_msg'] = "PPK telah berhasil divalidasi";
        } else {
            $user = User::find($request->id);
            $user->is_active = Self::NotActive;
            $user->is_validate = User::ValidateNo;

            $user->update();
            $message['is_error']   = false;
            $message['success_msg'] = "PPK telah berhasil dibatalkan";
        }

        return response()->json($message, 200);
    }
}
