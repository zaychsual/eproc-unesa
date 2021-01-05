<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Info;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Auth;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Info::orderBy('created_at', 'DESC')->get();

        return view('webprofile.backend.info.index', compact('data'))->withTitle('Informasi');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.info.create')->withTitle('Tambah Informasi');
    }

    public function info_aktif($id)
    {
        Info::where('id', Crypt::decrypt($id))->update([
          'info_status' => '1',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('info.index');
    }

    public function info_naktif($id)
    {
        Info::where('id', Crypt::decrypt($id))->update([
          'info_status' => '0',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('info.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Info::$rules, Info::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('info.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();

            $data['slug'] = str_slug($request->input('title'));
            $data['slug'] = str_slug($request->input('title'));

            $data['id'] = $uuid;
            $data['posts_status'] = $request->input('posts_status') ? true : false;
            $data['viewer'] = 0;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Info::create($data);

            Alert::success('Informasi berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Informasi Berhasil !!";
            return redirect()->route('info.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function show(Info $info)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Info::find(Crypt::decrypt($id));

            return view('webprofile.backend.info.edit', compact('data'))->withTitle('Ubah Informasi');
        } catch (\Exception $id) {
            return redirect()->route('info.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $info = Info::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, Info::$rules, Info::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['slug'] = str_slug($request->input('title'));
        $data['info_status'] = $request->input('info_status') ? true : false;
        $data['userid_updated'] = Auth::user()->name;
        $info->update($data);

        Alert::success('Informasi berhasil diubah')->persistent('Ok');
        return redirect()->route('info.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Info::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('info.index');
        } catch (\Exception $id) {
            return redirect()->route('info.index');
        }
    }
}
