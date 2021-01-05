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
	{!! Form::open(array('url' => route('aktivasi-pokja.store'), 'method' => 'POST', 'id' => 'ppk', 'class' => 'form-horizontal','enctype="multipart/form-data"')) !!}
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

                    <div class="form-group @if ($errors->has('nama')) has-error @endif">
	                    <label class="col-md-3 control-label">Nama *</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('nama', old('nama'), array('class' => 'form-control', 'required')) }}
	                        </div>  
	                            @if ($errors->has('nama'))
	                            <span class="help-block">{{$errors->first('nomor_sertifikat')}}</span>
	                            @endif                                          
	                    </div>
                        
	                </div>

                    <div class="form-group @if ($errors->has('nohp')) has-error @endif">
	                    <label class="col-md-3 control-label">No Hp *</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-phone"></span></span>
	                            {{ Form::text('nohp', old('nohp'), array('class' => 'form-control', 'required')) }}
	                        </div>  
	                            @if ($errors->has('nohp'))
	                            <span class="help-block">{{$errors->first('nohp')}}</span>
	                            @endif                                          
	                    </div>
                        
	                </div>

	                <div class="form-group @if ($errors->has('password')) has-error @endif">                       
                        <label class="col-md-3 control-label">Password **</label>
                        <div class="col-md-9 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                {{ Form::password('password', array('class' => 'form-control', 'required')) }}
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
                                {{ Form::password('password_confirmation', array('class' => 'form-control', 'required')) }}
                            </div>  
                            @if ($errors->has('password_confirmation'))          
                            <span class="help-block">{{$errors->first('password_confirmation')}}</span>
                            @endif 
                        </div>
                    </div>

	                <div class="form-group @if ($errors->has('nomor_sertifikat')) has-error @endif">
	                    <label class="col-md-3 control-label">Nomor Sertifikat *</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
	                            {{ Form::text('nomor_sertifikat', old('nomor_sertifikat'), array('class' => 'form-control', 'required')) }}
	                        </div>  
	                            @if ($errors->has('nomor_sertifikat'))
	                            <span class="help-block">{{$errors->first('nomor_sertifikat')}}</span>
	                            @endif                                          
	                    </div>
                        
	                </div>
                    <div class="form-group @if ($errors->has('file_sertifikat')) has-error @endif">
	                    <label class="col-md-3 control-label">File Sertifikat *</label>
	                    <div class="col-md-9 col-xs-12">                                            
	                        <div class="input-group">
	                            <span class="input-group-addon"><span class="fa fa-file"></span></span>
	                            {{ Form::file('file_sertifikats', array('class'=>'fileinput btn-danger', 'id'=>'uploadImage', 'data-filename-placement'=>'inside', 'title'=>'Upload')) }}
	                        </div>  
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
        $('.jenis_pengadaan').select2();
        $('.provinsi_id').select2();
        $('.kota_id').select2();
        $('.is_kantor_cabang').select2();
    });
</script>
{{Html::script('js/kota.js')}}
@stop
