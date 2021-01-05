<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Peralatans;
use App\Models\Webprofile\Statusmiliks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class PeralatansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $data = Peralatans::where('mt_rekanan_id', Crypt::decrypt(session('mt_rekanan_id')))->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.admin.peralatans.index', compact('data'))->withTitle('Peralatan Perusahaan');
        } else {
            $data = Peralatans::where('mt_rekanan_id', Auth::user()->mt_rekanan_id)->orderBy('nama', 'ASC')->get();
            return view('webprofile.backend.peralatans.index', compact('data'))->withTitle('Peralatan Perusahaan');
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
            $status_miliks = Statusmiliks::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
            return view('webprofile.backend.admin.peralatans.create', compact('status_miliks'))->withTitle('Tambah Peralatan Perusahaan');
        } else {
            $status_miliks = Statusmiliks::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
            return view('webprofile.backend.peralatans.create', compact('status_miliks'))->withTitle('Tambah Peralatan Perusahaan');
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
            $validator = Validator::make($data, Peralatans::$rules, Peralatans::$errormessage);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
                // $errormessage = $validator->messages();
                // return redirect()->route('peralatans.create')
                //     ->withErrors($validator)
                //     ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Crypt::decrypt(session('mt_rekanan_id'));
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Peralatans::create($data);

                // Alert::success('Data berhasil disimpan')->persistent('Ok');

                // $successmessage = "Proses Tambah Peralatan Perusahaan Berhasil !!";
                // return redirect()->route('peralatans.index')->with('successMessage', $successmessage);
                return response()->json(['success' => 'Data berhasil disimpan.']);
            }
        } else {
            $data = $request->except('_token');
            $validator = Validator::make($data, Peralatans::$rules, Peralatans::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('peralatans.create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Peralatans::create($data);

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Tambah Peralatan Perusahaan Berhasil !!";
                return redirect()->route('peralatans.index')->with('successMessage', $successmessage);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Peralatans $peralatans)
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
                $data = Peralatans::find(Crypt::decrypt($id));
                $status_miliks = Statusmiliks::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
                return view('webprofile.backend.admin.peralatans.edit', compact('data', 'status_miliks'))->withTitle('Ubah Peralatan Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('peralatans.index');
            }
        } else {
            try {
                $data = Peralatans::find(Crypt::decrypt($id));
                $status_miliks = Statusmiliks::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
                return view('webprofile.backend.peralatans.edit', compact('data', 'status_miliks'))->withTitle('Ubah Peralatan Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('peralatans.index');
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
            $peralatans = Peralatans::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, Peralatans::$rules, Peralatans::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $peralatans->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('peralatans.edit', ['data' => Crypt::encrypt($id)]);
        } else {
            $peralatans = Peralatans::findOrFail($id);

            $data = $request->except('_token');
            $validator = Validator::make($data, Peralatans::$rules, Peralatans::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['userid_updated'] = Auth::user()->name;
            $peralatans->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('peralatans.index');
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
            Peralatans::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('peralatans.index');
        } catch (\Exception $id) {
            return redirect()->route('peralatans.index');
        }
    }
}
