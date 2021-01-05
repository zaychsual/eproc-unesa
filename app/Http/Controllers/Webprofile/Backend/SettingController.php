<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use App\Helpers\InseoHelper;
use Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Setting::orderBy('name_setting', 'ASC')->get();

        return view('webprofile.backend.setting.index', compact('data'))->withTitle('Pengaturan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.setting.create')->withTitle('Tambah Pengaturan');
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
        $validator = Validator::make($data, Setting::$rules, Setting::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('setting.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();

            $data['id'] = $uuid;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Setting::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Pengaturan Berhasil !!";
            return redirect()->route('setting.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Setting::find(Crypt::decrypt($id));
            return view('webprofile.backend.setting.edit', compact('data'))->withTitle('Ubah Pengaturan');
        } catch (\Exception $id) {
            return redirect()->route('setting.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $data = $request->except('_token');
        $validator = Validator::make($data, Setting::$rules, Setting::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['userid_updated'] = Auth::user()->name;
        $setting->update($data);

        InseoHelper::setting();

        Alert::success('Data berhasil diubah')->persistent('Ok');
        return redirect()->route('setting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // try {
      //     Setting::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));
      //
      //     return redirect()->route('setting.index');
      // } catch (\Exception $id) {
      //     return redirect()->route('setting.index');
      // }
    }
}
