<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Storage;
use Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Slider::orderBy('created_at', 'DESC')->get();

        return view('webprofile.backend.slider.index', compact('data'))->withTitle('Slider');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.slider.create')->withTitle('Tambah Slider');
    }

    public function slider_aktif($id)
    {
        Slider::where('id', Crypt::decrypt($id))->update([
          'is_active' => '1',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('slider.index');
    }

    public function slider_naktif($id)
    {
        Slider::where('id', Crypt::decrypt($id))->update([
          'is_active' => '0',
          'userid_created' => Auth::user()->name,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('slider.index');
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
        $validator = Validator::make($data, Slider::$rules, Slider::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('slider.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();

            if ($request->hasFile('images')) {
                $cover = $request->file('images');
                $extension = $cover->guessClientExtension();
                $filename = $uuid . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/slider/' . $filename, file_get_contents($cover->getRealPath()));
                $data['images'] = $filename;
            }

            $data['id'] = $uuid;
            $data['is_active'] = $request->input('is_active') ? true : false;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Slider::create($data);

            Alert::success('Slider berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Slider Berhasil !!";
            return redirect()->route('slider.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Slider::find(Crypt::decrypt($id));

            return view('webprofile.backend.slider.edit', compact('data'))->withTitle('Ubah Slider');
        } catch (\Exception $id) {
            return redirect()->route('slider.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Slider::$rules, Slider::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $slider = Slider::findOrFail($id);

        if ($request->hasFile('images')) {
            $cover = $request->file('images');
            $extension = $cover->guessClientExtension();
            $filename = $slider->id . '.' . $extension;
            Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/slider/' . $filename, file_get_contents($cover->getRealPath()));
            $data['images'] = $filename;
        }

        $data['is_active'] = $request->input('is_active') ? true : false;
        $data['userid_updated'] = Auth::user()->name;
        $slider->update($data);

        Alert::success('Slider berhasil diubah')->persistent('Ok');
        return redirect()->route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Slider::where('id', Crypt::decrypt($id))->first();
            if ($data->images) {
                Storage::disk('uploads')->delete('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/slider/' . $data->images);
            }
            Slider::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('slider.index');
        } catch (\Exception $id) {
            return redirect()->route('slider.index');
        }
    }
}
