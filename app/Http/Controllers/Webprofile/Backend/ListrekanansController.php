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
use Redirect;
use DB;
use Illuminate\Support\Facades\Hash;

use App\Repositories\ProvinsiRepository;
use App\Repositories\KotaRepository;
use App\Repositories\RekananRepository;

class ListrekanansController extends Controller
{

    private $ProvinsiRepo;

    public function __construct(
        ProvinsiRepository $ProvinsiRepo,
        KotaRepository $KotaRepo,
        RekananRepository $RekananRepo
    ) {
        $this->ProvinsiRepo = $ProvinsiRepo;
        $this->KotaRepo = $KotaRepo;
        $this->RekananRepo = $RekananRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::user()->role == 'admin') {

            $rekanan = Rekanans::with(['rRekanan'])
                ->orderBy('kode', 'ASC')->get();
            $data = [
                'rekanan' => $rekanan,
            ];
            return view('webprofile.backend.admin.rekanans.index', compact('data'))->withTitle('Rekanan');
        } else {
            $rekanan = DB::table('v_penyedia')
                        ->whereNull('is_active')
                        ->orwhere('is_active', '=', 0)
                        ->get();
            $data = [
                'rekanan' => $rekanan,
            ];
            return view('webprofile.backend.verifikasi.listrekanans.index', compact('data'))->withTitle('Daftar Penyedia Barang Jasa Baru');
        }
    }

    public function listrekanans_aktif()
    {
        if (Auth::user()->role == 'admin') {

            $rekanan = Rekanans::with(['rRekanan'])
                ->orderBy('kode', 'ASC')->get();
            $data = [
                'rekanan' => $rekanan,
            ];
            return view('webprofile.backend.admin.rekanans.index', compact('data'))->withTitle('Rekanan');
        } else {
            $rekanan = DB::table('v_penyedia')
                        ->where('is_active', '=', 1)
                        ->get();
            $data = [
                'rekanan' => $rekanan,
            ];
            return view('webprofile.backend.verifikasi.listrekanans.index_aktif', compact('data'))->withTitle('Daftar Penyedia');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role == 'admin') {
            $bentuk_usaha = BentukUsahas::pluck('name', 'id');
            $provinsi = $this->ProvinsiRepo->provinsi('noajax');

            $data = [
                'bentuk_usaha' => $bentuk_usaha,
                'provinsi' => $provinsi,
            ];
            return view('webprofile.backend.admin.rekanans.create', compact('data'))->withTitle('Tambah Pendaftaran Penyedia');
        } else {
            return view('webprofile.backend.rekanans.create')->withTitle('Tambah Identitias Perusahaan');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $rules = array(
                // 'name' => 'required',
                // 'password' => 'required|min:8',
                // 'verifikasi_password' => 'required|min:8|same:password',
            );
            $errormessage = array(
                // 'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
                // 'min' => 'Password minimal 8 karakter',
                // 'verifikasi_password.same' => 'Password tidak sama',
            );

            $getMax = $this->RekananRepo->getMax();

            $data = $request->except(array('_token'));
            $validator = Validator::make($data, $rules, $errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('rekanansadd')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();
                $data['id'] = $uuid;
                $data['kode'] = $getMax;
                $data['mt_bentuk_usaha_id'] = $data['bentuk_usaha'];
                $data['userid_created'] = $data['nama'];
                $data['userid_updated'] = $data['nama'];

                $id = Rekanans::create($data)->id;

                $uuidUser = Uuid::generate();
                $dataUser['id'] = $uuidUser;
                $dataUser['mt_rekanan_id'] = $id;
                $dataUser['name'] = $data['nama'];
                $dataUser['email'] = $data['email'];
                $dataUser['role'] = 'laman';
                $dataUser['password'] = Hash::make($data['password']);
                $dataUser['is_active'] = '1';
                User::create($dataUser);

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Pendaftaran Rekanan Berhasil !!";
                return redirect()->route('rekanans.edit', ['data' => Crypt::encrypt($id)]);
            }
        } else {
            $rules = array(
                'name' => 'required',
                'password' => 'required|min:8',
                'verifikasi_password' => 'required|min:8|same:password',
            );
            $errormessage = array(
                'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
                'min' => 'Password minimal 8 karakter',
                'verifikasi_password.same' => 'Password tidak sama',
            );

            $getMax = $this->RekananRepo->getMax();

            $data = $request->except(array('_token', 'email', 'password'));
            $validator = Validator::make($data, $rules, $errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('rekanans.index')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();
                $data['id'] = $uuid;
                $data['kode'] = $getMax;
                $data['mt_bentuk_usaha_id'] = $data['bentuk_usaha'];
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                $id = Rekanans::create($data)->id;

                $dataUser['mt_rekanan_id'] = $id;
                $dataUser['password'] = Hash::make($data['password']);
                User::updateOrCreate(
                    ['id' => Auth::user()->id],
                    $dataUser
                );

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Pendaftaran Rekanan Berhasil !!";
                return redirect()->route('rekanans.create')->with('successMessage', $successmessage);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Rekanans $Rekanans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role == 'verifikator') {
            // try {
                $reqId = Crypt::decrypt($id);
                $email = User::where('mt_rekanan_id', $reqId)->select('email')->pluck('email')->first();
                $listrekanan = Rekanans::find($reqId);
                $nama_bentuk_usaha = BentukUsahas::where('id', $listrekanan->mt_bentuk_usaha_id)->select('name')->pluck('name')->first();
                $nama_jenis_pengadaan = JenisPengadaans::where('id', $listrekanan->mt_jenis_pengadaan_id)->select('name')->pluck('name')->first();
                $jenispengadaans = JenisPengadaans::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
                $provinsi = $this->ProvinsiRepo->provinsi('noajax');
                $kota = $this->KotaRepo->kota($listrekanan->provinsi_id, 'noajax');
                $data = [
                    // 'rekanan' => $rekanan,
                    // 'bentuk_usaha' => $bentuk_usaha,
                    'provinsi' => $provinsi,
                    'kota' => $kota,
                    'rekanan' => $listrekanan,
                    'email' => $email,
                    'nama_bentuk_usaha' => $nama_bentuk_usaha,
                    'jenispengadaans' => $jenispengadaans,
                ];
                return view('webprofile.backend.verifikasi.listrekanans.edit', compact('data'))->withTitle('Ubah Identitas Perusahaan');
            // } 
            // catch (\Exception $id) {
            //     return redirect()->route('rekanans.index');
            // }
        } else {
            try {
                $reqId = Crypt::decrypt($id);
                $email = User::where('mt_rekanan_id', $reqId)->select('email')->pluck('email')->first();
                $rekanan = Rekanans::find($reqId);
                $nama_bentuk_usaha = BentukUsahas::where('id', $rekanan['mt_bentuk_usaha_id'])->select('name')->pluck('name')->first();
                $provinsi = $this->ProvinsiRepo->provinsi('noajax');
                $kota = $this->KotaRepo->kota($rekanan['provinsi_id'], 'noajax');
                $data = [
                    'provinsi' => $provinsi,
                    'kota' => $kota,
                    'rekanan' => $rekanan,
                    'email' => $email,
                    'nama_bentuk_usaha' => $nama_bentuk_usaha,
                ];
                return view('webprofile.backend.listrekanans.edit', compact('data'))->withTitle('Ubah Identitas Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('rekanans.index');
            }
        }
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
        $rekanans = Rekanans::findOrFail($id);

        $rules = array();
        $errormessage = array(
            'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
            'min' => 'Password minimal 8 karakter',
            'verifikasi_password.same' => 'Password tidak sama',
        );

        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // $data['userid_updated'] = Auth::user()->name;
        // 
        $data['ip'] = \Request::ip();
        $data['userid_verifikasi'] = Auth::user()->name;
        $data['tgl_verifikasi'] = date('Y-m-d H:i:s');
        $data['is_active'] = '1';
        $data['is_syarat'] = $request->input('is_syarat');
        $data['is_npwp'] = $request->input('is_npwp');
        $data['is_ket'] = $request->input('is_ket');

        $rekanans->update($data);

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('listrekanans.index');
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

    public function rekanan_edit($id)
    {
        if (Auth::user()->role == 'admin') {
            $data = [
                'id' => $id,
            ];
            return view('webprofile.backend.admin.rekanans.add', compact('data'))->withTitle('Rekanan');
        }
    }

    public function listrekanans_naktif($id)
    {
        Rekanans::where('id', Crypt::decrypt($id))->update([
          'is_active' => null,
          
        ]);

        return redirect()->route('listrekanans_aktif');
    }
}
