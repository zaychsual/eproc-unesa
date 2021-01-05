<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Http\Controllers\Controller;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Validator;
use View;
use App\User;
use Uuid;
use Session;
use Alert;
use Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'admin') {
            $users = User::orderBy('name', 'DESC')->get();
            return view('webprofile.backend.users.index', compact('users'))->withTitle('User');
        } 
        else {
            $users = User::orderBy('name', 'DESC')
                ->where('id', '=', Auth::user()->id)
                ->get();
            return view('webprofile.backend.penggunas.index', compact('users'))->withTitle('User');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.users.create')->withTitle('Tambah');
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
            return redirect()->route('user.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $uuid = Uuid::generate();

            $data['id'] = $uuid;
            $data['password'] = bcrypt($request->input('password'));
            $data['is_active'] = 1;
            $data['userid_created'] = Session::get('ss_nama');
            $data['userid_updated'] = Session::get('ss_nama');
            $data['prodi'] = Auth::user()->prodi;

            User::create($data);

            Alert::success('Data berhasilk disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah User Berhasil !!";
            return redirect()->route('user.index')->with('successMessage', $successmessage);
        }
    }

    public function user_aktif($id)
    {
        User::where('id', Crypt::decrypt($id))->update([
            'is_active' => '1',
            'userid_created' => Session::get('ss_nama'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('user.index');
    }

    public function user_naktif($id)
    {
        User::where('id', Crypt::decrypt($id))->update([
            'is_active' => '0',
            'userid_created' => Session::get('ss_nama'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == 'admin') {
            $user = DB::table('users')->find(Crypt::decrypt($id));
            return view('webprofile.backend.users.edit', compact('user'))->withTitle('Ubah User');

        } else {
            $user = DB::table('users')->where('id', '=', Auth::user()->id)->find(Crypt::decrypt($id));
            return view('webprofile.backend.penggunas.edit', compact('user'))->withTitle('Ubah User');

        }
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
        if (Auth::user()->role == 'admin') {
            $user = DB::table('users')->where('id', $id)->first();
            $rules = array(
                'name' => 'required',
                'email' => 'required',
                // 'password' => 'required|min:8',
                'password_confirmation' => 'same:password',
            );
            $errormessage = array(
                'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisid',
                // 'min' => 'Password minimal 8 karakter',
                'password_confirmation.same' => 'Password tidak sama',
            );
        }else{
            $user = DB::table('users')
                ->where('id', '=', Auth::user()->id)
                ->where('id', $id)->first();
            $rules = array(
                // 'name' => 'required',
                // 'email' => 'required',
                //'password' => 'min:8',
                'password_confirmation' => 'same:password',
            );
            $errormessage = array(
                'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisid',
                //'min' => 'Password minimal 8 karakter',
                'password_confirmation.same' => 'Password tidak sama',
            );
        }
        

        $validator = Validator::make($request->all(), $rules, $errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->input('password') != null || $request->input('password') != '') {
                if (Auth::user()->role == 'admin') {
                    DB::table('users')->where('id', $id)->update([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'role' => $request->input('role'),
                        'password' => bcrypt($request->input('password')),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }else{
                    DB::table('users')
                        ->where('id', '=', Auth::user()->id)
                        ->where('id', $id)->update([
                        
                        'password' => bcrypt($request->input('password')),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
                
            } else {
                if (Auth::user()->role == 'admin') {
                    DB::table('users')->where('id', $id)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'role' => $request->input('role'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                }else{
                    DB::table('users')
                    ->where('id', '=', Auth::user()->id)
                    ->where('id', $id)->update([
                    
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                }
                
            }

            return redirect()->route('user.index')->with('successMessage', 'Berhasil mengubah user');
        }
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

            return redirect()->route('user.index')->with('successMessage', 'Berhasil menghapus user');
        } catch (\Exception $id) {
            return redirect()->route('user.index')->with('successMessage', 'Berhasil menghapus user');
        }
    }
}
