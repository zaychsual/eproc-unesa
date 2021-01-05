<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Pengurus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $data = Pengurus::where('mt_rekanan_id', Crypt::decrypt(session('mt_rekanan_id')))->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.admin.pengurus.index', compact('data'))->withTitle('Pengurus Perusahaan');
        } else {
            $data = Pengurus::where('mt_rekanan_id', Auth::user()->mt_rekanan_id)->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.pengurus.index', compact('data'))->withTitle('Pengurus Perusahaan');
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
            return view('webprofile.backend.admin.pengurus.create')->withTitle('Tambah Pengurus Perusahaan');
        } else {
            return view('webprofile.backend.pengurus.create')->withTitle('Tambah Pengurus Perusahaan');
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
            $validator = Validator::make($data, Pengurus::$rules, Pengurus::$errormessage);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
                // $errormessage = $validator->messages();
                // return redirect()->route('pengurus.create')
                //     ->withErrors($validator)
                //     ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Crypt::decrypt(session('mt_rekanan_id'));
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Pengurus::create($data);

                // Alert::success('Data berhasil disimpan')->persistent('Ok');

                // $successmessage = "Proses Tambah Pengurus Perusahaan Berhasil !!";
                // return redirect()->route('pengurus.index')->with('successMessage', $successmessage);
                return response()->json(['success' => 'Data berhasil disimpan.']);
            }
        } else {

            $data = $request->except('_token');
            $validator = Validator::make($data, Pengurus::$rules, Pengurus::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('pengurus.create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Pengurus::create($data);

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Tambah Pengurus Perusahaan Berhasil !!";
                return redirect()->route('pengurus.index')->with('successMessage', $successmessage);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Pengurus $pengurus)
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
                $data = Pengurus::find(Crypt::decrypt($id));
                return view('webprofile.backend.admin.pengurus.edit', compact('data'))->withTitle('Ubah Pengurus Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('pengurus.index');
            }
        } else {
            try {
                $data = Pengurus::find(Crypt::decrypt($id));
                return view('webprofile.backend.pengurus.edit', compact('data'))->withTitle('Ubah Pengurus Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('pengurus.index');
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
            $pengurus = Pengurus::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, Pengurus::$rules, Pengurus::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $pengurus->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('pengurus.edit', ['data' => Crypt::encrypt($id)]);
        } else {

            $pengurus = Pengurus::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, Pengurus::$rules, Pengurus::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $pengurus->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('pengurus.index');
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
            Pengurus::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('pengurus.index');
        } catch (\Exception $id) {
            return redirect()->route('pengurus.index');
        }
    }
}
