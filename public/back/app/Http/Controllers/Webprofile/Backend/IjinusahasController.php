<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Ijinusahas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use Storage;

class IjinusahasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $data = Ijinusahas::where('mt_rekanan_id', Crypt::decrypt(session('mt_rekanan_id')))->orderBy('jenis_ijin', 'ASC')->get();

            return view('webprofile.backend.admin.ijinusahas.index', compact('data'))->withTitle('Rekanan');
        } else {
            $data = Ijinusahas::where('mt_rekanan_id', Auth::user()->mt_rekanan_id)->orderBy('jenis_ijin', 'ASC')->get();

            return view('webprofile.backend.ijinusahas.index', compact('data'))->withTitle('Ijin Usaha Perusahaan');
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
            return view('webprofile.backend.admin.ijinusahas.create')->withTitle('Tambah Ijin Usaha Perusahaan');
        } else {
            return view('webprofile.backend.ijinusahas.create')->withTitle('Tambah Ijin Usaha Perusahaan');
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
            $validator = Validator::make($data, Ijinusahas::$rules, Ijinusahas::$errormessage);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
                // $errormessage = $validator->messages();
                // return redirect()->route('ijinusahas.create')
                //     ->withErrors($validator)
                //     ->withInput();
            } else {
                $uuid = Uuid::generate();

                if ($request->hasFile('link_file')) {
                    $cover = $request->file('link_file');
                    $extension = $cover->guessClientExtension();
                    $size = $cover->getSize();
                    $filename = $uuid . '.' . $extension;
                    Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/ijinusahas/' . $filename, file_get_contents($cover->getRealPath()));
                    $data['link_file'] = $filename;
                }

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Crypt::decrypt(session('mt_rekanan_id'));
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Ijinusahas::create($data);

                // Alert::success('Data berhasil disimpan')->persistent('Ok');

                // $successmessage = "Proses Tambah Ijin Usaha Perusahaan Berhasil !!";
                // return redirect()->route('ijinusahas.index')->with('successMessage', $successmessage);

                return response()->json(['success' => 'Data berhasil disimpan.']);
            }
        } else {

            $data = $request->except('_token');
            $validator = Validator::make($data, Ijinusahas::$rules, Ijinusahas::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('ijinusahas.create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();

                if ($request->hasFile('link_file')) {
                    $cover = $request->file('link_file');
                    $extension = $cover->guessClientExtension();
                    $size = $cover->getSize();
                    $filename = $uuid . '.' . $extension;
                    Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/ijinusahas/' . $filename, file_get_contents($cover->getRealPath()));
                    $data['link_file'] = $filename;
                }

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Ijinusahas::create($data);

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Tambah Ijin Usaha Perusahaan Berhasil !!";
                return redirect()->route('ijinusahas.index')->with('successMessage', $successmessage);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Ijinusahas $ijinusahas)
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
                $data = Ijinusahas::find(Crypt::decrypt($id));
                return view('webprofile.backend.admin.ijinusahas.edit', compact('data'))->withTitle('Ubah Ijin Usaha Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('ijinusahas.index');
            }
        } else {
            try {
                $data = Ijinusahas::find(Crypt::decrypt($id));
                return view('webprofile.backend.ijinusahas.edit', compact('data'))->withTitle('Ubah Ijin Usaha Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('ijinusahas.index');
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
            $validator = Validator::make($data, Ijinusahas::$rules, Ijinusahas::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $ijinusahas = Ijinusahas::findOrFail($id);

            if ($request->hasFile('link_file')) {
                $cover = $request->file('link_file');
                $extension = $cover->guessClientExtension();
                $filename = $ijinusahas->id . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/ijinusahas/' . $filename, file_get_contents($cover->getRealPath()));
                $data['link_file'] = $filename;
            }

            $data['userid_updated'] = Auth::user()->name;
            $ijinusahas->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('ijinusahas.edit', ['data' => Crypt::encrypt($id)]);
        } else {

            $data = $request->except('_token');
            $validator = Validator::make($data, Ijinusahas::$rules, Ijinusahas::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $ijinusahas = Ijinusahas::findOrFail($id);

            if ($request->hasFile('link_file')) {
                $cover = $request->file('link_file');
                $extension = $cover->guessClientExtension();
                $filename = $ijinusahas->id . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/ijinusahas/' . $filename, file_get_contents($cover->getRealPath()));
                $data['link_file'] = $filename;
            }

            $data['userid_updated'] = Auth::user()->name;
            $ijinusahas->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('ijinusahas.index');
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
            Ijinusahas::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('ijinusahas.index');
        } catch (\Exception $id) {
            return redirect()->route('ijinusahas.index');
        }
    }
}
