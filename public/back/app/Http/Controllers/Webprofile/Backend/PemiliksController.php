<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Pemiliks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class PemiliksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $data = Pemiliks::where('mt_rekanan_id', Crypt::decrypt(session('mt_rekanan_id')))->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.admin.pemiliks.index', compact('data'))->withTitle('Pemilik Perusahaan');
        } else {
            $data = Pemiliks::where('mt_rekanan_id', Auth::user()->mt_rekanan_id)->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.pemiliks.index', compact('data'))->withTitle('Pemilik Perusahaan');
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
            return view('webprofile.backend.admin.pemiliks.create')->withTitle('Tambah Pemilik Perusahaan');
        } else {
            return view('webprofile.backend.pemiliks.create')->withTitle('Tambah Pemilik Perusahaan');
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
            $validator = Validator::make($data, Pemiliks::$rules, Pemiliks::$errormessage);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
                // $errormessage = $validator->messages();
                // return redirect()->route('pemiliks.create')
                //     ->withErrors($validator)
                //     ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Crypt::decrypt(session('mt_rekanan_id'));
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Pemiliks::create($data);

                // Alert::success('Data berhasil disimpan')->persistent('Ok');

                // $successmessage = "Proses Tambah Pemilik Perusahaan Berhasil !!";
                // return redirect()->route('pemiliks.index')->with('successMessage', $successmessage);

                return response()->json(['success' => 'Data berhasil disimpan.']);
            }
        } else {

            $data = $request->except('_token');
            $validator = Validator::make($data, Pemiliks::$rules, Pemiliks::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('pemiliks.create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Pemiliks::create($data);

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Tambah Pemilik Perusahaan Berhasil !!";
                return redirect()->route('pemiliks.index')->with('successMessage', $successmessage);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Pemiliks $pemiliks)
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
                $data = Pemiliks::find(Crypt::decrypt($id));
                return view('webprofile.backend.admin.pemiliks.edit', compact('data'))->withTitle('Ubah Pemilik Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('pemiliks.index');
            }
        } else {
            try {
                $data = Pemiliks::find(Crypt::decrypt($id));
                return view('webprofile.backend.pemiliks.edit', compact('data'))->withTitle('Ubah Pemilik Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('pemiliks.index');
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
            $pemiliks = Pemiliks::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, Pemiliks::$rules, Pemiliks::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $pemiliks->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('pemiliks.edit', ['data' => Crypt::encrypt($id)]);
        } else {

            $pemiliks = Pemiliks::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, Pemiliks::$rules, Pemiliks::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $pemiliks->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('pemiliks.index');
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
            Pemiliks::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('pemiliks.index');
        } catch (\Exception $id) {
            return redirect()->route('pemiliks.index');
        }
    }
}
