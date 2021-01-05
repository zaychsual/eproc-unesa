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
use App\Models\Webprofile\Rekanans; 
use App\Models\Webprofile\JenisPengadaans;

class PokjaController extends Controller
{
    const Pokja = 'pokja';
    const Active = 1;
    const NotActive = 0;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')
            ->where('role',Self::Pokja) 
            ->where('is_active',Self::Active)
            ->get();

        return view('webprofile.backend.users.pokja.index', compact('users'))->withTitle('Pokja');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listValidate()
    {
        $users = User::orderBy('created_at', 'DESC')
            ->where('role',Self::Pokja) 
            ->where('is_validate', User::WaitingForValidate)
            ->where('is_active',Self::NotActive )
            ->get();

        return view('webprofile.backend.users.pokja.index-validate', compact('users'))->withTitle('Pokja');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listValidateKaUkpbj()
    {
        $users = User::orderBy('created_at', 'DESC')
            ->where('role',Self::Pokja) 
            ->where('is_validate_ukpbj', User::WaitingValidateUkpbj)
            ->where('is_active',Self::NotActive )
            ->get();
            

        return view('procurement.tender.pokja.validate', compact('users'))->withTitle('Pokja');
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
        return view('webprofile.backend.users.pokja.show',\compact('user'))->withTitle('Show');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showValidatePokja($id)
    {
        $user = User::findOrFail(\Crypt::decrypt($id));
        $rekanans = Rekanans::all()->pluck('nama','id');
        $jenis_pengadaan = JenisPengadaans::pluck('name', 'id');

        return view('procurement.tender.pokja.show-validate',\compact(
            'user',
            'rekanans',
            'jenis_pengadaan')
            )->withTitle('Show');
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
    public function adminValidatePokja(Request $request)
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
            $user->is_validate = User::ValidateYes;
            $user->is_validate_ukpbj = User::WaitingValidateUkpbj;

            $user->update();
            $message['is_error']   = false;
            $message['success_msg'] = "Pokja telah berhasil divalidasi";
        } else {
            $user = User::find($request->id);
            $user->is_active = Self::NotActive;
            $user->is_validate = User::ValidateNo;

            $user->update();
            $message['is_error']   = false;
            $message['success_msg'] = "Pokja telah berhasil dibatalkan";
        }

        return response()->json($message, 200);
    }

    /**
     * store validate 
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response\Json
    */
    public function kepalaValidatePokja(Request $request)
    {
        $message['is_error']   = true;
        $message['error_msg' ] = "";
        $message['success_msg'] = "";

        //check if null value
        if( $request->id == "" ) {
            $message['is_error']   = true;
            $message['error_msg'] = "ID not found";
            return response()->json($message, 200);
        }
        
        if( $request->id_jenis_pengadaan == "" ) {
            $message['is_error']   = true;
            $message['error_msg'] = "Please select jenis pengadaan";
            return response()->json($message, 200);
        }
        //end check


        if( $request->is_validate == User::ValidateYes ) {
            $user = User::find($request->id);
            $user->is_active    = Self::Active;
            $user->is_validate  = User::ValidateYes;
            $user->is_validate_ukpbj = User::ValidateUkpbj;
            $user->id_jenis_pengadaan    = $request->id_jenis_pengadaan;

            $user->update();
            $message['is_error']   = false;
            $message['success_msg'] = "Pokja telah berhasil divalidasi";
        } else {
            $user = User::find($request->id);
            $user->is_active    = Self::NotActive;
            $user->is_validate_ukpbj = User::RejectedUkpbj;
            $user->is_validate  = User::ValidateNo;

            $user->update();
            $message['is_error']   = false;
            $message['success_msg'] = "Pokja telah berhasil dibatalkan";
        }

        return response()->json($message, 200);
    }
}
