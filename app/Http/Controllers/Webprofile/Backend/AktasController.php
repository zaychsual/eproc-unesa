<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Aktas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use Storage;
use DB;

class AktasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $data = Aktas::where('mt_rekanan_id', Crypt::decrypt(session('mt_rekanan_id')))->get();
            return view('webprofile.backend.admin.aktas.index', compact('data'))->withTitle('Akta Perusahaan');
        } else {
            $data = Aktas::where('mt_rekanan_id', Auth::user()->mt_rekanan_id)->get();
            return view('webprofile.backend.aktas.index', compact('data'))->withTitle('Akta Perusahaan');
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
            return view('webprofile.backend.admin.aktas.create')->withTitle('Tambah Akta Perusahaan');
        } else {
            return view('webprofile.backend.aktas.create')->withTitle('Tambah Akta Perusahaan');
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
            $validator = Validator::make($data, Aktas::$rules, Aktas::$errormessage);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
                // $errormessage = $validator->messages();
                // return redirect()->route('aktas.create')
                //     ->withErrors($validator)
                // ->withInput();
            } else {
                $uuid = Uuid::generate();

                if ($request->hasFile('pendirian_link_file')) {
                    $cover = $request->file('pendirian_link_file');
                    $extension = $cover->guessClientExtension();
                    $size = $cover->getSize();
                    $filename = $uuid . '.' . $extension;
                    Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/aktas/' . $filename, file_get_contents($cover->getRealPath()));
                    $data['pendirian_link_file'] = $filename;
                }

                if ($request->hasFile('perubahan_link_file')) {
                    $cover = $request->file('perubahan_link_file');
                    $extension = $cover->guessClientExtension();
                    $size = $cover->getSize();
                    $filename = $uuid . '.' . $extension;
                    Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/aktas/' . $filename, file_get_contents($cover->getRealPath()));
                    $data['perubahan_link_file'] = $filename;
                }

                $data['id'] = $uuid;
                $data['is_terisi'] = 1;
                $data['mt_rekanan_id'] = Crypt::decrypt(session('mt_rekanan_id'));
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Aktas::create($data);

                // Alert::success('Data berhasil disimpan')->persistent('Ok');

                // $successmessage = "Proses Tambah Akta Perusahaan Berhasil !!";
                // return redirect()->route('aktas.index')->with('successMessage', $successmessage);

                return response()->json(['success' => 'Data berhasil disimpan.']);
            }
        } else {
            $data = $request->except('_token');
            $validator = Validator::make($data, Aktas::$rules, Aktas::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('aktas.create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();

                if ($request->hasFile('pendirian_link_file')) {
                    $cover = $request->file('pendirian_link_file');
                    $extension = $cover->guessClientExtension();
                    $size = $cover->getSize();
                    $filename = $uuid . '.' . $extension;
                    Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/aktas/' . $filename, file_get_contents($cover->getRealPath()));
                    $data['pendirian_link_file'] = $filename;
                }

                if ($request->hasFile('perubahan_link_file')) {
                    $cover = $request->file('perubahan_link_file');
                    $extension = $cover->guessClientExtension();
                    $size = $cover->getSize();
                    $filename = $uuid . '.' . $extension;
                    Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/aktas/' . $filename, file_get_contents($cover->getRealPath()));
                    $data['perubahan_link_file'] = $filename;
                }

                $data['id'] = $uuid;
                $data['is_terisi'] = 1;
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Aktas::create($data);

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Tambah Akta Perusahaan Berhasil !!";
                return redirect()->route('aktas.index')->with('successMessage', $successmessage);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Aktas $aktas)
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
                $data = Aktas::find(Crypt::decrypt($id));
                return view('webprofile.backend.admin.aktas.edit', compact('data'))->withTitle('Ubah Akta Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('aktas.index');
            }
        } else {
            try {
                $data = Aktas::find(Crypt::decrypt($id));
                return view('webprofile.backend.aktas.edit', compact('data'))->withTitle('Ubah Akta Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('aktas.index');
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
            $data = $request->except('_token');
            $validator = Validator::make($data, Aktas::$rules, Aktas::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $aktas = Aktas::findOrFail($id);

            if ($request->hasFile('pendirian_link_file')) {
                $cover = $request->file('pendirian_link_file');
                $extension = $cover->guessClientExtension();
                $filename = $aktas->id . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/aktas/' . $filename, file_get_contents($cover->getRealPath()));
                $data['pendirian_link_file'] = $filename;
            }

            if ($request->hasFile('perubahan_link_file')) {
                $cover = $request->file('perubahan_link_file');
                $extension = $cover->guessClientExtension();
                $filename = $aktas->id . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/aktas/' . $filename, file_get_contents($cover->getRealPath()));
                $data['perubahan_link_file'] = $filename;
            }

            $data['userid_updated'] = Auth::user()->name;
            $aktas->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('aktas.edit', ['data' => Crypt::encrypt($id)]);
        } else {

            $data = $request->except('_token');
            $validator = Validator::make($data, Aktas::$rules, Aktas::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $aktas = Aktas::findOrFail($id);

            if ($request->hasFile('pendirian_link_file')) {
                $cover = $request->file('pendirian_link_file');
                $extension = $cover->guessClientExtension();
                $filename = $aktas->id . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/aktas/' . $filename, file_get_contents($cover->getRealPath()));
                $data['pendirian_link_file'] = $filename;
            }

            if ($request->hasFile('perubahan_link_file')) {
                $cover = $request->file('perubahan_link_file');
                $extension = $cover->guessClientExtension();
                $filename = $aktas->id . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/aktas/' . $filename, file_get_contents($cover->getRealPath()));
                $data['perubahan_link_file'] = $filename;
            }

            $data['userid_updated'] = Auth::user()->name;
            $aktas->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('aktas.index');
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
            Aktas::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('aktas.index');
        } catch (\Exception $id) {
            return redirect()->route('aktas.index');
        }
    }
}
