<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Rekanans;
use App\Models\Webprofile\BentukUsahas;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use Hash;

use App\Repositories\ProvinsiRepository;
use App\Repositories\RekananRepository;

class AktivasiController extends Controller
{

    private $ProvinsiRepo;

    public function __construct(
        ProvinsiRepository $ProvinsiRepo,
        RekananRepository $RekananRepo
    ) {
        $this->ProvinsiRepo = $ProvinsiRepo;
        $this->RekananRepo = $RekananRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.rekanans.create')->withTitle('Tambah Kategori');
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
            'nama' => 'required',
            'password' => 'min:8|confirmed',
            // 'verifikasi_password' => 'required|min:8|confirmed',
        );
        $errormessage = array(
            'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
            'min' => 'Password minimal 8 karakter',
            // 'verifikasi_password.confirmed' => 'Password tidak sama',
        );

        $getMax = $this->RekananRepo->getMax();

        $data = $request->except(array('_token', 'email'));
        $reqUserId = Crypt::decrypt($data['reqUserId']);
        $validator = Validator::make($data, $rules, $errormessage);
        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('aktivasi.show', ['id' => $data['reqUserId']])
                ->withErrors($validator)
                ->withInput();
        } else {
            $uuid = Uuid::generate();
            $data['id'] = $uuid;
            $data['kode'] = $getMax;
            $data['mt_bentuk_usaha_id'] = $data['bentuk_usaha'];
            $data['mt_rekanan_id'] = $reqUserId;
            $data['userid_created'] = $reqUserId;
            $data['userid_updated'] = $reqUserId;

            $id = Rekanans::create($data)->id;
            $dataUser['mt_rekanan_id'] = $id;
            $dataUser['name'] = $data['nama'];
            $dataUser['password'] = Hash::make($data['password']);
            $dataUser['is_active'] = '1';
            User::updateOrCreate(
                ['id' => $reqUserId],
                $dataUser
            );

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Pendaftaran Rekanan Berhasil !!";
            return redirect()->route('ppti-login')->with('successMessage', $successmessage);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reqId = Crypt::decrypt($id);
        // $rekanan = Rekanans::where('id', Auth::user()->rekanan_id)->orderBy('nama', 'ASC')->get();
        // $rekanan = Rekanans::where('id', $id)->orderBy('nama', 'ASC')->get();
        // START CEK APAKAH SUDAH AKTIVASI
        $user = User::where('id', '=', $reqId)
            ->where(function ($query) {
                $query->where('is_active', 1);
            })->first();

        if (!empty($user)) {
            Alert::info('User Anda telah aktif, silahkan login dengan email dan password yang telah anda buat.')->persistent('Ok');
            return redirect()->route('ppti-login');
        }
        // END CHECK

        $email = User::where('id', $reqId)->select('email')->pluck('email')->first();
        $bentuk_usaha = BentukUsahas::pluck('name', 'id');

        $provinsi = $this->ProvinsiRepo->provinsi('noajax');

        $data = [
            // 'rekanan' => $rekanan,
            'bentuk_usaha' => $bentuk_usaha,
            'provinsi' => $provinsi,
            'email' => $email,
            'id' => $id,
        ];
        if (empty($email))
            return redirect()->route('register')->with('errorMessage', "User Anda telah dihapus oleh sistem kami.");
        else
            return view('webprofile.backend.rekanans.create', compact('data'))->withTitle('VMS: Proses Pengisian Formulir Registrasi Rekanan Baru');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // try {
        //     $data = Rekanans::find(Crypt::decrypt($id));
        //     return view('webprofile.backend.rekanans.edit', compact('data'))->withTitle('Ubah Kategori');
        // } catch (\Exception $id) {
        //     return redirect()->route('Aktivasi.index');
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Rekanans = Rekanans::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, Rekanans::$rules, Rekanans::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $Rekanans->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('rekanans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Rekanans::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('rekanans.index');
        } catch (\Exception $id) {
            return redirect()->route('rekanans.index');
        }
    }
}
