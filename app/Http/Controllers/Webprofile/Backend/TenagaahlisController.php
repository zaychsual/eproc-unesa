<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Tenagaahlis;
use App\Models\Webprofile\TenagaAhliPengalamans;
use App\Models\Webprofile\TenagaAhliPendidikans;
use App\Models\Webprofile\TenagaAhliSertifikats;
use App\Models\Webprofile\TenagaAhliBahasas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class TenagaahlisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $data = TenagaAhlis::where('mt_rekanan_id', Crypt::decrypt(session('mt_rekanan_id')))->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.admin.tenagaahlis.index', compact('data'))->withTitle('Tenaga Ahli Perusahaan');
        } else {
            $data = TenagaAhlis::where('mt_rekanan_id', Auth::user()->mt_rekanan_id)->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.tenagaahlis.index', compact('data'))->withTitle('Tenaga Ahli Perusahaan');
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
            return view('webprofile.backend.admin.tenagaahlis.create')->withTitle('Tambah Tenaga Ahli Perusahaan');
        } else {
            return view('webprofile.backend.tenagaahlis.create')->withTitle('Tambah Tenaga Ahli Perusahaan');
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
            $data = $request->except('_token');
            $validator = Validator::make($data, TenagaAhlis::$rules, TenagaAhlis::$errormessage);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
                // $errormessage = $validator->messages();
                // return redirect()->route('tenagaahlis.create')
                //     ->withErrors($validator)
                //     ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Crypt::decrypt(session('mt_rekanan_id'));
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                $id = TenagaAhlis::create($data)->id;

                $pengalaman_tahun = $data['pengalaman_tahun'];
                $pengalaman_uraian = $data['pengalaman_uraian'];
                for ($i = 0; $i < count($pengalaman_tahun); $i++) {
                    if ($pengalaman_tahun[$i] == "") { } else {
                        $uuidPengalaman = Uuid::generate();
                        $dataPengalaman['id'] = $uuidPengalaman;
                        $dataPengalaman['mt_tenaga_ahli_id'] = $id;
                        $dataPengalaman['tahun'] = $pengalaman_tahun[$i];
                        $dataPengalaman['uraian'] = $pengalaman_uraian[$i];
                        $dataPengalaman['userid_created'] = Auth::user()->name;
                        TenagaAhliPengalamans::create($dataPengalaman);
                    }
                }

                $pendidikan_tahun = $data['pendidikan_tahun'];
                $pendidikan_uraian = $data['pendidikan_uraian'];
                for ($i = 0; $i < count($pendidikan_tahun); $i++) {
                    if ($pendidikan_tahun[$i] == "") { } else {
                        $uuidPendidikan = Uuid::generate();
                        $dataPendidikan['id'] = $uuidPendidikan;
                        $dataPendidikan['mt_tenaga_ahli_id'] = $id;
                        $dataPendidikan['tahun'] = $pendidikan_tahun[$i];
                        $dataPendidikan['uraian'] = $pendidikan_uraian[$i];
                        $dataPendidikan['userid_created'] = Auth::user()->name;
                        TenagaAhliPendidikans::create($dataPendidikan);
                    }
                }

                $sertifikat_tahun = $data['sertifikat_tahun'];
                $sertifikat_uraian = $data['sertifikat_uraian'];
                for ($i = 0; $i < count($sertifikat_tahun); $i++) {
                    if ($sertifikat_tahun[$i] == "") { } else {
                        $uuidSertifikat = Uuid::generate();
                        $dataSertifikat['id'] = $uuidSertifikat;
                        $dataSertifikat['mt_tenaga_ahli_id'] = $id;
                        $dataSertifikat['tahun'] = $sertifikat_tahun[$i];
                        $dataSertifikat['uraian'] = $sertifikat_uraian[$i];
                        $dataSertifikat['userid_created'] = Auth::user()->name;
                        TenagaAhliSertifikats::create($dataSertifikat);
                    }
                }

                $bahasa_uraian = $data['bahasa_uraian'];
                for ($i = 0; $i < count($bahasa_uraian); $i++) {
                    if ($bahasa_uraian[$i] == "") { } else {
                        $uuidBahasa = Uuid::generate();
                        $dataBahasa['id'] = $uuidBahasa;
                        $dataBahasa['mt_tenaga_ahli_id'] = $id;
                        $dataBahasa['uraian'] = $bahasa_uraian[$i];
                        $dataBahasa['userid_created'] = Auth::user()->name;
                        TenagaAhliBahasas::create($dataBahasa);
                    }
                }

                // Alert::success('Data berhasil disimpan')->persistent('Ok');

                // $successmessage = "Proses Tambah Tenaga Ahli Perusahaan Berhasil !!";
                // return redirect()->route('tenagaahlis.index')->with('successMessage', $successmessage);
                return response()->json(['success' => 'Data berhasil disimpan.']);
            }
        } else {
            $data = $request->except('_token');
            $validator = Validator::make($data, TenagaAhlis::$rules, TenagaAhlis::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('tenagaahlis.create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                $id = TenagaAhlis::create($data)->id;

                $pengalaman_tahun = $data['pengalaman_tahun'];
                $pengalaman_uraian = $data['pengalaman_uraian'];
                for ($i = 0; $i < count($pengalaman_tahun); $i++) {
                    if ($pengalaman_tahun[$i] == "") { } else {
                        $uuidPengalaman = Uuid::generate();
                        $dataPengalaman['id'] = $uuidPengalaman;
                        $dataPengalaman['mt_tenaga_ahli_id'] = $id;
                        $dataPengalaman['tahun'] = $pengalaman_tahun[$i];
                        $dataPengalaman['uraian'] = $pengalaman_uraian[$i];
                        $dataPengalaman['userid_created'] = Auth::user()->name;
                        TenagaAhliPengalamans::create($dataPengalaman);
                    }
                }

                $pendidikan_tahun = $data['pendidikan_tahun'];
                $pendidikan_uraian = $data['pendidikan_uraian'];
                for ($i = 0; $i < count($pendidikan_tahun); $i++) {
                    if ($pendidikan_tahun[$i] == "") { } else {
                        $uuidPendidikan = Uuid::generate();
                        $dataPendidikan['id'] = $uuidPendidikan;
                        $dataPendidikan['mt_tenaga_ahli_id'] = $id;
                        $dataPendidikan['tahun'] = $pendidikan_tahun[$i];
                        $dataPendidikan['uraian'] = $pendidikan_uraian[$i];
                        $dataPendidikan['userid_created'] = Auth::user()->name;
                        TenagaAhliPendidikans::create($dataPendidikan);
                    }
                }

                $sertifikat_tahun = $data['sertifikat_tahun'];
                $sertifikat_uraian = $data['sertifikat_uraian'];
                for ($i = 0; $i < count($sertifikat_tahun); $i++) {
                    if ($sertifikat_tahun[$i] == "") { } else {
                        $uuidSertifikat = Uuid::generate();
                        $dataSertifikat['id'] = $uuidSertifikat;
                        $dataSertifikat['mt_tenaga_ahli_id'] = $id;
                        $dataSertifikat['tahun'] = $sertifikat_tahun[$i];
                        $dataSertifikat['uraian'] = $sertifikat_uraian[$i];
                        $dataSertifikat['userid_created'] = Auth::user()->name;
                        TenagaAhliSertifikats::create($dataSertifikat);
                    }
                }

                $bahasa_uraian = $data['bahasa_uraian'];
                for ($i = 0; $i < count($bahasa_uraian); $i++) {
                    if ($bahasa_uraian[$i] == "") { } else {
                        $uuidBahasa = Uuid::generate();
                        $dataBahasa['id'] = $uuidBahasa;
                        $dataBahasa['mt_tenaga_ahli_id'] = $id;
                        $dataBahasa['uraian'] = $bahasa_uraian[$i];
                        $dataBahasa['userid_created'] = Auth::user()->name;
                        TenagaAhliBahasas::create($dataBahasa);
                    }
                }

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Tambah Tenaga Ahli Perusahaan Berhasil !!";
                return redirect()->route('tenagaahlis.index')->with('successMessage', $successmessage);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Tenagaahlis $tenagaahlis)
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
            try {
                $data = TenagaAhlis::find(Crypt::decrypt($id));
                $pengalaman = TenagaAhliPengalamans::where('mt_tenaga_ahli_id', Crypt::decrypt($id))->get();
                $pendidikan = TenagaAhliPendidikans::where('mt_tenaga_ahli_id', Crypt::decrypt($id))->get();
                $sertifikat = TenagaAhliSertifikats::where('mt_tenaga_ahli_id', Crypt::decrypt($id))->get();
                $bahasa = tenagaAhliBahasas::where('mt_tenaga_ahli_id', Crypt::decrypt($id))->get();

                $row = [
                    'data' => $data,
                    'pengalaman' => $pengalaman,
                    'pendidikan' => $pendidikan,
                    'sertifikat' => $sertifikat,
                    'bahasa' => $bahasa,
                ];
                return view('webprofile.backend.admin.tenagaahlis.edit', compact('row'))->withTitle('Ubah Tenaga Ahli Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('tenagaahlis.index');
            }
        } else {
            try {
                $data = TenagaAhlis::find(Crypt::decrypt($id));
                $pengalaman = TenagaAhliPengalamans::where('mt_tenaga_ahli_id', Crypt::decrypt($id))->get();
                $pendidikan = TenagaAhliPendidikans::where('mt_tenaga_ahli_id', Crypt::decrypt($id))->get();
                $sertifikat = TenagaAhliSertifikats::where('mt_tenaga_ahli_id', Crypt::decrypt($id))->get();
                $bahasa = tenagaAhliBahasas::where('mt_tenaga_ahli_id', Crypt::decrypt($id))->get();

                $row = [
                    'data' => $data,
                    'pengalaman' => $pengalaman,
                    'pendidikan' => $pendidikan,
                    'sertifikat' => $sertifikat,
                    'bahasa' => $bahasa,
                ];
                return view('webprofile.backend.tenagaahlis.edit', compact('row'))->withTitle('Ubah Tenaga Ahli Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('tenagaahlis.index');
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
            $tenagaahlis = TenagaAhlis::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, TenagaAhlis::$rules, TenagaAhlis::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $tenagaahlis->update($data);

            // METODE MENGGUNAKAN DELETE INSERT
            $tenaga_ahli_pengalaman = TenagaAhliPengalamans::where('mt_tenaga_ahli_id', $id);
            if ($tenaga_ahli_pengalaman != null) {
                $tenaga_ahli_pengalaman->delete();
            }

            $pengalaman_tahun = $data['pengalaman_tahun'];
            $pengalaman_uraian = $data['pengalaman_uraian'];
            for ($i = 0; $i < count($pengalaman_tahun); $i++) {
                if ($pengalaman_tahun[$i] == "") { } else {
                    $uuidPengalaman = Uuid::generate();
                    $dataPengalaman['id'] = $uuidPengalaman;
                    $dataPengalaman['mt_tenaga_ahli_id'] = $id;
                    $dataPengalaman['tahun'] = $pengalaman_tahun[$i];
                    $dataPengalaman['uraian'] = $pengalaman_uraian[$i];
                    $dataPengalaman['userid_created'] = Auth::user()->name;
                    TenagaAhliPengalamans::create($dataPengalaman);
                }
            }

            // METODE MENGGUNAKAN DELETE INSERT
            $tenaga_ahli_pendidikan = TenagaAhliPendidikans::where('mt_tenaga_ahli_id', $id);
            if ($tenaga_ahli_pendidikan != null) {
                $tenaga_ahli_pendidikan->delete();
            }

            $pendidikan_tahun = $data['pendidikan_tahun'];
            $pendidikan_uraian = $data['pendidikan_uraian'];
            for ($i = 0; $i < count($pendidikan_tahun); $i++) {
                if ($pendidikan_tahun[$i] == "") { } else {
                    $uuidPendidikan = Uuid::generate();
                    $dataPendidikan['id'] = $uuidPendidikan;
                    $dataPendidikan['mt_tenaga_ahli_id'] = $id;
                    $dataPendidikan['tahun'] = $pendidikan_tahun[$i];
                    $dataPendidikan['uraian'] = $pendidikan_uraian[$i];
                    $dataPendidikan['userid_created'] = Auth::user()->name;
                    TenagaAhliPendidikans::create($dataPendidikan);
                }
            }

            // METODE MENGGUNAKAN DELETE INSERT
            $tenaga_ahli_sertifikat = TenagaAhliSertifikats::where('mt_tenaga_ahli_id', $id);
            if ($tenaga_ahli_sertifikat != null) {
                $tenaga_ahli_sertifikat->delete();
            }

            $sertifikat_tahun = $data['sertifikat_tahun'];
            $sertifikat_uraian = $data['sertifikat_uraian'];
            for ($i = 0; $i < count($sertifikat_tahun); $i++) {
                if ($sertifikat_tahun[$i] == "") { } else {
                    $uuidSertifikat = Uuid::generate();
                    $dataSertifikat['id'] = $uuidSertifikat;
                    $dataSertifikat['mt_tenaga_ahli_id'] = $id;
                    $dataSertifikat['tahun'] = $sertifikat_tahun[$i];
                    $dataSertifikat['uraian'] = $sertifikat_uraian[$i];
                    $dataSertifikat['userid_created'] = Auth::user()->name;
                    TenagaAhliSertifikats::create($dataSertifikat);
                }
            }

            // METODE MENGGUNAKAN DELETE INSERT
            $tenaga_ahli_bahasa = TenagaAhliBahasas::where('mt_tenaga_ahli_id', $id);
            if ($tenaga_ahli_bahasa != null) {
                $tenaga_ahli_bahasa->delete();
            }

            $bahasa_uraian = $data['bahasa_uraian'];
            for ($i = 0; $i < count($bahasa_uraian); $i++) {
                if ($bahasa_uraian[$i] == "") { } else {
                    $uuidBahasa = Uuid::generate();
                    $dataBahasa['id'] = $uuidBahasa;
                    $dataBahasa['mt_tenaga_ahli_id'] = $id;
                    $dataBahasa['uraian'] = $bahasa_uraian[$i];
                    $dataBahasa['userid_created'] = Auth::user()->name;
                    TenagaAhliBahasas::create($dataBahasa);
                }
            }

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('tenagaahlis.edit', ['data' => Crypt::encrypt($id)]);
        } else {
            $tenagaahlis = TenagaAhlis::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, TenagaAhlis::$rules, TenagaAhlis::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $tenagaahlis->update($data);

            // METODE MENGGUNAKAN DELETE INSERT
            $tenaga_ahli_pengalaman = TenagaAhliPengalamans::where('mt_tenaga_ahli_id', $id);
            if ($tenaga_ahli_pengalaman != null) {
                $tenaga_ahli_pengalaman->delete();
            }

            $pengalaman_tahun = $data['pengalaman_tahun'];
            $pengalaman_uraian = $data['pengalaman_uraian'];
            for ($i = 0; $i < count($pengalaman_tahun); $i++) {
                if ($pengalaman_tahun[$i] == "") { } else {
                    $uuidPengalaman = Uuid::generate();
                    $dataPengalaman['id'] = $uuidPengalaman;
                    $dataPengalaman['mt_tenaga_ahli_id'] = $id;
                    $dataPengalaman['tahun'] = $pengalaman_tahun[$i];
                    $dataPengalaman['uraian'] = $pengalaman_uraian[$i];
                    $dataPengalaman['userid_created'] = Auth::user()->name;
                    TenagaAhliPengalamans::create($dataPengalaman);
                }
            }

            // METODE MENGGUNAKAN DELETE INSERT
            $tenaga_ahli_pendidikan = TenagaAhliPendidikans::where('mt_tenaga_ahli_id', $id);
            if ($tenaga_ahli_pendidikan != null) {
                $tenaga_ahli_pendidikan->delete();
            }

            $pendidikan_tahun = $data['pendidikan_tahun'];
            $pendidikan_uraian = $data['pendidikan_uraian'];
            for ($i = 0; $i < count($pendidikan_tahun); $i++) {
                if ($pendidikan_tahun[$i] == "") { } else {
                    $uuidPendidikan = Uuid::generate();
                    $dataPendidikan['id'] = $uuidPendidikan;
                    $dataPendidikan['mt_tenaga_ahli_id'] = $id;
                    $dataPendidikan['tahun'] = $pendidikan_tahun[$i];
                    $dataPendidikan['uraian'] = $pendidikan_uraian[$i];
                    $dataPendidikan['userid_created'] = Auth::user()->name;
                    TenagaAhliPendidikans::create($dataPendidikan);
                }
            }

            // METODE MENGGUNAKAN DELETE INSERT
            $tenaga_ahli_sertifikat = TenagaAhliSertifikats::where('mt_tenaga_ahli_id', $id);
            if ($tenaga_ahli_sertifikat != null) {
                $tenaga_ahli_sertifikat->delete();
            }

            $sertifikat_tahun = $data['sertifikat_tahun'];
            $sertifikat_uraian = $data['sertifikat_uraian'];
            for ($i = 0; $i < count($sertifikat_tahun); $i++) {
                if ($sertifikat_tahun[$i] == "") { } else {
                    $uuidSertifikat = Uuid::generate();
                    $dataSertifikat['id'] = $uuidSertifikat;
                    $dataSertifikat['mt_tenaga_ahli_id'] = $id;
                    $dataSertifikat['tahun'] = $sertifikat_tahun[$i];
                    $dataSertifikat['uraian'] = $sertifikat_uraian[$i];
                    $dataSertifikat['userid_created'] = Auth::user()->name;
                    TenagaAhliSertifikats::create($dataSertifikat);
                }
            }

            // METODE MENGGUNAKAN DELETE INSERT
            $tenaga_ahli_bahasa = TenagaAhliBahasas::where('mt_tenaga_ahli_id', $id);
            if ($tenaga_ahli_bahasa != null) {
                $tenaga_ahli_bahasa->delete();
            }

            $bahasa_uraian = $data['bahasa_uraian'];
            for ($i = 0; $i < count($bahasa_uraian); $i++) {
                if ($bahasa_uraian[$i] == "") { } else {
                    $uuidBahasa = Uuid::generate();
                    $dataBahasa['id'] = $uuidBahasa;
                    $dataBahasa['mt_tenaga_ahli_id'] = $id;
                    $dataBahasa['uraian'] = $bahasa_uraian[$i];
                    $dataBahasa['userid_created'] = Auth::user()->name;
                    TenagaAhliBahasas::create($dataBahasa);
                }
            }

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('tenagaahlis.index');
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
            Tenagaahlis::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            $tenaga_ahli_pengalaman = TenagaAhliPengalamans::where('mt_tenaga_ahli_id', Crypt::decrypt($id));
            if ($tenaga_ahli_pengalaman != null) {
                $tenaga_ahli_pengalaman->delete();
            }

            $tenaga_ahli_pendidikan = TenagaAhliPendidikans::where('mt_tenaga_ahli_id', Crypt::decrypt($id));
            if ($tenaga_ahli_pendidikan != null) {
                $tenaga_ahli_pendidikan->delete();
            }

            $tenaga_ahli_sertifikat = TenagaAhliSertifikats::where('mt_tenaga_ahli_id', Crypt::decrypt($id));
            if ($tenaga_ahli_sertifikat != null) {
                $tenaga_ahli_sertifikat->delete();
            }

            $tenaga_ahli_bahasa = TenagaAhliBahasas::where('mt_tenaga_ahli_id', Crypt::decrypt($id));
            if ($tenaga_ahli_bahasa != null) {
                $tenaga_ahli_bahasa->delete();
            }

            return redirect()->route('tenagaahlis.index');
        } catch (\Exception $id) {
            return redirect()->route('tenagaahlis.index');
        }
    }
}
