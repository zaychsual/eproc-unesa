@extends('webprofile.layouts.backend.slave')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('#')}}">Dashboard</a></li>
<li class="active"> {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')

<!-- page start-->
<div class="row">
<div class="col-md-12">
	{!! Form::open(array('url' => route('aktivasi.store'), 'method' => 'POST', 'id' => 'rekanans', 'class' => 'form-horizontal')) !!}
	{!! csrf_field() !!}

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Pendaftaran</strong> Penyedia</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">

					<div class="form-group @if ($errors->has('email')) has-error @endif">
	                    <label class="col-md-3 control-label">Email **</label>
	                    <div class="col-md-9">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-envelope"></span> {{ $data['email'] }}</span>
	                            {{ Form::hidden('email', $data['email'], array('class' => 'form-control')) }}

	                        </div>
	                            @if ($errors->has('email'))
	                            <span class="help-block">{{$errors->first('email')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

	                <div class="form-group @if ($errors->has('password')) has-error @endif">                       
                        <label class="col-md-3 control-label">Password **</label>
                        <div class="col-md-9 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                {{ Form::password('password', array('class' => 'form-control')) }}
                            </div>  
                            @if ($errors->has('password'))          
                            <span class="help-block">{{$errors->first('password')}}</span>
                            @endif 
                        </div>
                    </div>

                    <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">                       
                        <label class="col-md-3 control-label">Password Verifikasi **</label>
                        <div class="col-md-9 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                            </div>  
                            @if ($errors->has('password_confirmation'))          
                            <span class="help-block">{{$errors->first('password_confirmation')}}</span>
                            @endif 
                        </div>
                    </div>

	                <div class="form-group @if ($errors->has('nama')) has-error @endif">
	                    <label class="col-md-3 control-label">Nama Perusahaan *</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('nama', old('nama'), array('class' => 'form-control')) }}
	                        </div>  
	                            @if ($errors->has('nama'))
	                            <span class="help-block">{{$errors->first('nama')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

	                <div class="form-group @if ($errors->has('bentuk_usaha')) has-error @endif">
	                    <label class="col-md-3 col-xs-12 control-label">Bentuk Usaha</label>
	                    <div class="col-md-9 col-xs-12">                                              
	                        {{ Form::select('bentuk_usaha', $data['bentuk_usaha'], old('bentuk_usaha'), ['class' => 'form-control bentuk_usaha', 'style' => 'width: 100%;', 'id' => 'bentuk_usaha', 'placeholder' => '- Pilih Data -', 'required']) }}

	                            @if ($errors->has('bentuk_usaha'))
	                            <span class="help-block">{{$errors->first('bentuk_usaha')}}</span>
	                            @endif
	                    </div>
	                </div> 

	                <div class="form-group @if ($errors->has('alamat')) has-error @endif">
	                    <label class="col-md-3 col-xs-12 control-label">Alamat *</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        {{ Form::textarea('alamat', old('alamat'), array('class' => 'form-control')) }}
	                            @if ($errors->has('alamat'))
	                            <span class="help-block">{{$errors->first('alamat')}}</span>
	                            @endif
	                    </div>
	                </div>  

	                <div class="form-group @if ($errors->has('kode_pos')) has-error @endif">
	                    <label class="col-md-3 control-label">Kode Pos</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('kode_pos', old('kode_pos'), array('class' => 'form-control')) }}
	                        </div>  
	                            @if ($errors->has('kode_pos'))
	                            <span class="help-block">{{$errors->first('kode_pos')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

	                <div class="form-group @if ($errors->has('provinsi_id')) has-error @endif">
	                    <label class="col-md-3 col-xs-12 control-label">Provinsi</label>
	                    <div class="col-md-9 col-xs-12">
	                        {{ Form::select('provinsi_id', $data['provinsi'], old('provinsi_id'), ['class' => 'form-control provinsi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'provinsi_id', 'placeholder' => '- Pilih Data -', 'required']) }}

	                            @if ($errors->has('provinsi_id'))
	                            <span class="help-block">{{$errors->first('provinsi_id')}}</span>
	                            @endif
	                    </div>
	                </div> 

	                <div class="form-group @if ($errors->has('kota_id')) has-error @endif">
	                    <label class="col-md-3 col-xs-12 control-label">Kabupaten/Kota</label>
	                    <div class="col-md-9 col-xs-12">
	                         {{ Form::select('kota_id', [], old('kota_id'), ['class' => 'form-control kota_id', 'style' => 'width: 100%;', 'id' => 'kota_id', 'placeholder' => '- Pilih Data -', 'required']) }}

	                            @if ($errors->has('kota_id'))
	                            <span class="help-block">{{$errors->first('kota_id')}}</span>
	                            @endif
	                    </div>
	                </div> 

	                <div class="form-group @if ($errors->has('is_kantor_cabang')) has-error @endif">
	                    <label class="col-md-3 col-xs-12 control-label">Kantor Cabang?</label>
	                    <div class="col-md-9 col-xs-12"> 
	                        {{ Form::select('is_kantor_cabang', array('TIDAK' => 'Tidak', 'YA' => 'Ya'), old('is_kantor_cabang'), ['class' => 'form-control is_kantor_cabang', 'style' => 'width: 100%;', 'id' => 'is_kantor_cabang', 'placeholder' => '- Pilih Data -', 'required']) }}

	                            @if ($errors->has('is_kantor_cabang'))
	                            <span class="help-block">{{$errors->first('is_kantor_cabang')}}</span>
	                            @endif
	                    </div>
	                </div> 

				</div>

				<div class="col-md-6">
					<div class="form-group @if ($errors->has('npwp')) has-error @endif">
	                    <label class="col-md-3 control-label">NPWP *</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('npwp', old('npwp'), array('class' => 'form-control', 'id' => 'npwp')) }}
	                        </div>  
	                            @if ($errors->has('npwp'))
	                            <span class="help-block">{{$errors->first('npwp')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

	                <div class="form-group @if ($errors->has('nomor_pkp')) has-error @endif">
	                    <label class="col-md-3 control-label">Nomor Pengukuhan PKP</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('nomor_pkp', old('nomor_pkp'), array('class' => 'form-control')) }}
	                        </div>  
	                            @if ($errors->has('nomor_pkp'))
	                            <span class="help-block">{{$errors->first('nomor_pkp')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

	                <div class="form-group @if ($errors->has('telepon')) has-error @endif">
	                    <label class="col-md-3 control-label">Telepon *</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('telepon', old('telepon'), array('class' => 'form-control')) }}
	                        </div>  
	                            @if ($errors->has('telepon'))
	                            <span class="help-block">{{$errors->first('telepon')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

	                <div class="form-group @if ($errors->has('fax')) has-error @endif">
	                    <label class="col-md-3 control-label">Fax</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('fax', old('fax'), array('class' => 'form-control', 'id' => 'fax')) }}
	                        </div>  
	                            @if ($errors->has('fax'))
	                            <span class="help-block">{{$errors->first('fax')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

	                <div class="form-group @if ($errors->has('hp')) has-error @endif">
	                    <label class="col-md-3 control-label">Mobile Phone</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('hp', old('hp'), array('class' => 'form-control', 'id' => 'hp')) }}
	                        </div>  
	                            @if ($errors->has('hp'))
	                            <span class="help-block">{{$errors->first('hp')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

	                <div class="form-group @if ($errors->has('website')) has-error @endif">
	                    <label class="col-md-3 control-label">Website</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('website', old('website'), array('class' => 'form-control', 'id' => 'website')) }}
	                        </div>  
	                            @if ($errors->has('website'))
	                            <span class="help-block">{{$errors->first('website')}}</span>
	                            @endif                                          
	                    </div>
	                </div>

					<div class="form-group">
						<label class="col-md-3 control-label">Jenis Pengadaan</label>
						<div class="col-md-9 col-xs-12">                                            
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
								{{-- <select required="required" class="form-control select" name="jenis_pengadaan[]" multiple="multiple">
									@foreach ($data_jenis_pengadaan as $key => $val)
									{{old("jenis_pengadaan")}}
										<option value="{{ $val }}" @if(in_array($val, $jenis_pengadaan)) selected @endif >{{ $val }}</option>
									@endforeach
								</select> --}}
                                {{ Form::select('jenis_pengadaan[]', array('Konstruksi' => 'Konstruksi', 'Barang' => 'Barang', 'Jasa Konsultasi' => 'Jasa Konsultasi', 'Jasa Lain' => 'Jasa Lain'), old('jenis_kelamin'), ['class' => 'form-control select', 'style' => 'width: 100%;', 'id' => 'jenis_pengadaan', 'required', 'multiple' => 'multiple']) }}
							</div>  
								@if ($errors->has('website'))
								<span class="help-block">{{$errors->first('website')}}</span>
								@endif                                          
						</div>
					</div>


				</div>
				

				
			</div>
		</div>
		<div class="panel-body">
            <p>
              * Data ini harus diisi.<br>
              ** User ID akan digunakan untuk login, gunakan User ID yang mudah diingat.
            </p>
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
		<div class="panel-footer">     
            <input type="hidden" value="{{$data['id']}}" name="reqUserId">
			<button class="btn btn-info pull-right">Mendaftar</button>
        </div>
	</div>
	{!! Form::close() !!}
</div>
</div>

<!-- page end-->
@stop

@section('script')
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('ress/js/plugins/summernote/summernote.js') !!}

{{Html::script('js/jquery.mask.min.js')}}
<script>
	var urlKota = "{{url('/selectkota')}}";
	$('#npwp').mask("00.000.000.0-000.000", {placeholder: "__.___.___._-___.___"});
	$('#telepon').mask("#");
	$('#fax').mask("#");
	$('#hp').mask("#");
</script>
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.bentuk_usaha').select2();
        $('.provinsi_id').select2();
        $('.kota_id').select2();
        $('.is_kantor_cabang').select2();
    });
</script>
{{Html::script('js/kota.js')}}
@stop
