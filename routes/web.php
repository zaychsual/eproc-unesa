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
Route::get('Login', 'HomeController@Login');

Route::get('/', function () {
    header('Location: https://sso.unesa.ac.id/login');
    die();
})->middleware('guest');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Refresh Captcha
Route::get('/refresh_captcha', 'Auth\RegisterController@refreshCaptcha')->name('refresh');
Route::get('eproc-login', 'Auth\LoginController@showLoginForm')->name('eproc-login');
Route::post('eproc-login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::group(['namespace' => "Webprofile\Backend"], function () {
    Route::get('selectkota/{tema}', 'SelectController@kota');
});

// Route Web Profile
Route::get('/', 'Webprofile\Front\FrontController@index');

//Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::view('/mail', 'emails.mail'); //BUAT TES TAMPILAN EMAIL

// Route::get('aktivasi/{id}', 'Webprofile\Backend\RekanansController@index')->name('aktivasi');;
// Route::post('aktivasi/', 'Webprofile\Backend\RekanansController@store');

Route::resource('aktivasi', 'Webprofile\Backend\AktivasiController');
Route::resource('aktivasi-ppk', 'Webprofile\Backend\AktivasiPpkController');
Route::resource('aktivasi-pejabat-pengadaan', 'Webprofile\Backend\AktivasiPejabatPengadaanController');
Route::resource('aktivasi-pengendali-kualitas', 'Webprofile\Backend\AktivasiPengendaliKualitasController');
Route::resource('aktivasi-pokja', 'Webprofile\Backend\AktivasiPokjaController');
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

Route::get('vms-login', 'Auth\LoginController@showLoginForm')->name('vms-login');
Route::post('vms-login', 'Auth\LoginController@login');
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
    Route::get('informasi', 'FrontController@informasi')->name('informasi');
    Route::get('error', 'FrontController@error')->name('error');
    Route::get('download', 'FrontController@download')->name('download');
    Route::get('downloadlink/{data}', 'FrontController@downloadFile')->name('downloadFile');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::group(['middleware' => 'role:admin'], function () {
        Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::get('/user/ka-ukpbj','UsersController@listUkpbj')->name('user.ka-ukpbj');
            Route::get('/user/unit-kerja','UsersController@listUnitKerja')->name('user.unit-kerja');
            Route::get('/user/create-unitkerja','UsersController@createUnitKerja')->name('user.create-unitkerja');
            Route::get('/user/edit-unitkerja/{any}','UsersController@editUnitKerja')->name('user.edit-unitkerja');
            Route::post('/user/store-unitkerja','UsersController@storeUnitKerja')->name('user.store-unitkerja');
            Route::post('/user/update-unitkerja','UsersController@updateUnitKerja')->name('user.update-unitkerja');
            Route::post('/user/destroy-unitkerja/{any}','UsersController@destroyUnitKerja')->name('user.destroy-unitkerja');
            Route::resource('user', 'UsersController');
            Route::get('user_aktif/{id}', ['as' => 'user_aktif', 'uses' => 'UsersController@user_aktif']);
            Route::get('user_naktif/{id}', ['as' => 'user_naktif', 'uses' => 'UsersController@user_naktif']);
    
            Route::get('rekanansmenu', function () {
                return view('webprofile/backend/admin/rekanans/menu');
            });
    
            Route::get('rekanansadd', function () {
                return view('webprofile/backend/admin/rekanans/add');
            });
    
            Route::get('rekanansedit/{id}', ['as' => 'rekanan_edit', 'uses' => 'RekanansController@rekanan_edit']);
    
            //ppk
            Route::get('/ppk/validate-ppk','PpkController@validatePpk')->name('ppk.validate-ppk');
            Route::get('/ppk/list-validate','PpkController@listValidate')->name('ppk.list-validate');
            Route::resource('ppk', 'PpkController');
            //pengendali kualitas
            Route::get('/pengendali-kualitas/validate-pengendali','PengendaliKualitasController@validatePengendali')->name('pengendali-kualitas.validate-pengendali');
            Route::get('/pengendali-kualitas/list-validate','PengendaliKualitasController@listValidate')->name('pengendali-kualitas.list-validate');
            Route::resource('pengendali-kualitas', 'PengendaliKualitasController');
            //pejabat pengadaan
            Route::get('/pejabat-pengadaan/validate-pejabat','PejabatPengadaanController@validatePejabat')->name('pejabat-pengadaan.validate-pejabat');
            Route::get('/pejabat-pengadaan/list-validate','PejabatPengadaanController@listValidate')->name('pejabat-pengadaan.list-validate');
            Route::resource('pejabat-pengadaan', 'PejabatPengadaanController');
            //pokja
            Route::get('/pokja/validate-pokja','PokjaController@adminValidatePokja')->name('pokja.validate-pokja');
            Route::get('/pokja/list-validate','PokjaController@listValidate')->name('pokja.list-validate');
            Route::resource('pokja', 'PokjaController');
        });
    });
});


Route::group(['middleware' => 'role:laman_admin'], function () {
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
        Route::get('pendidikans', function () {
            return view('webprofile/backend/tenagaahlis/pendidikan');
        });
        Route::get('sertifikats', function () {
            return view('webprofile/backend/tenagaahlis/sertifikat');
        });
        Route::get('bahasas', function () {
            return view('webprofile/backend/tenagaahlis/bahasa');
        });
    });

    Route::group(['namespace' => 'Procurement\Tender', 'prefix' => 'procurement'], function () {
        Route::resource('pakets', 'PaketsController');
        Route::resource('paketanggarans', 'PaketanggaransController');
        Route::resource('paketlokasis', 'PaketlokasisController');
        Route::resource('tenders', 'TendersController');
        Route::resource('tenderjadwal', 'TenderjadwalController');
        Route::resource('tahaps', 'TahapsController');
        //inbox
        Route::get('/inbox','AllLogcontroller@index')->name('inbox.index');
        Route::get('/log-akses','AllLogcontroller@logLogin')->name('log.index');
        Route::get('/inbox/{any}','AllLogcontroller@getDataInbox')->name('inbox.read');
    });
});

Route::group(['middleware' => 'role:laman'], function () {
    Route::group(['namespace' => 'Procurement\Tender', 'prefix' => 'procurement'], function () {
        Route::resource('listpakets', 'ListpaketsController');
        Route::resource('listpaket', 'ListpaketController');
        Route::resource('penawaran', 'PenawaranController');
        Route::get('/penawaran/input-kualifikasi/{id}','PenawaranController@inputKualifikasi')->name('penawaran.input-kualifikasi');
        Route::get('/penawaran/input-penawaran/{id}','PenawaranController@inputPenawaran')->name('penawaran.input-penawaran');
        Route::post('/penawaran/store-data-kualifikasi','PenawaranController@store_data_kualifikasi')->name('penawaran.store-data-kualifikasi');
        Route::post('/penawaran/store-data-penawaran','PenawaranController@store_data_penawaran')->name('penawaran.store-data-penawaran');

        Route::get('paket-non-tender','ListpaketController@nontenders')->name('paket-non-tender');
        Route::post('store-ikuti-paket','ListpaketController@store_ikuti_paket')->name('store-ikuti-paket');

        Route::post('register-paket', 'ListpaketsController@register')->name('paket.register');

        //paket baru 
        Route::post('/paket-baru/store-ikut-paket','RekananPaketBaruController@storeIkutPaket')->name('paket-baru.store-ikut-paket');
        Route::get('/paket-baru/show-paket/{id}/{is_tender}','RekananPaketBaruController@showPaket')->name('paket-baru.show-paket');
        Route::resource('paket-baru', 'RekananPaketBaruController');

        //tender
        Route::get('/laman-tender/download/{id}','RekananPenawaranTenderController@downloadDokumenPemilihan')->name('laman-tender.download');
        Route::get('/laman-tender/input-kualifikasi/{paket_id}','RekananPenawaranTenderController@inputKualifikasi')->name('laman-tender.input-kualifikasi');
        Route::post('/laman-tender/store-pertanyaan','RekananPenawaranTenderController@storePertanyaan')->name('laman-tender.store-pertanyaan');
        Route::post('/laman-tender/store-data-kualifikasi','RekananPenawaranTenderController@storeDataKualifikasi')->name('laman-tender.store-data-kualifikasi');
        Route::post('/laman-tender/store-data-penawaran','RekananPenawaranTenderController@storeDataPenawaran')->name('laman-tender.store-data-penawaran');
        Route::get('/laman-tender/input-penawaran/{paket_id}','RekananPenawaranTenderController@inputPenawaran')->name('laman-tender.input-penawaran');
        Route::resource('laman-tender','RekananPenawaranTenderController');

        //non tender
        Route::get('/laman-nontender/input-penawaran/{paket_id}','RekananPenawaranNonTenderController@inputPenawaran')->name('laman-nontender.input-penawaran');
        Route::get('/laman-nontender/kirim-penawaran/{paket_id}','RekananPenawaranNonTenderController@kirimPenawaran')->name('laman-nontender.kirim-penawaran');
        Route::get('/laman-nontender/kirim-penawaran-pbb/{paket_id}','RekananPenawaranNonTenderController@kirimPenawaranPbb')->name('laman-nontender.kirim-penawaran-pbb');
        Route::post('/laman-nontender/store-data-penawaran','RekananPenawaranNonTenderController@storeDataPenawaran')->name('laman-nontender.store-data-penawaran');
        Route::post('/laman-nontender/store-kirim-penawaran','RekananPenawaranNonTenderController@storeDataPenawaranPl')->name('laman-nontender.store-kirim-penawaran');
        Route::post('/laman-nontender/store-kirim-penawaran-pbb','RekananPenawaranNonTenderController@storeDataPenawaranPbb')->name('laman-nontender.store-kirim-penawaran-pbb');
        Route::resource('laman-nontender', 'RekananPenawaranNonTenderController');

        //inbox
        Route::get('/inbox','AllLogcontroller@index')->name('inbox.index');
        Route::get('/log-akses','AllLogcontroller@logLogin')->name('log.index');
        Route::get('/inbox/{any}','AllLogcontroller@getDataInbox')->name('inbox.read');
    });

        Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::resource('user', 'UsersController');
        });
});

Route::group(['middleware' => 'role:pokja'], function () {
    Route::group(['namespace' => 'Procurement\Tender', 'prefix' => 'procurement'], function () {
        // pengadaan list
        Route::get('pembelian-langsung','ListPengadaanController@index')->name('pembelian-langsung');
        Route::get('e-purchasing','ListPengadaanController@e_purchasing')->name('e-purchasing');
        Route::get('quotation','ListPengadaanController@quotation')->name('quotation');
        Route::get('tender','ListPengadaanController@tender')->name('tender');
        Route::get('penunjukan-langsung','ListPengadaanController@penunjukan_langsung')->name('penunjukan-langsung');
        Route::get('pembelian-barang-bekas','ListPengadaanController@pembelian_barang_bekas')->name('pembelian-barang-bekas');
        Route::get('show-paket/{id}','ListPengadaanController@show')->name('show-paket');
        Route::get('input-persyaratan-kualifikasi/{paket_id}','ListPengadaanController@input_kualifikasi')->name('input-persyaratan-kualifikasi');
        Route::get('input-persyaratan-dokumen/{paket_id}','ListPengadaanController@input_syarat_dokumen')->name('input-persyaratan-dokumen');
        Route::get('upload-dokumen-pemilihan/{paket_id}','ListPengadaanController@upload_dok_pemilihan')->name('upload-dokumen-pemilihan');
        Route::get('pilih-rekanan/{paket_id}','ListPengadaanController@pilih_rekanan')->name('pilih-rekanan');
        Route::get('detail-penawaran-harga/{paket_id}/{rekanan_id}','ListPengadaanController@detailhargapenawaran')->name('detail-penawaran-harga');
        Route::get('detail-surat-penawaran/{paket_id}/{rekanan_id}','ListPengadaanController@detailsuratpenawaran')->name('detail-surat-penawaran');
        Route::get('detail-kualifikasi/{paket_id}/{rekanan_id}','ListPengadaanController@detailkualifikasi')->name('detail-kualifikasi');
        Route::get('set-pemenang/{paket_id}','ListPengadaanController@penetapanPemenang')->name('set-pemenang');

        //post data pengadaan
        Route::post('store-kualifikasi','ListPengadaanController@store_kualifikasi')->name('store-kualifikasi');
        Route::post('store-masa-berlaku','ListPengadaanController@store_masa_berlaku')->name('store-masa-berlaku');
        Route::post('store-jadwal-pengadaans','ListPengadaanController@store_jadwal_pengadaans')->name('store-jadwal-pengadaans');
        Route::post('store-dokumen-pemilihan','ListPengadaanController@store_dokumen_pemilihan')->name('store-dokumen-pemilihan');
        Route::post('store-pemilihan-rekanan','ListPengadaanController@store_pemilihan_rekanan')->name('store-pemilihan-rekanan');
        Route::post('store-approval-pokja','ListPengadaanController@store_approval')->name('store-approval-pokja');
        Route::post('store-pemenang','ListPengadaanController@storePemenang')->name('store-pemenang');
        Route::post('store-syarat-dok','ListPengadaanController@store_syarat_dokumen')->name('store-syarat-dok');
        

        //evaluasi
        Route::resource('evaluasi','EvaluasiController');
        Route::get('/evaluasi/proses/{paket_id}/{rekanan_id}/{is_tender}','EvaluasiController@proses')->name('evaluasi.proses');
        // Route::get('/evaluasi/')

        //verifikasi 
        Route::resource('verifikasi','VerifikasiController');
        Route::get('/verifikasi/proses/{paket_id}/{rekanan_id}','VerifikasiController@proses')->name('verifikasi.proses');

        //daftar paket
        Route::resource('pokjadaftarpaket', 'PokjaDaftarPaketController');

        //tender 
        Route::get('/tender/create-tender/{paket_id}','TendersController@create')->name('tender.create-tender');
        Route::get('/tender/edit-pengadaan/{paket_id}','TendersController@editPengadaan')->name('tender.edit-pengadaan');
        Route::post('/tender/store-edit-pengadaan','TendersController@storeEditPengadaan')->name('tender.store-edit-pengadaan');
        Route::get('/tender/create-jadwal/{paket_id}','TendersController@createJadwalTender')->name('tender.create-jadwal');
        Route::post('/tender/store-jadwal-tender','TendersController@storeJadwalTender')->name('tender.store-jadwal-tender');
        Route::get('/tender/create-dokumen-penawaran/{paket_id}','TendersController@createDokumenPenawaran')->name('tender.create-dokumen-penawaran');
        Route::post('/tender/store-dok-penawaran','TendersController@storeDokPenawaran')->name('tender.store-dok-penawaran');
        Route::get('/tender/create-kualifikasi/{paket_id}','TendersController@createKualifikasi')->name('tender.create-kualifikasi');
        Route::post('/tender/store-kualifikasi','TendersController@storeKualifikasi')->name('tender.store-kualifikasi');
        Route::get('/tender/pilih-rekanan/{paket_id}','TendersController@chooseRekanan')->name('tender.pilih-rekanan');
        Route::get('/tender/create-dok-pemilihan/{paket_id}','TendersController@createDokPemilihan')->name('tender.create-dok-pemilihan');
        Route::post('/tender/store-pemilihan-rekanan','TendersController@storePemilihanRekanan')->name('tender.store-pemilihan-rekanan');
        Route::post('/tender/store--dok-pemilihan','TendersController@storeDokPemilihan')->name('tender.store-dok-pemilihan');
        Route::post('/tender/store-approval-pokja','TendersController@storeApproval')->name('tender.store-approval-pokja');
        Route::post('/tender/store-pembukaan','TendersController@storePembukaan')->name('tender.store-pembukaan');
        Route::post('/tender/store-jawaban','TendersController@storeJawaban')->name('tender.store-jawaban');
        Route::post('/tender/store-dokumen-pemilihan','TendersController@storeDokPemilihan')->name('tender.store-dokumen-pemilihan');
        Route::get('/tender/evaluasi/{paket_id}/{rekanan_id}','TendersController@createEvaluasi')->name('tender.evaluasi');
        Route::post('/tender/store-evaluasi','TendersController@storeEvaluasi')->name('tender.store-evaluasi');
        Route::get('/tender/create-pemenang/{paket_id}/','TendersController@createPemenang')->name('tender.create-pemenang');
        Route::post('/tender/store-pemenang','TendersController@storePemenang')->name('tender.store-pemenang');
        Route::get('/tender/create-negoisasi/{paket_id}','TendersController@createNegoisasi')->name('tender.create-negoisasi');
        Route::post('/tender/store-negoisasi','TendersController@storeNegoisasi')->name('tender.store-negoisasi');
        Route::post('/tender/tender-ulang','TendersController@storeTenderUlang')->name('tender.tender-ulang');

        //tender prakualifikasi
        Route::get('/tender/create-tender-pra/{paket_id}','TenderPraController@createPra')->name('tender.create-tender-pra');
        Route::get('/tender/pra-pilih-rekanan/{paket_id}','TenderPraController@createRekanan')->name('tender.pra-pilih-rekanan');
        Route::get('/tender/pra-create-kualifikasi/{paket_id}','TenderPraController@createKualifikasi')->name('tender.pra-create-kualifikasi');
        Route::post('/tender/pra-store-pemilihan-rekanan','TenderPraController@storePemilihanRekanan')->name('tender.pra-store-pemilihan-rekanan');

        //quotation 
        Route::get('/quotation/create-quotation/{paket_id}','QuotationController@create')->name('quotation.create-penunjukan');
        Route::get('/quotation/edit-pengadaan/{paket_id}','QuotationController@editPengadaan')->name('quotation.edit-pengadaan');
        Route::post('/quotation/store-edit-pengadaan','QuotationController@storeEditPengadaan')->name('quotation.store-edit-pengadaan');
        Route::get('/quotation/create-jadwal/{paket_id}','QuotationController@createJadwalPenunjukan')->name('quotation.create-jadwal');
        Route::post('/quotation/store-jadwal','QuotationController@storeJadwalPenunjukan')->name('quotation.store-jadwal');
        Route::get('/quotation/create-dokumen-penawaran/{paket_id}','QuotationController@createDokumenPenawaran')->name('quotation.create-dokumen-penawaran');
        Route::post('/quotation/store-dok-penawaran','QuotationController@storeDokPenawaran')->name('quotation.store-dok-penawaran');
        Route::get('/quotation/create-kualifikasi/{paket_id}','QuotationController@createKualifikasi')->name('quotation.create-kualifikasi');
        Route::post('/quotation/store-kualifikasi','QuotationController@storeKualifikasi')->name('quotation.store-kualifikasi');
        Route::get('/quotation/pilih-rekanan/{paket_id}','QuotationController@chooseRekanan')->name('quotation.pilih-rekanan');
        Route::get('/quotation/create-dok-pemilihan/{paket_id}','QuotationController@createDokPemilihan')->name('quotation.create-dok-pemilihan');
        Route::post('/quotation/store-pemilihan-rekanan','QuotationController@storePemilihanRekanan')->name('quotation.store-pemilihan-rekanan');
        Route::post('/quotation/store--dok-pemilihan','QuotationController@storeDokPemilihan')->name('quotation.store-dok-pemilihan');
        Route::post('/quotation/store-approval-pokja','QuotationController@storeApproval')->name('quotation.store-approval-pokja');
        Route::post('/quotation/store-pembukaan','QuotationController@storePembukaan')->name('quotation.store-pembukaan');
        Route::post('/quotation/store-jawaban','QuotationController@storeJawaban')->name('quotation.store-jawaban');
        Route::post('/quotation/store-dokumen-pemilihan','QuotationController@storeDokPemilihan')->name('quotation.store-dokumen-pemilihan');
        Route::get('/quotation/evaluasi/{paket_id}/{rekanan_id}','QuotationController@createEvaluasi')->name('quotation.evaluasi');
        Route::post('/quotation/store-evaluasi','QuotationController@storeEvaluasi')->name('quotation.store-evaluasi');
        Route::get('/quotation/create-pemenang/{paket_id}/','QuotationController@createPemenang')->name('quotation.create-pemenang');
        Route::get('/quotation/create-rekanan/{paket_id}/','QuotationController@createRekanan')->name('quotation.create-rekanan');
        Route::post('/quotation/store-pemenang','QuotationController@storePemenang')->name('quotation.store-pemenang');
        Route::post('/quotation/store-rekanan','QuotationController@storeRekanan')->name('quotation.store-rekanan');
        Route::get('/quotation/create-negoisasi/{paket_id}','QuotationController@createNegoisasi')->name('quotation.create-negoisasi');
        Route::post('/quotation/store-negoisasi','QuotationController@storeNegoisasi')->name('quotation.store-negoisasi');


        //penunjukan langsung 
        Route::get('/penunjukan-langsung/create-penunjukan/{paket_id}','PenunjukanLangsungController@create')->name('penunjukan-langsung.create-penunjukan');
        Route::get('/penunjukan-langsung/edit-pengadaan/{paket_id}','PenunjukanLangsungController@editPengadaan')->name('penunjukan-langsung.edit-pengadaan');
        Route::post('/penunjukan-langsung/store-edit-pengadaan','PenunjukanLangsungController@storeEditPengadaan')->name('penunjukan-langsung.store-edit-pengadaan');
        Route::get('/penunjukan-langsung/create-jadwal/{paket_id}','PenunjukanLangsungController@createJadwalPenunjukan')->name('penunjukan-langsung.create-jadwal');
        Route::post('/penunjukan-langsung/store-jadwal','PenunjukanLangsungController@storeJadwalPenunjukan')->name('penunjukan-langsung.store-jadwal');
        Route::get('/penunjukan-langsung/create-dokumen-penawaran/{paket_id}','PenunjukanLangsungController@createDokumenPenawaran')->name('penunjukan-langsung.create-dokumen-penawaran');
        Route::post('/penunjukan-langsung/store-dok-penawaran','PenunjukanLangsungController@storeDokPenawaran')->name('penunjukan-langsung.store-dok-penawaran');
        Route::get('/penunjukan-langsung/create-kualifikasi/{paket_id}','PenunjukanLangsungController@createKualifikasi')->name('penunjukan-langsung.create-kualifikasi');
        Route::post('/penunjukan-langsung/store-kualifikasi','PenunjukanLangsungController@storeKualifikasi')->name('penunjukan-langsung.store-kualifikasi');
        Route::get('/penunjukan-langsung/pilih-rekanan/{paket_id}','PenunjukanLangsungController@chooseRekanan')->name('penunjukan-langsung.pilih-rekanan');
        Route::get('/penunjukan-langsung/create-dok-pemilihan/{paket_id}','PenunjukanLangsungController@createDokPemilihan')->name('penunjukan-langsung.create-dok-pemilihan');
        Route::post('/penunjukan-langsung/store-pemilihan-rekanan','PenunjukanLangsungController@storePemilihanRekanan')->name('penunjukan-langsung.store-pemilihan-rekanan');
        Route::post('/penunjukan-langsung/store--dok-pemilihan','PenunjukanLangsungController@storeDokPemilihan')->name('penunjukan-langsung.store-dok-pemilihan');
        Route::post('/penunjukan-langsung/store-approval-pokja','PenunjukanLangsungController@storeApproval')->name('penunjukan-langsung.store-approval-pokja');
        Route::post('/penunjukan-langsung/store-pembukaan','PenunjukanLangsungController@storePembukaan')->name('penunjukan-langsung.store-pembukaan');
        Route::post('/penunjukan-langsung/store-jawaban','PenunjukanLangsungController@storeJawaban')->name('penunjukan-langsung.store-jawaban');
        Route::post('/penunjukan-langsung/store-dokumen-pemilihan','PenunjukanLangsungController@storeDokPemilihan')->name('penunjukan-langsung.store-dokumen-pemilihan');
        Route::get('/penunjukan-langsung/evaluasi/{paket_id}/{rekanan_id}','PenunjukanLangsungController@createEvaluasi')->name('penunjukan-langsung.evaluasi');
        Route::post('/penunjukan-langsung/store-evaluasi','PenunjukanLangsungController@storeEvaluasi')->name('penunjukan-langsung.store-evaluasi');
        Route::get('/penunjukan-langsung/create-pemenang/{paket_id}/','PenunjukanLangsungController@createPemenang')->name('penunjukan-langsung.create-pemenang');
        Route::get('/penunjukan-langsung/create-rekanan/{paket_id}/','PenunjukanLangsungController@createRekanan')->name('penunjukan-langsung.create-rekanan');
        Route::post('/penunjukan-langsung/store-pemenang','PenunjukanLangsungController@storePemenang')->name('penunjukan-langsung.store-pemenang');
        Route::post('/penunjukan-langsung/store-rekanan','PenunjukanLangsungController@storeRekanan')->name('penunjukan-langsung.store-rekanan');
        Route::get('/penunjukan-langsung/create-negoisasi/{paket_id}','PenunjukanLangsungController@createNegoisasi')->name('penunjukan-langsung.create-negoisasi');
        Route::post('/penunjukan-langsung/store-negoisasi','PenunjukanLangsungController@storeNegoisasi')->name('penunjukan-langsung.store-negoisasi');

        Route::get('/pembelian-barang-bekas/create-ba-negoisasi/{paket_id}','PembelianBarangBekasController@createBaNegoisasi')->name('pembelian-barang-bekas.create-ba-negoisasi');
        Route::get('/pembelian-barang-bekas/create-klarifikasi/{paket_id}','PembelianBarangBekasController@createKlarifikasi')->name('pembelian-barang-bekas.create-klarifikasi');
        Route::get('/pembelian-barang-bekas/view-klarifikasi/{paket_id}','PembelianBarangBekasController@viewKlarifikasi')->name('pembelian-barang-bekas.view-klarifikasi');
        Route::get('/pembelian-barang-bekas/print-ba-negoisasi/{id}','PembelianBarangBekasController@printBaNegoisasi')->name('pembelian-barang-bekas.print-ba-negoisasi');
        Route::get('/pembelian-barang-bekas/create-surat-pesanan/{paket_id}','PembelianBarangBekasController@createSuratPesanan')->name('pembelian-barang-bekas.create-surat-pesanan');
        Route::get('/pembelian-barang-bekas/create/{paket_id}','PembelianBarangBekasController@create')->name('pembelian-barang-bekas.create');
        Route::get('/pembelian-barang-bekas/create-rekanan/{paket_id}','PembelianBarangBekasController@createRekanan')->name('pembelian-barang-bekas.create-rekanan');
        Route::get('/pembelian-barang-bekas/create-rekanan-input/{paket_id}','PembelianBarangBekasController@createRekananInput')->name('pembelian-barang-bekas.create-rekanan-input');
        Route::get('/pembelian-barang-bekas/create-negoisasi/{paket_id}/{rekanan_id}','PembelianBarangBekasController@createNegoisasi')->name('pembelian-barang-bekas.create-negoisasi');
        Route::get('/pembelian-barang-bekas/create-evaluasi/{paket_id}/{rekanan_id}','PembelianBarangBekasController@createEvaluasi')->name('pembelian-barang-bekas.create-evaluasi');
        Route::post('/pembelian-barang-bekas/store-rekanan-input','PembelianBarangBekasController@storeRekananInput')->name('pembelian-barang-bekas.store-rekanan-input');
        Route::post('/pembelian-barang-bekas/store-rekanan','PembelianBarangBekasController@storeRekanan')->name('pembelian-barang-bekas.store-rekanan');
        Route::post('/pembelian-barang-bekas/store-negoisasi','PembelianBarangBekasController@storeNegoisasi')->name('pembelian-barang-bekas.store-negoisasi');
        Route::post('/pembelian-barang-bekas/store-undangan','PembelianBarangBekasController@storeUndangan')->name('pembelian-barang-bekas.store-undangan');
        Route::post('/pembelian-barang-bekas/store-pemilihan-rekanan','PembelianBarangBekasController@storePemilihanRekanan')->name('pembelian-barang-bekas.store-pemilihan-rekanan');
        Route::post('/pembelian-barang-bekas/evaluasi-store','PembelianBarangBekasController@storeEvaluasi')->name('pembelian-barang-bekas.evaluasi-store');
        Route::post('/pembelian-barang-bekas/store-ba-negoisasi','PembelianBarangBekasController@storeBap')->name('pembelian-barang-bekas.store-ba-negoisasi');
        Route::post('/pembelian-barang-bekas/store-klarifikasi','PembelianBarangBekasController@storeKlarifikasi')->name('pembelian-barang-bekas.store-klarifikasi');

        // Master
        Route::resource('tahaps'           ,'TahapsController');
        Route::resource('statuss'          ,'StatussController');
        Route::resource('pemenangs'        ,'PemenangsController');
        Route::resource('jenispengadaans'  ,'JenisPengadaansController');
        Route::resource('pemilihans'       ,'PemilihansController');
        Route::resource('kualifikasis'     ,'KualifikasisController');
        Route::resource('dokumens'         ,'DokumensController');
        Route::resource('evaluasis'        ,'EvaluasisController');
        Route::resource('jeniskontraks'    ,'JenisKontraksController');
        Route::resource('satuankerjas'     ,'SatuanKerjasController');
        Route::resource('klpds'            ,'KlpdsController');
        Route::resource('tahuns'           ,'TahunsController');
        Route::resource('rekanansnonaktif' ,'RekanansNonAktifController');
        Route::resource('rekanansaktif'    ,'RekanansAktifController');
        Route::resource('Logbook'          ,'LogbookController');
        Route::resource('sumberdanas'       ,'SumberDanasController');
        Route::resource('metodekualifikasis','MetodeKualifikasisController');


        //paket
        Route::resource('pakets', 'PaketsController');
        // Route::get('spk', 'PaketsController@showSPK')->name('spk');
        Route::get('tambah-beli-langsung', 'PaketsController@beliLangsung')->name('tambah-beli-langsung');
        Route::post('post-beli-langsung', 'PaketsController@postBeliLangsung')->name('post-beli-langsung');
        Route::get('tambah-epurchase', 'PaketsController@epurchase')->name('tambah-epurchase');
        Route::post('post-epurchase', 'PaketsController@postEpurchase')->name('post-epurchase');
        Route::get('tambah-quotation', 'PaketsController@quotation')->name('tambah-quotation');
        Route::post('post-quotation', 'PaketsController@postQuotation')->name('post-quotation');
        Route::get('tambah-tunjuk-langsung', 'PaketsController@tunjukLangsung')->name('tambah-tunjuk-langsung');
        Route::post('post-tunjuk-langsung', 'PaketsController@postTunjukLangsung')->name('post-tunjuk-langsung');
        Route::get('tambah-beli-bekas', 'PaketsController@beliBekas')->name('tambah-beli-bekas');
        Route::post('post-beli-bekas', 'PaketsController@postBeliBekas')->name('post-beli-bekas');
        

        //SPK
        Route::resource('spk', 'SPKController');
        Route::get('create-spk/{any}', 'SPKController@create')->name('e-kontrak.create-spk');
        Route::get('print-spk/{any}', 'SPKController@PrintSPK')->name('e-kontrak.print-spk');

        //Action SPK

        Route::post('', 'PaketsController@postBeliLangsung')->name('post-beli-langsung');
        Route::get('sumberdana', function () {
           return view('procurement/tender/pakets/sumberdana');
        });

        Route::get('lokasi', 'PaketsController@lokasiPage');
        Route::resource('paketanggarans', 'PaketanggaransController');
        Route::resource('paketlokasis', 'PaketlokasisController');
        Route::resource('tenders', 'TendersController');
        Route::resource('tenderjadwal', 'TenderjadwalController');

        //helper
        Route::get('list-rekan', 'HelperController@detailRekanan')->name('list-rekan');

        //print
        Route::get('print_bap/{any}', 'TendersController@PrintBap')->name('tender.print-bap');

        
        //inbox
        Route::get('/inbox','AllLogcontroller@index')->name('inbox.index');
        Route::get('/log-akses','AllLogcontroller@logLogin')->name('log.index');
        Route::get('/inbox/{any}','AllLogcontroller@getDataInbox')->name('inbox.read');
    });
        Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::resource('user', 'UsersController');
        });
});

Route::group(['middleware' => 'role:pokja'], function () {
    Route::group(['namespace' => 'Procurement\Tender', 'prefix' => 'procurement'], function () {
        Route::get('/pakets/Pengecekan/{paket_id}','PaketsController@pengecekan')->name('pakets.pengecekan');
        //inbox
        Route::get('/inbox','AllLogcontroller@index')->name('inbox.index');
        Route::get('/log-akses','AllLogcontroller@logLogin')->name('log.index');
        Route::get('/inbox/{any}','AllLogcontroller@getDataInbox')->name('inbox.read');
    });
    Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
        Route::resource('user', 'UsersController');
    });
});

Route::group(['middleware' => 'role:pejabatpengadaan'], function () {
    Route::group(['namespace' => 'Procurement\Tender', 'prefix' => 'procurement'], function () {
        //daftar paket
        Route::resource('pejabatdaftarpaket', 'PejabatPaketController');

        Route::get('/pembelian-langsung/create/{paket_id}','PembelianLangsungController@create')->name('pembelian-langsung.create');
        Route::get('/pembelian-langsung/create-rekanan/{paket_id}','PembelianLangsungController@createRekanan')->name('pembelian-langsung.create-rekanan');
        Route::get('/pembelian-langsung/create-rekanan-input/{paket_id}','PembelianLangsungController@createRekananInput')->name('pembelian-langsung.create-rekanan-input');
        Route::get('/pembelian-langsung/create-negoisasi/{paket_id}/{rekanan_id}','PembelianLangsungController@createNegoisasi')->name('pembelian-langsung.create-negoisasi');
        Route::get('/pembelian-langsung/create-ba-negoisasi/{paket_id}','PembelianLangsungController@createBaNegoisasi')->name('pembelian-langsung.create-ba-negoisasi');
        Route::get('/pembelian-langsung/create-surat-pesanan/{paket_id}','PembelianLangsungController@createSuratPesanan')->name('pembelian-langsung.create-surat-pesanan');
        Route::post('/pembelian-langsung/store-rekanan-input','PembelianLangsungController@storeRekananInput')->name('pembelian-langsung.store-rekanan-input');
        Route::post('/pembelian-langsung/store-rekanan','PembelianLangsungController@storeRekanan')->name('pembelian-langsung.store-rekanan');
        Route::post('/pembelian-langsung/store-negoisasi','PembelianLangsungController@storeNegoisasi')->name('pembelian-langsung.store-negoisasi');
        Route::post('/pembelian-langsung/store-undangan','PembelianLangsungController@storeUndangan')->name('pembelian-langsung.store-undangan');
        Route::post('/pembelian-langsung/store-pemilihan-rekanan','PembelianLangsungController@storePemilihanRekanan')->name('pembelian-langsung.store-pemilihan-rekanan');

        Route::get('/pembelian-barang-bekas/create/{paket_id}','PembelianBarangBekasController@create')->name('pembelian-barang-bekas.create');
        Route::get('/pembelian-barang-bekas/create-rekanan/{paket_id}','PembelianBarangBekasController@createRekanan')->name('pembelian-barang-bekas.create-rekanan');
        Route::get('/pembelian-barang-bekas/create-rekanan-input/{paket_id}','PembelianBarangBekasController@createRekananInput')->name('pembelian-barang-bekas.create-rekanan-input');
        Route::get('/pembelian-barang-bekas/create-negoisasi/{paket_id}/{rekanan_id}','PembelianBarangBekasController@createNegoisasi')->name('pembelian-barang-bekas.create-negoisasi');
        Route::get('/pembelian-barang-bekas/create-ba-negoisasi/{paket_id}','PembelianBarangBekasController@createBaNegoisasi')->name('pembelian-barang-bekas.create-ba-negoisasi');
        Route::get('/pembelian-barang-bekas/create-surat-pesanan/{paket_id}','PembelianBarangBekasController@createSuratPesanan')->name('pembelian-barang-bekas.create-surat-pesanan');
        Route::post('/pembelian-barang-bekas/store-rekanan-input','PembelianBarangBekasController@storeRekananInput')->name('pembelian-barang-bekas.store-rekanan-input');
        Route::post('/pembelian-barang-bekas/store-rekanan','PembelianBarangBekasController@storeRekanan')->name('pembelian-barang-bekas.store-rekanan');
        Route::post('/pembelian-barang-bekas/store-negoisasi','PembelianBarangBekasController@storeNegoisasi')->name('pembelian-barang-bekas.store-negoisasi');
        Route::post('/pembelian-barang-bekas/store-undangan','PembelianBarangBekasController@storeUndangan')->name('pembelian-barang-bekas.store-undangan');
        Route::post('/pembelian-barang-bekas/store-pemilihan-rekanan','PembelianBarangBekasController@storePemilihanRekanan')->name('pembelian-barang-bekas.store-pemilihan-rekanan');

        //epurchasing
        Route::get('/epurchasing/print-ba-negoisasi/{id}','EpurchasingController@printBaNegoisasi')->name('epurchasing.print-ba-negoisasi');
        Route::get('/epurchasing/create-ba-negoisasi/{paket_id}','EpurchasingController@createBaNegoisasi')->name('epurchasing.create-ba-negoisasi');
        Route::get('/epurchasing/create/{paket_id}','EpurchasingController@create')->name('epurchasing.create');
        Route::get('/epurchasing/create-rekanan/{paket_id}','EpurchasingController@createRekanan')->name('epurchasing.create-rekanan');
        Route::get('/epurchasing/create-rekanan-input/{paket_id}','EpurchasingController@createRekananInput')->name('epurchasing.create-rekanan-input');
        Route::get('/epurchasing/create-negoisasi/{paket_id}/{rekanan_id}','EpurchasingController@createNegoisasi')->name('epurchasing.create-negoisasi');
        Route::get('/epurchasing/create-ba-negoisasi/{paket_id}','EpurchasingController@createBaNegoisasi')->name('epurchasing.create-ba-negoisasi');
        Route::get('/epurchasing/create-surat-pesanan/{paket_id}','EpurchasingController@createSuratPesanan')->name('epurchasing.create-surat-pesanan');
        Route::post('/epurchasing/store-rekanan-input','EpurchasingController@storeRekananInput')->name('epurchasing.store-rekanan-input');
        Route::post('/epurchasing/store-rekanan','EpurchasingController@storeRekanan')->name('epurchasing.store-rekanan');
        Route::post('/epurchasing/store-negoisasi','EpurchasingController@storeNegoisasi')->name('epurchasing.store-negoisasi');
        Route::post('/epurchasing/store-undangan','EpurchasingController@storeUndangan')->name('epurchasing.store-undangan');
        Route::post('/epurchasing/store-pemilihan-rekanan','EpurchasingController@storePemilihanRekanan')->name('epurchasing.store-pemilihan-rekanan');
        Route::post('/epurchasing/store-ba-negoisasi','EpurchasingController@storeBap')->name('epurchasing.store-ba-negoisasi');

        //kirim undangan
        Route::post('store-undangan-kontrak','EkontrakController@storeUndanganKontrak')->name('store-undangan-kontrak');

        //inbox
        Route::get('/inbox','InboxController@index')->name('inbox.index');
        Route::get('/inbox/{any}','InboxController@getDataInbox')->name('inbox.read');
    });
    Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::resource('user', 'UsersController');
        });
});

Route::group(['middleware' => 'role:ppk'], function () {
    Route::group(['namespace' => 'Procurement\Tender', 'prefix' => 'procurement'], function () {
        // Master
        Route::resource('tahaps'           ,'TahapsController');
        Route::resource('statuss'          ,'StatussController');
        Route::resource('pemenangs'        ,'PemenangsController');
        Route::resource('jenispengadaans'  ,'JenisPengadaansController');
        Route::resource('pemilihans'       ,'PemilihansController');
        Route::resource('kualifikasis'     ,'KualifikasisController');
        Route::resource('dokumens'         ,'DokumensController');
        Route::resource('evaluasis'        ,'EvaluasisController');
        Route::resource('jeniskontraks'    ,'JenisKontraksController');
        Route::resource('satuankerjas'     ,'SatuanKerjasController');
        Route::resource('klpds'            ,'KlpdsController');
        Route::resource('tahuns'           ,'TahunsController');
        Route::resource('rekanansnonaktif' ,'RekanansNonAktifController');
        Route::resource('rekanansaktif'    ,'RekanansAktifController');
        Route::resource('Logbook'          ,'LogbookController');
        Route::resource('sumberdanas'       ,'SumberDanasController');
        Route::resource('metodekualifikasis','MetodeKualifikasisController');


        //paket
        Route::resource('pakets', 'PaketsController');
        
        Route::get('sumberdana', function () {
           return view('procurement/tender/pakets/sumberdana');
        });

        Route::get('lokasi', 'PaketsController@lokasiPage');
        Route::resource('paketanggarans', 'PaketanggaransController');
        Route::resource('paketlokasis', 'PaketlokasisController');
        Route::resource('tenders', 'TendersController');
        Route::resource('tenderjadwal', 'TenderjadwalController');

        //ekontrak
        Route::resource('e-kontrak','EkontrakController');
        //route proses

        Route::get('/e-kontrak/proses/{paket_id}','EkontrakController@proses')->name('e-kontrak.proses');
        Route::get('/e-kontrak/sppbj/{paket_id}','EkontrakController@eSppbj')->name('e-kontrak.sppbj');
        Route::get('/e-kontrak/ringkasan-kontrak/{paket_id}','EkontrakController@ringkasanKontrak')->name('e-kontrak.ringkasan-kontrak');
        Route::get('/e-kontrak/sppbj-create/{paket_id}','EkontrakController@eSppbjCreate')->name('e-kontrak.sppbj-create');
        Route::get('/e-kontrak/create-kontrak/{paket_id}','EkontrakController@eKontrak')->name('e-kontrak.create-kontrak');
        Route::get('/e-kontrak/create-sskk/{paket_id}','EkontrakController@eKontrakSskk')->name('e-kontrak.create-sskk');
        Route::get('/e-kontrak/create-spp/{paket_id}','EkontrakController@eKontrakSpp')->name('e-kontrak.create-spp');
        Route::get('/e-kontrak/diteruskan/{paket_id}','EkontrakController@paketDiteruskan')->name('e-kontrak.diteruskan');
        
        //Pembayaran
        Route::get('pembayaran/{any}','EkontrakController@Pembayaran')->name('e-kontrak.pembayaran');
        Route::get('create-pembayaran/{any}','EkontrakController@createPembayaran')->name('e-kontrak.create-pembayaran');
        Route::post('add-pembayaran','EkontrakController@storeBap')->name('e-kontrak.store-bap');

        //route print
        Route::get('/e-kontrak/print-sppbj/{paket_id}','EkontrakController@printSppbj')->name('e-kontrak.print-sppbj');
        Route::get('/e-kontrak/print-bast/{bap_id}','EkontrakController@printBAST')->name('e-kontrak.print-bast');
        Route::get('/e-kontrak/print-bap/{bap_id}','EkontrakController@printBap')->name('e-kontrak.print-bap');
        Route::get('/e-kontrak/print-ringkasan-kontrak/{bap_id}','EkontrakController@printRingkasanKontrak')->name('e-kontrak.print-ringkasan-kontrak');

        //post kontrak
        Route::post('/e-kontrak/store-sppbj','EkontrakController@storeSppbj')->name('e-kontrak.store-sppbj');
        Route::post('/e-kontrak/store-kontrak','EkontrakController@storeKontrak')->name('e-kontrak.store-kontrak');
        Route::post('/e-kontrak/store-sskk','EkontrakController@storeSskk')->name('e-kontrak.store-sskk');
        Route::post('/e-kontrak/store-spp','EkontrakController@storeSpp')->name('e-kontrak.store-spp');
        Route::post('store-undangan-kontrak','EkontrakController@storeUndanganKontrak')->name('store-undangan-kontrak');
        Route::post('store-diteruskan','PengendaliKualitasController@storeDiteruskan')->name('store-diteruskan');
        
        //Validasi ke helper
        Route::get('/validasi-paket', 'HelperController@validasiPaket')->name('validasi-paket');

        //inbox
        Route::get('/inbox','AllLogcontroller@index')->name('inbox.index');
        Route::get('/log-akses','AllLogcontroller@logLogin')->name('log.index');
        Route::get('/inbox/{any}','AllLogcontroller@getDataInbox')->name('inbox.read');
        
    });
Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::resource('user', 'UsersController');
        });
});

 //role ka ukpbj
 Route::group(['middleware' => 'role:kaukpbj'], function () {
    Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
        Route::get('pokja-list-validate-pokja','PokjaController@listValidateKaUkpbj')->name('pokja-list-validate-pokja');
        Route::get('pokja-validate-show/{id}','PokjaController@showValidatePokja')->name('pokja-validate-show');
        Route::get('pokja-validate-pokja-kepala','PokjaController@kepalaValidatePokja')->name('pokja-validate-pokja-kepala');
        Route::resource('user', 'UsersController');

    });
    
    Route::group(['namespace' => 'Procurement\Tender', 'prefix' => 'procurement'], function () {
        Route::get('pembelian-langsung','ListPengadaanController@index')->name('pembelian-langsung');
        Route::get('e-purchasing','ListPengadaanController@e_purchasing')->name('e-purchasing');
        Route::get('quotation','ListPengadaanController@quotation')->name('quotation');
        Route::get('tender','ListPengadaanController@tender')->name('tender');
        Route::get('penunjukan-langsung','ListPengadaanController@penunjukan_langsung')->name('penunjukan-langsung');
        Route::get('pembelian-barang-bekas','ListPengadaanController@pembelian_barang_bekas')->name('pembelian-barang-bekas');
        Route::get('send-pic/{id}','ListPengadaanController@send_pic')->name('send-pic');
        Route::get('send-pic-proses','ListPengadaanController@proses_send_pic')->name('send-pic-proses');

        Route::get('get-anggota-pokja','HelperController@getPokja')->name('get-anggota-pokja');
        Route::get('get-anggota-pp','HelperController@getPengendaliKualitas')->name('get-anggota-pp');
        //inbox
        Route::get('/inbox','AllLogcontroller@index')->name('inbox.index');
        Route::get('/log-akses','AllLogcontroller@logLogin')->name('log.index');
        Route::get('/inbox/{any}','AllLogcontroller@getDataInbox')->name('inbox.read');
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

 Route::group(['middleware' => 'role:pengendalikualitas'], function () {
    // Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {

    // });
    Route::group(['namespace' => 'Procurement\Tender', 'prefix' => 'procurement'], function () {
        Route::get('checklist-pengendali/{any}','PengendaliKualitasController@createChecklist')->name('checklist.pengendalikualitas');
        Route::post('store-checklist-pengendali','PengendaliKualitasController@storeChecklist')->name('checklist.store-pengendalikualitas');
	 //inbox
        Route::get('/inbox','AllLogcontroller@index')->name('inbox.index');
        Route::get('/log-akses','AllLogcontroller@logLogin')->name('log.index');
        Route::get('/inbox/{any}','AllLogcontroller@getDataInbox')->name('inbox.read');

        //Print
        Route::get('print-checklist/{any}','PengendaliKualitasController@printeChecklist')->name('print.bbapp');
    });
    Route::group(['namespace' => 'Webprofile\Backend', 'prefix' => 'webprofile'], function () {
            Route::resource('user', 'UsersController');
        });
});