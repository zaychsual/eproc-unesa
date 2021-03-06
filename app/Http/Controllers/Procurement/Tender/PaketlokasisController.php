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
use App\Repositories\JenisPengadaanRepository;

class RekanansController extends Controller
{

    private $ProvinsiRepo;

    public function __construct(
        ProvinsiRepository $ProvinsiRepo,
        KotaRepository $KotaRepo,
        RekananRepository $RekananRepo,
        JenisPengadaanRepository $JenisPengadaanRepo

    ) {
        $this->ProvinsiRepo = $ProvinsiRepo;
        $this->KotaRepo = $KotaRepo;
        $this->RekananRepo = $RekananRepo;
        $this->JenisPengadaanRepo = $JenisPengadaanRepo;
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
            // $rekanan = Rekanans::orderBy('nama', 'ASC')
            //     ->join('users', 'users.mt_rekanan_id', '=', 'mt_rekanan.id')->get();
            // $email = Auth::user()->email;
            $data = [
                'rekanan' => $rekanan,
            ];
            return view('webprofile.backend.admin.rekanans.index', compact('data'))->withTitle('Rekanan');
        } elseif (Auth::user()->role == 'laman') {

            $rekanan = Rekanans::where('mt_rekanan.id', Auth::user()->mt_rekanan_id)
                ->with(['rRekanan'])
                ->orderBy('kode', 'ASC')->get();
            // $email = Auth::user()->email;

            $data = [
                'rekanan' => $rekanan,
            ];

            return view('webprofile.backend.rekanans.index', compact('data'))->withTitle('Identitas Perusahaan');
        } else {
            $rekanan = DB::table('v_penyedia')->get();


            $data = [
                'rekanan' => $rekanan,
            ];

            return view('webprofile.backend.verifikasi.rekanans.index', compact('data'))->withTitle('Identitas Perusahaan');
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
            $jenis_pengadaan = JenisPengadaans::pluck('name', 'id');
            $provinsi = $this->ProvinsiRepo->provinsi('noajax');

            $data = [
                'bentuk_usaha' => $bentuk_usaha,
                'jenis_pengadaan' => $jenis_pengadaan,
                'provinsi' => $provinsi,
            ];

            return view('webprofile.backend.admin.rekanans.create', compact('data'))->withTitle('Tambah Pendaftaran Penyedia');
        } else {
            $jenispengadaans = JenisPengadaans::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');

            return view('webprofile.backend.rekanans.create', compact('jenispengadaans'))->withTitle('Tambah Identitias Perusahaan');
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
                $data['mt_jenis_pengadaan_id'] = $data['jenis_pengadaan'];
                $data['userid_created'] = $data['nama'];
                $data['userid_updated'] = $data['nama'];

                // $jenis_pengadaan = $request->input('jenis_pengadaan');
                // $jenis_pengadaan = implode(',', $jenis_pengadaan);

                // $data = $request->except('jenis_pengadaan');
                // $data['jenis_pengadaan'] = $jenis_pengadaan;

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
                // return redirect()->route('rekanans.create')->with('successMessage', $successmessage);
                // return Redirect::to('webprofile/rekanansedit/' . Crypt::encrypt($id));
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
                $data['mt_jenis_pengadaan_id'] = $data['jenis_pengadaan'];
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                // $jenis_pengadaan = $request->input('jenis_pengadaan');
                // $jenis_pengadaan = implode(',', $jenis_pengadaan);

                // $data = $request->except('jenis_pengadaan');
                // $data['jenis_pengadaan'] = $jenis_pengadaan;

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
        if (Auth::user()->role == 'admin') {
            // try {
            $reqId = Crypt::decrypt($id);
            $email = User::where('mt_rekanan_id', $reqId)->select('email')->pluck('email')->first();
            $rekanan = Rekanans::find($reqId);
            // $bentuk_usaha = BentukUsahas::pluck('name', 'id');
            $nama_bentuk_usaha = BentukUsahas::where('id', $rekanan->mt_bentuk_usaha_id)->select('name')->pluck('name')->first();
            $nama_jenis_pengadaan = JenisPengadaans::where('id', $rekanan->mt_jenis_pengadaan_id)->select('name')->pluck('name')->first();
            $jenispengadaans = JenisPengadaans::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
            $provinsi = $this->ProvinsiRepo->provinsi('noajax');
            $kota = $this->KotaRepo->kota($rekanan->provinsi_id, 'noajax');
            $nama_jenis_pengadaan = $this->JenisPengadaanRepo->jenis_pengadaan($rekanan->mt_jenis_pengadaan_id, 'noajax');
            // dd($kota);
            $data = [
                // 'rekanan' => $rekanan,
                // 'bentuk_usaha' => $bentuk_usaha,
                'provinsi' => $provinsi,
                'kota' => $kota,
                'rekanan' => $rekanan,
                'email' => $email,
                'nama_bentuk_usaha' => $nama_bentuk_usaha,
                'nama_jenis_pengadaan' => $nama_jenis_pengadaan,
                'jenispengadaans' => $jenispengadaans,
            ];
            return view('webprofile.backend.admin.rekanans.edit', compact('data'))->withTitle('Ubah Identitas Perusahaan');
            // } catch (\Exception $id) {
            // return redirect()->route('rekanans.index');
            // }
        } else {
            try {
                $reqId = Crypt::decrypt($id);
                $email = User::where('mt_rekanan_id', $reqId)->select('email')->pluck('email')->first();
                $rekanan = Rekanans::find($reqId);
                // $bentuk_usaha = BentukUsahas::pluck('name', 'id');
                $nama_bentuk_usaha = BentukUsahas::where('id', $rekanan['mt_bentuk_usaha_id'])->select('name')->pluck('name')->first();
                $nama_jenis_pengadaan = JenisPengadaans::where('id', $rekanan['mt_jenis_pengadaan_id'])->select('name')->pluck('name')->first();
                //dd($nama_jenis_pengadaan);
                $jenispengadaans = JenisPengadaans::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
                $provinsi = $this->ProvinsiRepo->provinsi('noajax');
                $kota = $this->KotaRepo->kota($rekanan['provinsi_id'], 'noajax');
                $data = [
                    // 'rekanan' => $rekanan,
                    // 'bentuk_usaha' => $bentuk_usaha,
                    'provinsi' => $provinsi,
                    'kota' => $kota,
                    'rekanan' => $rekanan,
                    'email' => $email,
                    'nama_bentuk_usaha' => $nama_bentuk_usaha,
                    'nama_jenis_pengadaan' => $nama_jenis_pengadaan,
                    'jenispengadaans' => $jenispengadaans,
                ];
                return view('webprofile.backend.rekanans.edit', compact('data'))->withTitle('Ubah Identitas Perusahaan');
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
        if (Auth::user()->role == 'admin') {
            $Rekanans = Rekanans::findOrFail($id);

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

            // $jenis_pengadaan = $request->input('jenis_pengadaan');
            // $jenis_pengadaan = implode(',', $jenis_pengadaan);

            // $data = $request->except('jenis_pengadaan');
            // $data['jenis_pengadaan'] = $jenis_pengadaan;

            $data['userid_updated'] = Auth::user()->name;
            $Rekanans->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');

            return redirect()->route('rekanans.edit', ['data' => Crypt::encrypt($id)]);
        } else {

            $Rekanans = Rekanans::findOrFail($id);

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

            // $jenis_pengadaan = $request->input('jenis_pengadaan');
            // $jenis_pengadaan = implode(',', $jenis_pengadaan);

            // $data = $request->except('jenis_pengadaan');
            // $data['jenis_pengadaan'] = $jenis_pengadaan;

            $data['userid_updated'] = Auth::user()->name;
            $Rekanans->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('rekanans.index');
        }
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
}
