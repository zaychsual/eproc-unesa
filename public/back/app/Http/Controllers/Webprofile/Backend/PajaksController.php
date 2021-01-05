<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Pajaks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;
use Storage;

class PajaksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $data = Pajaks::where('mt_rekanan_id', Crypt::decrypt(session('mt_rekanan_id')))->orderBy('jenis', 'ASC')->get();
            return view('webprofile.backend.admin.pajaks.index', compact('data'))->withTitle('Pajak Perusahaan');
        } else {
            $data = Pajaks::where('mt_rekanan_id', Auth::user()->mt_rekanan_id)->orderBy('jenis', 'ASC')->get();
            return view('webprofile.backend.pajaks.index', compact('data'))->withTitle('Pajak Perusahaan');
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
            return view('webprofile.backend.admin.pajaks.create')->withTitle('Tambah Pajak Perusahaan');
        } else {
            return view('webprofile.backend.pajaks.create')->withTitle('Tambah Pajak Perusahaan');
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
            $validator = Validator::make($data, Pajaks::$rules, Pajaks::$errormessage);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
                // $errormessage = $validator->messages();
                // return redirect()->route('pajaks.create')
                //     ->withErrors($validator)
                //     ->withInput();
            } else {
                $uuid = Uuid::generate();

                if ($request->hasFile('thumbnail')) {
                    $cover = $request->file('thumbnail');
                    $extension = $cover->guessClientExtension();
                    $size = $cover->getSize();
                    $filename = $uuid . '.' . $extension;
                    Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/pajaks/' . $filename, file_get_contents($cover->getRealPath()));
                    $data['thumbnail'] = $filename;
                }

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Crypt::decrypt(session('mt_rekanan_id'));
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Pajaks::create($data);

                // Alert::success('Data berhasil disimpan')->persistent('Ok');

                // $successmessage = "Proses Tambah Pajak Perusahaan Berhasil !!";
                // return redirect()->route('pajaks.index')->with('successMessage', $successmessage);
                return response()->json(['success' => 'Data berhasil disimpan.']);
            }
        } else {

            $data = $request->except('_token');
            $validator = Validator::make($data, Pajaks::$rules, Pajaks::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->route('pajaks.create')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $uuid = Uuid::generate();

                if ($request->hasFile('thumbnail')) {
                    $cover = $request->file('thumbnail');
                    $extension = $cover->guessClientExtension();
                    $size = $cover->getSize();
                    $filename = $uuid . '.' . $extension;
                    Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/pajaks/' . $filename, file_get_contents($cover->getRealPath()));
                    $data['thumbnail'] = $filename;
                }

                $data['id'] = $uuid;
                $data['mt_rekanan_id'] = Auth::user()->mt_rekanan_id;
                $data['userid_created'] = Auth::user()->name;
                $data['userid_updated'] = Auth::user()->name;

                Pajaks::create($data);

                Alert::success('Data berhasil disimpan')->persistent('Ok');

                $successmessage = "Proses Tambah Pajak Perusahaan Berhasil !!";
                return redirect()->route('pajaks.index')->with('successMessage', $successmessage);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Pajaks $pajaks)
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
                $data = Pajaks::find(Crypt::decrypt($id));
                return view('webprofile.backend.admin.pajaks.edit', compact('data'))->withTitle('Ubah Pajak Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('pajaks.index');
            }
        } else {
            try {
                $data = Pajaks::find(Crypt::decrypt($id));
                return view('webprofile.backend.pajaks.edit', compact('data'))->withTitle('Ubah Pajak Perusahaan');
            } catch (\Exception $id) {
                return redirect()->route('pajaks.index');
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
            $validator = Validator::make($data, Pajaks::$rules, Pajaks::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $pajaks = Pajaks::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                $cover = $request->file('thumbnail');
                $extension = $cover->guessClientExtension();
                $filename = $pajaks->id . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/pajaks/' . $filename, file_get_contents($cover->getRealPath()));
                $data['thumbnail'] = $filename;
            }

            $data['userid_updated'] = Auth::user()->name;
            $pajaks->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('pajaks.edit', ['data' => Crypt::encrypt($id)]);
        } else {
            $data = $request->except('_token');
            $validator = Validator::make($data, Pajaks::$rules, Pajaks::$errormessage);

            if ($validator->fails()) {
                $errormessage = $validator->messages();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $pajaks = Pajaks::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                $cover = $request->file('thumbnail');
                $extension = $cover->guessClientExtension();
                $filename = $pajaks->id . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/' . Session::get('ss_setting')['statik_konten'] . '/pajaks/' . $filename, file_get_contents($cover->getRealPath()));
                $data['thumbnail'] = $filename;
            }

            $data['userid_updated'] = Auth::user()->name;
            $pajaks->update($data);

            Alert::success('Data berhasil diubah')->persistent('Ok');
            return redirect()->route('pajaks.index');
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
            Pajaks::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('pajaks.index');
        } catch (\Exception $id) {
            return redirect()->route('pajaks.index');
        }
    }
}
