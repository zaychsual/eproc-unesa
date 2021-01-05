@extends('webprofile.layouts.backend.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Edit {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

<?php
$rekanan = $data['rekanan'];
?>

@section('content')
<!-- page start-->

<div class="row">
<div class="col-md-12">
	{!! Form::model($rekanan, ['route' => ['listrekanans.update', $rekanan->id], 'method'=>'patch', 'class'=>'form-horizontal']) !!}
	{!! csrf_field() !!}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Form</strong> </h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Kode Penyedia</label>
						<div class="col-md-9 col-xs-12">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-eye"></span></span>
								{{ Form::text('kode', $rekanan['kode'], array('class' => 'form-control', 'readonly' => 'true')) }}
							</div>
							@if ($errors->has('kode'))
							<label id="login-error" class="error" for="login">{{$errors->first('kode')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Nama Perusahaan</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-eye"></span></span>
								{{ Form::text('nama', $rekanan['nama'], array('class' => 'form-control', 'readonly' => 'true')) }}
							</div>
							@if ($errors->has('nama'))
							<label id="login-error" class="error" for="login">{{$errors->first('nama')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Kode Pos</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
								{{ Form::text('kode_pos', $rekanan['kode_pos'], array('class' => 'form-control')) }}
							</div>
							@if ($errors->has('kode_pos'))
							<label id="login-error" class="error" for="login">{{$errors->first('kode_pos')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">No. Pengukuhan PKP</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
								{{ Form::text('nomor_pkp', old('nomor_pkp'), array('class' => 'form-control')) }}
							</div>
							@if ($errors->has('nomor_pkp'))
							<label id="login-error" class="error" for="login">{{$errors->first('nomor_pkp')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Provinsi</label>
						<div class="col-md-9">
                            {{ Form::select('provinsi_id', $data['provinsi'], old('provinsi_id'), ['class' => 'form-control provinsi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'provinsi_id', 'placeholder' => '- Pilih Data -']) }}
							@if ($errors->has('provinsi_id'))
							<label id="login-error" class="error" for="login">{{$errors->first('provinsi_id')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Telepon</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
								{{ Form::text('telepon', old('telepon'), array('class' => 'form-control', 'id' => 'telepon')) }}
							</div>
							@if ($errors->has('telepon'))
							<label id="login-error" class="error" for="login">{{$errors->first('telepon')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Mobile Phone</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
								{{ Form::text('hp', old('hp'), array('class' => 'form-control', 'id' => 'hp')) }}
							</div>
							@if ($errors->has('hp'))
							<label id="login-error" class="error" for="login">{{$errors->first('hp')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Kantor Cabang</label>
						<div class="col-md-9">
                            {{ Form::select('is_kantor_cabang', array('TIDAK' => 'Tidak', 'YA' => 'Ya'), old('is_kantor_cabang'), ['class' => 'form-control is_kantor_cabang', 'style' => 'width: 100%;', 'id' => 'is_kantor_cabang', 'placeholder' => '- Pilih Data -']) }}
							@if ($errors->has('is_kantor_cabang'))
							<label id="login-error" class="error" for="login">{{$errors->first('is_kantor_cabang')}}</label>
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">                                        
						<label class="col-md-3 control-label">NPWP</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-eye"></span></span>
								{{ Form::text('npwp', $rekanan['npwp'], array('class' => 'form-control', 'readonly' => 'true')) }}
							</div>
							@if ($errors->has('npwp'))
							<label id="login-error" class="error" for="login">{{$errors->first('npwp')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Alamat</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-eye"></span></span>
								{{ Form::text('alamat', $rekanan['alamat'], array('class' => 'form-control', 'readonly' => 'true')) }}
							</div>
							@if ($errors->has('alamat'))
							<label id="login-error" class="error" for="login">{{$errors->first('alamat')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Email</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-eye"></span></span>
								{{ Form::text('email', $data['email'], array('class' => 'form-control', 'readonly' => 'true')) }}
							</div>
							@if ($errors->has('email'))
							<label id="login-error" class="error" for="login">{{$errors->first('email')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Bentuk Usaha</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-eye"></span></span>
								{{ Form::text('bentuk_usaha', $data['nama_bentuk_usaha'], array('class' => 'form-control', 'readonly' => 'true')) }}
							</div>
							@if ($errors->has('bentuk_usaha'))
							<label id="login-error" class="error" for="login">{{$errors->first('bentuk_usaha')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Kabupaten/Kota</label>
						<div class="col-md-9">
							{{ Form::select('kota_id', $data['kota'], old('kota_id'), ['class' => 'form-control kota_id', 'style' => 'width: 100%;', 'id' => 'kota_id', 'placeholder' => '- Pilih Data -', 'required']) }}

							@if ($errors->has('kota_id'))
							<span class="help-block">{{$errors->first('kota_id')}}</span>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Fax</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
								{{ Form::text('fax', old('fax'), array('class' => 'form-control', 'id' => 'fax')) }}
							</div>
							@if ($errors->has('fax'))
							<label id="login-error" class="error" for="login">{{$errors->first('fax')}}</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Website</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
								{{ Form::text('website', old('website'), array('class' => 'form-control', 'id' => 'website')) }}
							</div>
							@if ($errors->has('website'))
							<label id="login-error" class="error" for="login">{{$errors->first('website')}}</label>
							@endif
						</div>
					</div>

					<div class="form-group @if ($errors->has('jenis_pengadaan')) has-error @endif">
	                    <label class="col-md-3 col-xs-12 control-label">Jenis Pengadaan *</label>
						<div class="col-md-9 col-xs-12">                                              
							{{ Form::select('mt_jenis_pengadaan_id', $data['jenispengadaans'], old('mt_jenis_pengadaan_id'), ['class' => 'form-control mt_jenis_pengadaan_id', 'style' => 'width: 100%;', 'id' => 'jenispengadaans', 'placeholder' => '- Pilih Data -', 'required']) }}

								@if ($errors->has('mt_jenis_pengadaan_id'))
								<span class="help-block">{{$errors->first('mt_jenis_pengadaan_id')}}</span>
								@endif
						</div>
					</div>

				</div>
			</div>
			<hr>
			<div class="row">
		        <div class="form-group">
		            <label class="col-lg-2 control-label">Syarat Verifikasi</label>
		            <div class="col-lg-10">
		                <label class="checkbox">
		                    <input type="checkbox" name="is_syarat" value="1"/>KTP Direksi/Direktur/Pemilik
		                    Perusahaan/Pejabat yang berwenang di Perusahaan (fotokopi)
		                </label>
		                <label class="checkbox">
		                    <input type="checkbox" name="is_npwp" value="1"/> <strong>NPWP</strong> (fotokopi)
		                </label>
		            </div>
		        </div>
		    
			    <div class="form-group">
			        <label class="col-lg-2 control-label">Keterangan <span class="warning">*</span></label>
			        <div class="col-lg-7 ">
			            <textarea name="is_ket" cols="40" rows="4" class="form-control"></textarea>
			                <span class="help-block"> </span>
			        </div>
			    </div>
			</div> 

				
			<div style="padding-top:10px;">
				<div class="bs-callout bs-callout-warning">
		            <ol>
		                <li>Penyedia barang/jasa ini baru mendaftar dan memerlukan persetujuan.</li>
		                <li>Jika data telah diverifikasi dan benar, silakan klik button <em>Setuju</em>.</li>
		                <li>Jika tidak disetujui, isikan keterangan dan silakan klik button <em>Tidak Disetujui</em>.</li>
		            </ol>
		        </div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-footer">
			<a href="{{URL::to('webprofile/listrekanans')}}" class="btn btn-default pull-left">Batal</a>
			<button class="btn btn-info pull-right">Simpan</button>
		</div>
	</div>
</div>
</div>
{!! Form::close() !!}
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
	$('#telepon').mask('#');
	$('#fax').mask("#");
	$('#hp').mask("#");
</script>
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.provinsi_id').select2();
        $('.kota_id').select2();
        $('.is_kantor_cabang').select2();
        $('.jenis').select2();
        $('.mt_jenis_pengadaan_id').select2();
    });
</script>
{{Html::script('js/kota.js')}}
@stop
