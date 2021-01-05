<?php

namespace App\Http\Controllers\Webprofile\Backend;

use App\Models\Webprofile\Posts;
use App\Models\Webprofile\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Uuid;
use Alert;
use Session;
use Crypt;
use Storage;
use Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(Auth::user()->role == 'admin') {
            $data = Posts::orderBy('post_date', 'desc')
                ->get();
        } else {
            $data = Posts::orderBy('post_date', 'desc')
                ->where('userid_created', '=', Auth::user()->id)
                ->get();
        }

        return view('webprofile.backend.posts.index', compact('data'))->withTitle('Berita');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');

        return view('webprofile.backend.posts.create', compact('categories'))->withTitle('Tambah Berita');
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
        $validator = Validator::make($data, Posts::$rules, Posts::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->route('posts.create')
              ->withErrors($validator)
              ->withInput();
        } else {
            $uuid = Uuid::generate();
            $data['slug'] = str_slug($request->input('title'));

            if ($request->hasFile('thumbnail')) {
                $cover = $request->file('thumbnail');
                $extension = $cover->guessClientExtension();
                $size = $cover->getSize();
                $filename = $uuid . '.' . $extension;
                Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/posts/' . $filename, file_get_contents($cover->getRealPath()));
                $data['thumbnail'] = $filename;
            }

            $data['id'] = $uuid;
            $data['post_date'] = $request->input('post_date') . ' ' . Date('h:m:s');
            $data['posts_status'] = $request->input('posts_status') ? true : false;
            $data['comment_status'] = 0;
            $data['viewer'] = 0;
            $data['comment_count'] = 0;
            $data['userid_created'] = Auth::user()->id;
            $data['userid_updated'] = Auth::user()->id;
            $data['tipe_file'] = $extension;
            $data['ukuran_file'] = $size;

            Posts::create($data);

            Alert::success('Berita berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah Berita Berhasil !!";
            return redirect()->route('posts.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Posts::find(Crypt::decrypt($id));
            $categories = Categories::where('is_active', '1')->orderBy('name', 'ASC')->pluck('name', 'id');

            return view('webprofile.backend.posts.edit', compact('data', 'categories'))->withTitle('Ubah Berita');
        } catch (\Exception $id) {
            return redirect()->route('posts.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Posts::$rules, Posts::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $posts = Posts::findOrFail($id);
        $data['slug'] = str_slug($request->input('title'));

        if ($request->hasFile('thumbnail')) {
            $cover = $request->file('thumbnail');
            $extension = $cover->guessClientExtension();
            $filename = $posts->id . '.' . $extension;
            Storage::disk('uploads')->put('profileunesa_konten_statik/uploads/'.Session::get('ss_setting')['statik_konten'].'/posts/' . $filename, file_get_contents($cover->getRealPath()));
            $data['thumbnail'] = $filename;
        }

        $data['posts_date'] = $request->input('tanggal') . ' 00:00:00';
        $data['posts_status'] = $request->input('posts_status') ? true : false;
        $data['userid_updated'] = Auth::user()->id;
        $posts->update($data);

        Alert::success('Berita berhasil diubah')->persistent('Ok');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Posts::where('id', Crypt::decrypt($id))->first();
            if ($data->thumbnail) {
                Storage::disk('uploads')->delete('profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/posts/' . $data->thumbnail);
            }
            Posts::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

            return redirect()->route('posts.index');
        } catch (\Exception $id) {
            return redirect()->route('posts.index');
        }
    }
}
