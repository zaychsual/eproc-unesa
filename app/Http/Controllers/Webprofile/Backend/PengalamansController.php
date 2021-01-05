<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Pengalamans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class PengalamansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $data = Pengalamans::where('mt_rekanan_id', Crypt::decrypt(session('mt_rekanan_id')))->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.admin.pengalamans.index', compact('data'))->withTitle('Pengalaman Perusahaan');
        } else {
            $data = Pengalamans::where('mt_rekanan_id', Auth::user()->mt_rekanan_id)->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.pengalamans.index', compact('data'))->withTitle('Pengalaman Perusahaan');
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
            return view('webprofile.backend.admin.pengalamans.create')->withTitle('Tambah Pengalaman Perusahaan');
        } else {
            return view('webprofile.backend.pengalamans.create')->withTitle('Tambah Pengalaman Perusahaan');
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
            $validator = Validator::make($data, Pengalamans::$rules, Pengalamans::$errormessage);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
                // $errormessage = $validator->messages();
                // return redirect()->route('pengalamans.create')
                //     ->withErrors($validator)
                //     ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Crypt::decrypt(session('mt_rekanan_id'));
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;
                $data['nilai_kontrak'] = str_replace('.', '', $request['nilai_kontrak']);

                Pengalamans::create($data);

                // Alert::success('Data berhasil disimpan')->persistent('Ok');

                // $successmessage = "Proses Tambah Pengalaman Perusahaan Berhasil !!";
                // return redirect()->route('pengalamans.index')->with('successMessage', $successmessage);
                return response()->json(['success' => 'Data berhasil disimpan.']);
            }
        } else {
            $data = $request->except('_token');
            $validator = Validator::make($data, Pengalamans::$rules, Pengalamans::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('pengalamans.create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;
                $data['nilai_kontrak'] = str_replace('.', '', $request['nilai_kontrak']);

                Pengalamans::create($data);

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Tambah Pengalaman Perusahaan Berhasil !!";
                return redirect()->route('pengalamans.index')->with('successMessage', $successmessage);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Pengalamans $pengalamans)
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
                $data = Pengalamans::find(Crypt::decrypt($id));
                return view('webprofile.backend.admin.pengalamans.edit', compact('data'))->withTitle('Ubah Pengalaman Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('pengalamans.index');
            }
        } else {
            try {
                $data = Pengalamans::find(Crypt::decrypt($id));
                return view('webprofile.backend.pengalamans.edit', compact('data'))->withTitle('Ubah Pengalaman Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('pengalamans.index');
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
            $pengalamans = Pengalamans::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, Pengalamans::$rules, Pengalamans::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $data['nilai_kontrak'] = str_replace('.', '', $request['nilai_kontrak']);
            $pengalamans->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('pengalamans.edit', ['data' => Crypt::encrypt($id)]);
        } else {
            $pengalamans = Pengalamans::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, Pengalamans::$rules, Pengalamans::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $data['nilai_kontrak'] = str_replace('.', '', $request['nilai_kontrak']);
            $pengalamans->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('pengalamans.index');
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
            Pengalamans::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('pengalamans.index');
        } catch (\Exception $id) {
            return redirect()->route('pengalamans.index');
        }
    }
}
