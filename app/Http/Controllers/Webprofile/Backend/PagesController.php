<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Storage;
use Auth;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pages::orderBy('title', 'ASC')->get();

        return view('webprofile.backend.pages.index', compact('data'))->withTitle('Halaman');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('webprofile.backend.pages.create')->withTitle('Tambah Halaman');
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
        $validator = Validator::make($data, Pages::$rules, Pages::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('pages.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();
            $data['slug'] = str_slug($request->input('title'));

            if ($request->hasFile('thumbnail')) {
                $cover = $request->file('thumbnail');
                $extension = $cover->guessClientExtension();
                $filename = $uuid . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/pages/' . $filename, file_get_contents($cover->getRealPath()));
                $data['thumbnail'] = $filename;
            }

            $data['id'] = $uuid;
            $data['posts_status'] = $request->input('posts_status') ? true : false;
            $data['comment_status'] = 0;
            $data['viewer'] = 0;
            $data['comment_count'] = 0;
            $data['userid_created'] = Auth::user()->name;
            $data['userid_updated'] = Auth::user()->name;

            Pages::create($data);

            Alert::success('Berita berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Berita Berhasil !!";
            return redirect()->route('pages.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function show(Pages $pages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Pages::find(Crypt::decrypt($id));

            return view('webprofile.backend.pages.edit', compact('data'))->withTitle('Ubah Halaman');
        } catch (\Exception $id) {
            return redirect()->route('pages.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Pages::$rules, Pages::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $pages = Pages::findOrFail($id);
        $data['slug'] = str_slug($request->input('title'));

        if ($request->hasFile('thumbnail')) {
            $cover = $request->file('thumbnail');
            $extension = $cover->guessClientExtension();
            $filename = $pages->id . '.' . $extension;
            Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/pages/' . $filename, file_get_contents($cover->getRealPath()));
            $data['thumbnail'] = $filename;
        }

        $data['posts_status'] = $request->input('posts_status') ? true : false;
        $data['userid_updated'] = Auth::user()->name;
        $pages->update($data);

        Alert::success('Halaman berhasil diubah')->persistent('Ok');
        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Pages::where('id', Crypt::decrypt($id))->first();
            if ($data->thumbnail) {
                Storage::disk('uploads')->delete('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/pages/' . $data->thumbnail);
            }
            Pages::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('pages.index');
        } catch (\Exception $id) {
            return redirect()->route('pages.index');
        }
    }
}
