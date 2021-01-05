<?php

namespace App\Http\Controllers\Webprofile\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Webprofile\Categories;
use App\Models\Webprofile\Posts;
use App\Models\Webprofile\Pages;
use App\Models\Webprofile\Info;
use App\Models\Webprofile\Slider;
use App\Models\Webprofile\Menu;
use App\Models\Webprofile\Newmenu;
use App\Models\Webprofile\Design;
use App\Models\Webprofile\Gallery;
use InseoHelper;
use Crypt;
use Session;
use App\Models\Webprofile\CategoriesFile;
use App\Repositories\FileRepository;
use Alert;

class FrontController extends Controller
{
    private $fileRepo;
    public function __construct(FileRepository $fileRepo)
    {
        $this->fileRepo = $fileRepo;
    }

    public function index()
    {
        $setting = InseoHelper::setting();
        // InseoHelper::prodisetting();
        // dd(Session::get('ss_setting'));
        if (empty(Session::get('ss_setting'))) {
            return redirect()->to('http://pasca.unesa.ac.id');
        }
        
        $post_count = (int)Session::get('ss_setting')['post_per_page'];
        $news = Posts::where('posts_status', '1')->orderby('post_date', 'desc')->paginate($post_count);
        $resend = Posts::where('posts_status', '1')->orderby('post_date', 'desc')->limit('5')->get();
        $hot = Posts::where('posts_status', '1')->orderby('viewer', 'desc')->limit('5')->get();
        $info = Info::where('info_status', '1')->where('event_date', '>=', Date('Y-m-d'))->orderby('event_date', 'asc')->get();
        $slider = Slider::where('is_active', '1')->orderby('created_at', 'desc')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();
        // $arr = $this->build_menu();
        $footer = InseoHelper::footer();

        $quote = Design::where('name_design', 'quote')->get();
        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();
        
        $gallery = Gallery::where('is_active', '1')->orderBy('created_at', 'asc')->limit('4')->get();
        
        $body = Design::where('name_design', 'body')->get();

        return view('webprofile.front.index', compact('news', 'hot', 'resend', 'info', 'slider', 'menu', 'footer', 'quote', 'widget_right', 'widget_left', 'gallery', 'body'))->withTitle('Home');
    }

    public function page($title)
    {
        // dd($title);
        // dd(Session::get('ss_wildcard'));
        $setting = InseoHelper::setting();
        $data = Pages::where('slug', $title)->first();
        // $menu = Menu::orderby('urutan', 'asc')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();
        // $footer = InseoHelper::footer();
        $footer = InseoHelper::footer();

        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        return View('webprofile.front.viewpage', compact('data', 'menu', 'footer', 'widget_right', 'widget_left'));
    }

    public function post($title)
    {
        // $newtitle = str_replace('-', ' ', $title);
        $setting = InseoHelper::setting();
        $data = Posts::where('slug', $title)->first();
        $resend = Posts::where('posts_status', '1')->orderby('post_date', 'desc')->limit('5')->get();
        // $menu = Menu::orderby('urutan', 'asc')->orderby('name', 'asc')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();
        $hot = Posts::where('posts_status', '1')->orderby('viewer', 'desc')->limit('5')->get();
        $categories = Categories::where('is_active', '1')->get();

        $footer = InseoHelper::footer();

        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        $viewer = Posts::findOrFail($data->id);
        $datain['viewer'] = (int)$data->viewer+1;
        $viewer->update($datain);

        return View('webprofile.front.viewpost', compact('data', 'resend', 'categories', 'menu', 'hot', 'footer', 'widget_right', 'widget_left'));
    }

    public function archive()
    {
        $setting = InseoHelper::setting();
        $post_count = (int)Session::get('ss_setting')['post_per_page'];
        $data = Posts::where('posts_status', '1')->orderBy('post_date', 'desc')->paginate($post_count);
        $categories = Categories::where('is_active', '1')->get();
        $hot = Posts::where('posts_status', '1')->orderby('viewer', 'desc')->limit('5')->get();
        // $menu = Menu::orderby('urutan', 'asc')->orderby('name', 'asc')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();

        $footer = InseoHelper::footer();
        
        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        return View('webprofile.front.archive', compact('data', 'categories', 'hot', 'menu', 'footer', 'widget_right', 'widget_left'))->withTitle('Arsip');
    }

    public function category($name)
    {
        $setting = InseoHelper::setting();
        $kat = Categories::where('name', $name)->first();

        $post_count = (int)Session::get('ss_setting')['post_per_page'];
        $data = Posts::where('categories', $kat->id)->where('posts_status', '1')->orderBy('post_date', 'desc')->paginate($post_count);
        $categories = Categories::where('is_active', '1')->get();
        $hot = Posts::where('posts_status', '1')->orderby('viewer', 'desc')->limit('5')->get();
        // $menu = Menu::orderby('urutan', 'asc')->orderby('name', 'asc')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();

        $footer = InseoHelper::footer();

        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        return View('webprofile.front.archive', compact('data', 'categories', 'hot', 'menu', 'footer', 'widget_right', 'widget_left'))->withTitle('Kategori '.$kat->name);
    }

    public function agenda()
    {
        $setting = InseoHelper::setting();
        $post_count = (int)Session::get('ss_setting')['post_per_page'];
        $data = Info::where('info_status', '1')->orderBy('event_date', 'desc')->paginate($post_count);
        $categories = Categories::where('is_active', '1')->get();
        $hot = Posts::where('posts_status', '1')->orderby('viewer', 'desc')->limit('5')->get();
        // $menu = Menu::orderby('urutan', 'asc')->orderby('name', 'asc')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();

        $footer = InseoHelper::footer();
        
        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        return View('webprofile.front.archive', compact('data', 'categories', 'hot', 'menu', 'footer', 'widget_right', 'widget_left'))->withTitle('Agenda');
    }

    public function info($title)
    {
        // $newtitle = str_replace('-', ' ', $title);
        $setting = InseoHelper::setting();
        $data = Info::where('slug', $title)->first();
        $resend = Posts::where('posts_status', '1')->orderby('post_date', 'desc')->limit('5')->get();
        // $menu = Menu::orderby('urutan', 'asc')->orderby('name', 'asc')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();
        $hot = Posts::where('posts_status', '1')->orderby('viewer', 'desc')->limit('5')->get();
        $categories = Categories::where('is_active', '1')->get();

        $footer = InseoHelper::footer();

        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        $viewer = Info::findOrFail($data->id);
        $datain['viewer'] = (int)$data->viewer+1;
        $viewer->update($datain);

        return View('webprofile.front.info', compact('data', 'resend', 'categories', 'menu', 'hot', 'footer', 'widget_right', 'widget_left'));
    }

    public function build_menu()
    {
        $data = Newmenu::select('id', 'parent', 'name', 'url', 'level', 'urutan')->where('level', '1')->orderby('urutan', 'asc')->get();

        $i = 0;
        foreach ($data as $item) {
            $menu[$i]['id'] = $item->id;
            $menu[$i]['parent'] = $item->parent;
            $menu[$i]['name'] = $item->name;
            $menu[$i]['url'] = $item->url;
            $menu[$i]['level'] = $item->level;
            $menu[$i]['urutan'] = $item->urutan;
            if ($this->menu_has_child($item->parent)) {
                $menu[$i]['child'] = $this->menu_get_child($item->id);
            }
            $i++;
        }
        // dd($menu);
        return $menu;
    }

    public function menu_has_child($parentid)
    {
        $data = Newmenu::where('parent', $parentid)->count();

        if ($data > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function menu_get_child($parentid)
    {
        $cdata = Newmenu::select('id', 'parent', 'name', 'url', 'level', 'urutan')->where('parent', $parentid)->orderby('urutan', 'asc')->get();

        $i = 0;
        $cmenu = [];
        foreach ($cdata as $citem) {
            $cmenu[$i]['id'] = $citem->id;
            $cmenu[$i]['parent'] = $citem->parent;
            $cmenu[$i]['name'] = $citem->name;
            $cmenu[$i]['url'] = $citem->url;
            $cmenu[$i]['level'] = $citem->level;
            $cmenu[$i]['urutan'] = $citem->urutan;
            if ($this->menu_has_child($citem->parent)) {
                $cmenu[$i]['child'] = $this->menu_get_child($citem->id);
            }
            $i++;
        }

        return $cmenu;
    }

    public function error()
    {
        // $data = Pages::where('title', 'notfound')->first();
        $data = new Pages;
        $data->title = 'Page Not Found';
        // $menu = Menu::orderby('urutan', 'asc')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();
        // $footer = InseoHelper::footer();
        $footer = InseoHelper::footer();

        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        return View('webprofile.front.viewpage', compact('data', 'menu', 'footer', 'widget_right', 'widget_left'));
    }

    public function download()
    {
        $categoriesFile = CategoriesFile::where('is_active', 1)->orderBy('created_at', 'DESC')->with(['rFile'])->get();
        $setting = InseoHelper::setting();
        // $resend = Posts::where('posts_status', '1')->orderby('post_date', 'desc')->limit('5')->get();
        $menu = Newmenu::orderby('urutan', 'asc')->get();
        $hot = Posts::where('posts_status', '1')->orderby('viewer', 'desc')->limit('5')->get();
        $categories = Categories::where('is_active', '1')->get();

        $footer = InseoHelper::footer();

        $widget_right = Design::where('name_design', 'widget_right')->orderBy('urutan', 'ASC')->get();
        $widget_left = Design::where('name_design', 'widget_left')->orderBy('urutan', 'ASC')->get();

        $data = [
            'categoriesFile' => $categoriesFile,
            'setting' => $setting,
            'menu' => $menu,
            'hot' => $hot,
            'categories' => $categories,
            'footer' => $footer,
            'widget_right' => $widget_right,
            'widget_left' => $widget_left,
        ];

        return view('webprofile.front.viewdownload', $data);
    }

    public function downloadFile($data)
    {
        $dbfile = $this->fileRepo->find(null, $data);
        $file = "http://statik.unesa.ac.id/profileunesa_konten_statik/uploads/" . Session::get('ss_setting')['statik_konten'] . "/file/" . $dbfile->file;
        $this->fileRepo->countDownload($dbfile);

        // if ($this->fileRepo->is_url_exist($file)) {
        $filename = $dbfile->slug;
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        stream_context_set_default([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
        copy($file, $tempImage);

        return response()->download($tempImage, $filename);
        // } else {
        //     Alert::error('File tidak ditemukan');
        //     return redirect()->back();
        // }
    }
}
