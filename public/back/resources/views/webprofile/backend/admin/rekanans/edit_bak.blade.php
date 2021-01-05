@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Ubah Kategori</li>
@stop

@section('content')
{!! Form::model($data, ['route' => ['categories.update', $data->id], 'method'=>'patch', 'class'=>'form-horizontal']) !!}
{!! csrf_field() !!}
<!-- page start-->
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Ubah</strong> Kategori</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <label class="col-md-2 control-label">Email</label>
                            <div class="col-md-4">
                                {{ Form::text('email', old('email'), array('class' => 'form-control')) }}
                                @if ($errors->has('email'))
                                <label id="login-error" class="error" for="login">{{$errors->first('email')}}</label>
                                @endif
                            </div>
    
                            <label class="col-md-2 control-label">NPWP</label>
                            <div class="col-md-4">
                                {{ Form::text('npwp', old('npwp'), array('class' => 'form-control', 'id' => 'npwp')) }}
                                @if ($errors->has('npwp'))
                                <label id="login-error" class="error" for="login">{{$errors->first('npwp')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('password')) has-error @endif">
                            <label class="col-md-2 control-label">Password</label>
                            <div class="col-md-4">
                                {{ Form::text('password', old('password'), array('class' => 'form-control')) }}
                                @if ($errors->has('password'))
                                <label id="login-error" class="error" for="login">{{$errors->first('password')}}</label>
                                @endif
                            </div>
    
                            <label class="col-md-2 control-label">Nomor Pengukuhan PKP</label>
                            <div class="col-md-4">
                                {{ Form::text('nomor_pkp', old('nomor_pkp'), array('class' => 'form-control')) }}
                                @if ($errors->has('nomor_pkp'))
                                <label id="login-error" class="error" for="login">{{$errors->first('nomor_pkp')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('verifikasi_password')) has-error @endif">
                            <label class="col-md-2 control-label">Password Verifikasi</label>
                            <div class="col-md-4">
                                {{ Form::text('verifikasi_password', old('verifikasi_password'), array('class' => 'form-control')) }}
                                @if ($errors->has('verifikasi_password'))
                                <label id="login-error" class="error" for="login">{{$errors->first('verifikasi_password')}}</label>
                                @endif
                            </div>
    
                            <label class="col-md-2 control-label">Telepon</label>
                            <div class="col-md-4">
                                {{ Form::text('telepon', old('telepon'), array('class' => 'form-control', 'id' => 'telepon')) }}
                                @if ($errors->has('telepon'))
                                <label id="login-error" class="error" for="login">{{$errors->first('telepon')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('nama')) has-error @endif">
                            <label class="col-md-2 control-label">Nama Perusahaan</label>
                            <div class="col-md-4">
                                {{ Form::text('nama', old('nama'), array('class' => 'form-control')) }}
                                @if ($errors->has('nama'))
                                <label id="login-error" class="error" for="login">{{$errors->first('nama')}}</label>
                                @endif
                            </div>
    
                            <label class="col-md-2 control-label">Fax</label>
                            <div class="col-md-4">
                                {{ Form::text('fax', old('fax'), array('class' => 'form-control', 'id' => 'fax')) }}
                                @if ($errors->has('fax'))
                                <label id="login-error" class="error" for="login">{{$errors->first('fax')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('bentuk_usaha')) has-error @endif">
                            <label class="col-md-2 control-label">Bentuk Usaha</label>
                            <div class="col-md-4">
                                {{ Form::select('bentuk_usaha', $data['bentuk_usaha'], ['class' => 'form-control', 'id'=>'bentuk_usaha', 'placeholder'=>'- Pilih -']) }}
                                @if ($errors->has('bentuk_usaha'))
                                <label id="login-error" class="error" for="login">{{$errors->first('bentuk_usaha')}}</label>
                                @endif
                            </div>
    
                            <label class="col-md-2 control-label">Mobile Phone</label>
                            <div class="col-md-4">
                                {{ Form::text('hp', old('hp'), array('class' => 'form-control', 'id' => 'hp')) }}
                                @if ($errors->has('hp'))
                                <label id="login-error" class="error" for="login">{{$errors->first('hp')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('alamat')) has-error @endif">
                            <label class="col-md-2 control-label">Alamat</label>
                            <div class="col-md-4">
                                {{ Form::text('alamat', old('alamat'), array('class' => 'form-control')) }}
                                @if ($errors->has('alamat'))
                                <label id="login-error" class="error" for="login">{{$errors->first('alamat')}}</label>
                                @endif
                            </div>
    
                            <label class="col-md-2 control-label">Website</label>
                            <div class="col-md-4">
                                {{ Form::text('website', old('website'), array('class' => 'form-control', 'id' => 'website')) }}
                                @if ($errors->has('website'))
                                <label id="login-error" class="error" for="login">{{$errors->first('website')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('kode_pos')) has-error @endif">
                            <label class="col-md-2 control-label">Kode Pos</label>
                            <div class="col-md-4">
                                {{ Form::text('kode_pos', old('kode_pos'), array('class' => 'form-control')) }}
                                @if ($errors->has('kode_pos'))
                                <label id="login-error" class="error" for="login">{{$errors->first('kode_pos')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('provinsi_id')) has-error @endif">
                            <label class="col-md-2 control-label">Provinsi</label>
                            <div class="col-md-4">
                                {{ Form::select('provinsi_id', $data['provinsi'], old('provinsi_id'), ['class' => 'form-control select', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'provinsi_id', 'placeholder' => '- Pilih Data -']) }}
                                @if ($errors->has('provinsi_id'))
                                <label id="login-error" class="error" for="login">{{$errors->first('provinsi_id')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('kota_id')) has-error @endif">
                            <label class="col-md-2 control-label">Kabupaten/Kota</label>
                            <div class="col-md-4">
                                {{ Form::select('kota_id', [], old('kota_id'), ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'kota_id', 'placeholder' => '- Pilih Data -']) }}
                                @if ($errors->has('kota_id'))
                                <label id="login-error" class="error" for="login">{{$errors->first('kota_id')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('is_kantor_cabang')) has-error @endif">
                            <label class="col-md-2 control-label">Kantor Cabang</label>
                            <div class="col-md-4">
                                {{ Form::select('is_kantor_cabang', array('TIDAK' => 'Tidak', 'YA' => 'Ya'), old('is_kantor_cabang'), ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'is_kantor_cabang', 'placeholder' => '- Pilih Data -']) }}
                                @if ($errors->has('is_kantor_cabang'))
                                <label id="login-error" class="error" for="login">{{$errors->first('is_kantor_cabang')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
    
                    
                <div style="padding-top:10px">
                    <span class="warning">*</span> Data ini harus diisi.<br/>
                    <span class="warning">**</span> User ID akan digunakan untuk login, gunakan User ID yang mudah diingat.<br/>
                    <ol style="margin: 0px;" id="persyaratan">
                        <span>1. Lengkapi persyaratan berikut ini:</span>
                        <ol type="a">
                            <li>KTP Direksi/Direktur/Pemilik Perusahaan/Pejabat yang berwenang di Perusahaan (fotokopi);</li>
                            <li><strong>NPWP</strong> Perusahaan (fotokopi);</li>
                            <li>Tanda Daftar Perusahaan <strong>(TDP)</strong>/Nomor Induk Berusaha <strong>(NIB)</strong> (fotokopi) (jika ada);</li>
                            <li>Surat Izin Usaha Perdagangan <strong>(SIUP)</strong>/Surat Izin Usaha Jasa Konstruksi <strong>(SIUJK)</strong>/izin usaha sesuai bidang masing-masing (fotokopi) (jika ada);</li>
                            <li>Akta Pendirian Perusahaan dan/atau Akta Perubahan Perusahaan terakhir (fotokopi) (jika ada);</li>
                            
                            
                        </ol>
                        <span>2. Serahkan berkas-berkas di atas ke Kantor LPSE tempat Anda mendaftar dengan membawa <strong>Dokumen Asli</strong>.</span>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-footer">
            <a href="{{URL::to('webprofile/categories')}}" class="btn btn-default pull-right">Batal</a>
                <button class="btn btn-info pull-right">Simpan</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<!-- page end-->
@stop

@section('script')
{!! Html::script('https://statik.unesa.ac.id/perpus_konten_statik/admin/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('https://statik.unesa.ac.id/perpus_konten_statik/admin/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('https://statik.unesa.ac.id/perpus_konten_statik/admin/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('https://statik.unesa.ac.id/perpus_konten_statik/admin/js/plugins/summernote/summernote.js') !!}
@stop
