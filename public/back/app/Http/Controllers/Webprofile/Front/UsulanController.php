<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use Validator;
use Uuid;
use App\Models\Posts;
use App\Models\Info;
use App\Models\Menu;
use App\Models\Usulan;
use InseoHelper;

class UsulanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post_count = (int)Session::get('ss_setting')['post_per_page'];
        $news = Posts::where('posts_status', '1')->orderby('post_date', 'desc')->paginate($post_count);
        $resend = Posts::where('posts_status', '1')->orderby('post_date', 'desc')->limit('5')->get();
        $hot = Posts::where('posts_status', '1')->orderby('viewer', 'desc')->limit('5')->get();
        $info = Info::where('info_status', '1')->orderby('created_at', 'desc')->get();
        $menu = Menu::orderby('urutan', 'asc')->get();

        return view('front.usulan', compact('news', 'hot', 'resend', 'info', 'menu'))->withTitle('Home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, Usulan::$rules, Usulan::$errormessage);

        if ($validator->fails()) {
            $errormessage = $validator->messages();
            if ($errormessage->first('g-recaptcha-response')) {
                Alert::error('Captcha Salah')->persistent('Ok');

                return redirect('usulan')
                ->withErrors($validator)
                ->withInput();
            }

            Alert::error('Isian tidak lengkap', 'Gagal mengirim pengajuan')->persistent('Ok');

            return redirect('usulan')
              ->withErrors($validator)
              ->withInput();
        }

        $uuid = Uuid::generate();

        $data['id'] = $uuid;
        $data['status'] = 0;
        $data['userid_created'] = 'website';
        $data['userid_updated'] = 'website';

        Usulan::create($data);

        Alert::success('Pengajuan berhasil dikirim')->persistent('Ok');

        return redirect('usulan');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
