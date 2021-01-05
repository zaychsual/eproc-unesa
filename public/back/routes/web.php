<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('sso', 'Sso\AuthSSOController@login');
Route::get('sso/{email}/{sessionid}', 'Sso\AuthSSOController@index');
Route::get('404', 'HomeController@pagenotfound');

Route::get('/', function () {
    header("Location: https://sso.unesa.ac.id/login");
    die();
})->middleware('guest');

//Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::view('/mail', 'emails.mail'); //BUAT TES TAMPILAN EMAIL

// Route::get('aktivasi/{id}', 'Webprofile\Backend\RekanansController@index')->name('aktivasi');;
// Route::post('aktivasi/', 'Webprofile\Backend\RekanansController@store');

Route::resource('aktivasi', 'Webprofile\Backend\AktivasiController');
// Route::post('aktivasi', 'Webprofile\Backend\RekanansController@store');

// Untuk Kirim Email ...
Route::get('/kirimemail', 'Auth\SendEmailController@index');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


// Refresh Captcha
Route::get('/refresh_captcha', 'Auth\RegisterController@refreshCaptcha')->name('refresh');

Route::get('ppti-login', 'Auth\LoginController@showLoginForm')->name('ppti-login');
Route::post('ppti-login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(["namespace" => "Webprofile\Backend"], function () {
    Route::get('selectkota/{tema}', 'SelectController@kota');
});
// Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Route Web Profile
Route::get('/', 'Webprofile\Front\FrontController@index');

Route::group(['namespace' => 'Webprofile\Front'], function () {
    Route::get('page/{id}', 'FrontController@page')->name('page');

    Route::get('post/{id}', ['as' => 'post', 'uses' => 'FrontController@post']);

    Route::get('archive', ['as' => 'archive', 'uses' => 'FrontController@archive']);
    Route::get('category/{id}', ['as' => 'category', 'uses' => 'FrontController@category']);
    Route::get('info/{id}', ['as' => 'info', 'uses' => 'FrontController@info']);
    Route::get('agenda', 'FrontController@agenda')->name('agenda');
    Route::get('error', 'FrontController@error')->name('error');
    Route::get('download', 'FrontController@download')->name('download');
    Route::get('downloadlink/{data}', 'FrontController@downloadFile')->name('downloadFile');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::group(['middleware' => 'role:admin'], function () {
        Route::group(['namespace' => 'Webprofile\Admin', 'prefix' => 'admin'], function () {
            // Route::resource('users', 'UserController');
            // Route::get('users_aktif/{id}', ['as' => 'users_aktif', 'uses' => 'UserController@user_aktif']);
            // Route::get('users_naktif/{id}', ['as' => 'users_naktif', 'uses' => 'UserController@user_naktif']);

            // Route::get('loginas/{id}', 'UserController@loginas')->name('loginas');
            // Route::resource('subdomain', 'SubdomainController');
        });
    });

    Route::group(['middleware' => 'role:admin'], function () {
        Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::resource('user', 'UsersController');
            Route::get('user_aktif/{id}', ['as' => 'user_aktif', 'uses' => 'UsersController@user_aktif']);
            Route::get('user_naktif/{id}', ['as' => 'user_naktif', 'uses' => 'UsersController@user_naktif']);
        });
    });

    Route::group(['middleware' => 'role:laman_admin_verifikator'], function () {
        Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::resource('pemiliks', 'PemiliksController');
            Route::resource('rekanans', 'RekanansController');
            Route::resource('pengurus', 'PengurusController');
            Route::resource('peralatans', 'PeralatansController');
            Route::resource('pengalamans', 'PengalamansController');
            Route::resource('pajaks', 'PajaksController');
            Route::resource('aktas', 'AktasController');
            Route::resource('ijinusahas', 'IjinusahasController');
            Route::resource('user', 'UsersController');
            Route::resource('tenagaahlis', 'TenagaahlisController');

            Route::get('pengalaman', function () {
                return view('webprofile/backend/tenagaahlis/pengalaman');
            });

            Route::get('pendidikan', function () {
                return view('webprofile/backend/tenagaahlis/pendidikan');
            });

            Route::get('sertifikat', function () {
                return view('webprofile/backend/tenagaahlis/sertifikat');
            });

            Route::get('bahasa', function () {
                return view('webprofile/backend/tenagaahlis/bahasa');
            });
        });
    });

    Route::group(['middleware' => 'role:admin'], function () {
        Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::get('rekanansmenu', function () {
                return view('webprofile/backend/admin/rekanans/menu');
            });

            Route::get('rekanansadd', function () {
                return view('webprofile/backend/admin/rekanans/add');
            });

            Route::get('rekanansedit/{id}', ['as' => 'rekanan_edit', 'uses' => 'RekanansController@rekanan_edit']);
        });
    });

    Route::group(['middleware' => 'role:verifikator'], function () {
        Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::resource('user', 'UsersController');

            Route::resource('rekanans', 'RekanansController');
            Route::resource('listrekanans', 'ListrekanansController');
            
            Route::get('rekanans_aktif/{id}', 'RekanansController@rekanans_aktif')->name('rekanans_aktif');
            Route::get('rekanans_naktif/{id}', 'RekanansController@rekanans_naktif')->name('rekanans_naktif');

            Route::get('listrekanans_aktif/{id}', 'ListrekanansController@listrekanans_aktif')->name('listrekanans_aktif');
            Route::get('listrekanans_naktif/{id}', 'ListrekanansController@listrekanans_naktif')->name('listrekanans_naktif');
        });
    });

    Route::group(['middleware' => 'role:admin_laman'], function () {
        Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {

            Route::resource('posts', 'PostsController');

            Route::resource('user', 'UsersController');
            Route::get('user_aktif/{id}', ['as' => 'user_aktif', 'uses' => 'UsersController@user_aktif']);
            Route::get('user_naktif/{id}', ['as' => 'user_naktif', 'uses' => 'UsersController@user_naktif']);

            Route::resource('categories', 'CategoriesController');
            Route::get('categories_aktif/{id}', 'CategoriesController@categories_aktif')->name('categories_aktif');
            Route::get('categories_naktif/{id}', 'CategoriesController@categories_naktif')->name('categories_naktif');

            Route::resource('pages', 'PagesController');

            Route::resource('admin/info', 'InfoController');
            Route::get('info_aktif/{id}', 'InfoController@info_aktif')->name('info_aktif');
            Route::get('info_naktif/{id}', 'InfoController@info_naktif')->name('info_naktif');

            Route::resource('slider', 'SliderController');
            Route::get('slider_aktif/{id}', 'SliderController@slider_aktif')->name('slider_aktif');
            Route::get('slider_naktif/{id}', 'SliderController@slider_naktif')->name('slider_naktif');

            Route::resource('file', 'FileController');
            Route::get('file_aktif/{id}', 'FileController@file_aktif')->name('file_aktif');
            Route::get('file_naktif/{id}', 'FileController@file_naktif')->name('file_naktif');

            Route::resource('setting', 'SettingController');

            Route::resource('newmenu', 'NewmenuController');
            Route::post('newstorepage', 'NewmenuController@newstorepage')->name('newmenu.storepage');
            Route::get('newmenu_up/{id}', 'NewmenuController@newmenu_up')->name('newmenu_up');
            Route::get('newmenu_down/{id}', 'NewmenuController@newmenu_down')->name('newmenu_down');

            Route::get('layouts', 'DesignController@index')->name('layouts.index');
            Route::resource('footer', 'FooterController');

            Route::get('widget/create/{pos}', 'WidgetController@create')->name('widget.createc');
            Route::resource('widget', 'WidgetController');

            Route::resource('quote', 'QuoteController');

            Route::resource('gallery', 'GalleriController');
            Route::get('gallery_aktif/{id}', 'GalleriController@gallery_aktif')->name('gallery_aktif');
            Route::get('gallery_naktif/{id}', 'GalleriController@gallery_naktif')->name('gallery_naktif');

            Route::resource('body', 'BodyController');

            Route::resource('categories_file', 'CategoriesFileController');
            Route::get('categories_file_aktif/{id}', 'CategoriesFileController@categoriesfile_aktif')->name('categories_file_aktif');
            Route::get('categories_file_naktif/{id}', 'CategoriesFileController@categoriesfile_naktif')->name('categories_file_naktif');
        });
    });
});



// Route::group(['middleware' => ['auth', 'roles'], 'roles' => ['admin'] ], function () {

//     Route::get('/home', 'HomeController@index');
    
// });
