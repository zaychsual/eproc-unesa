<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Rekanans;
use App\Models\Webprofile\BentukUsahas;
use App\Models\Webprofile\JenisPengadaans;
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
use App\Repositories\PpkRepository;

class AktivasiPokjaController extends Controller
{

    private $ProvinsiRepo;

    public function __construct(
        ProvinsiRepository $ProvinsiRepo,
        PpkRepository $PpkRepo
    ) {
        $this->ProvinsiRepo = $ProvinsiRepo;
        $this->PpkRepo = $PpkRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    { }

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
        );
        $errormessage = array(
            'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
            'min' => 'Password minimal 8 karakter',
        );

        $data = $request->except(array('_token', 'email'));
        $reqUserId = Crypt::decrypt($data['reqUserId']);
        $validator = Validator::make($data, $rules, $errormessage);
        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('aktivasi-pengendali-kualitas.show', ['id' => $data['reqUserId']])
                ->withErrors($validator)
                ->withInput();
        } else {
            $uuid       = strtoupper(Uuid::generate());
            $newName    = '';
            if( $request->has('file_sertifikats')) {
                $file = $request->file('file_sertifikats');
                // dd($file);
                $ext = $file->getClientOriginalExtension();
                $newName = rand(100000,1001238912).".".$ext;
                $file->move('uploads/file',$newName);
            }
            $dataUser['name']               = $data['nama'];
            $dataUser['nohp']               = $data['nohp'];
            $dataUser['nomor_sertifikat']   = $data['nomor_sertifikat'] ?? "";
            $dataUser['file_sertifikat']    = $newName;
            $dataUser['password']           = Hash::make($data['password']);
            $dataUser['is_active']          = User::NotActive;//waiiting validate admin
            User::updateOrCreate(
                ['id' => $reqUserId],
                $dataUser
            );

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Pendaftaran Pokja Berhasil (Menunggu persetujuan admin)!!";
            return redirect()->route('aktivasi-pokja.show', ['id' => $data['reqUserId']])->with('successMessage', $successmessage);
            // return redirect()->route('eproc-login')->with('successMessage', $successmessage);
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
                $query->where('is_active', User::Active);
            })->first();

        if (!empty($user)) {
            Alert::info('User Anda telah aktif, silahkan login dengan email dan password yang telah anda buat.')->persistent('Ok');
            return redirect()->route('eproc-login');
        }
        // END CHECK

        $email = User::where('id', $reqId)->select('email')->pluck('email')->first();
        $provinsi = $this->ProvinsiRepo->provinsi('noajax');

        $data = [
            'provinsi' => $provinsi,
            'email' => $email,
            'id' => $id,
        ];
        if (empty($email))
            return redirect()->route('register')->with('errorMessage', "User Anda telah dihapus oleh sistem kami.");
        else
            return view('webprofile.backend.aktivasi.create-pokja', compact('data'))->withTitle('VMS: Proses Pengisian Formulir Registrasi Pokja Baru');
    }
}
