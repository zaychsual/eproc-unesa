@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Tambah {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')

<!-- page start-->
<div class="row">
	<div class="col-md-12">
		{!! Form::open(array('url' => route('e-kontrak.store-kontrak'), 'method' => 'POST', 'id' => 'tahaps', 'class' => 'form-horizontal')) !!}
		{!! csrf_field() !!}
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
        <input type="hidden" name="mt_rekanan_id" value="{{ $rekanan->id }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <table class="table table-bordered">
                    <tr>
                        <td>Kode REGINA/RUP</td>
                        <td>:</td>
                        <td>{{ Form::number('kode_rup', $paket['kode_rup'], array('class' => 'form-control', '')) }}</td>
                    </tr>
                    <tr>
                        <td>Nama Paket</td>
                        <td>:</td>
                        <td>{{ Form::text('nama', $paket['nama'], array('class' => 'form-control', 'id'=>'nama', '')) }}</td>
                    </tr>
                </table>
            </div>
            <div class="panel-body">
               <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">NO Kontrak </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('kontrak_no', old('kontrak_no'), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Kontrak </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::date('kontrak_tanggal', old('kontrak_tanggal'), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Kota Kontrak </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-building"></span></span>
                            {{ Form::text('kontrak_kota', old('kontrak_kota'), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="alert alert-info push-down-20">
                    <span style="color: #FFF500;">Pihak Pertama</span>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
                <div class="row">
                    <div clas="col-md-12">
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Nama PPK</td>
                                    <td>:</td>
                                    <td>{{ $ppk->name }}</td>
                                </tr>
                                <tr>
                                    <td>Unit Kerja</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="kontrak_unit_kerja" class="form-control">
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td>Satuan Kerja</td>
                                    <td>:</td>
                                    <td>
                                        {{ $paket->getSatuanKerja['satuankerja'] }}
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td>Alamat Satuan Kerja</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="kontrak_alamat_satker" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jabatan Yang menandatangani SK PPK</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="kontrak_jabatan_satker" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>No SK PPK</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="kontrak_no_sk_ppk" class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="alert alert-info push-down-20">
                            <span style="color: #FFF500;">Pihak Kedua</span>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Nama Penyedia</td>
                                    <td>:</td>
                                    <td>
                                        {{ $rekanan->nama }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat Penyedia</td>
                                    <td>:</td>
                                    <td>
                                        {{ $rekanan->alamat }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Wakil Sah Penyedia</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="kontrak_wakil_sah_penyedia" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jabatan Sah Penyedia</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="kontrak_jabatan_wakil_penyedia" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="kontrak_nama_bank" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. Rek Bank</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="kontrak_no_rek_bank" class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="alert alert-info push-down-20">
                            <span style="color: #FFF500;">Informasi Pendukung</span>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Nilai Kontrak</td>
                                    <td>:</td>
                                    <td><input type="text" name="kontrak_nilai_kontrak" class="form-control"></td>
                                </tr>
                                {{-- <tr>
                                    <td>Jenis Kontrak</td>
                                    <td>:</td>
                                    <td><input type="text" name="" class="form-control"></td>
                                </tr> --}}
                                <tr>
                                    <td>Informasi Lainnya</td>
                                    <td>:</td>
                                    <td><input type="text" name="kontrak_informasi_lainnya" class="form-control"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">     
                <a href="{{ URL::to('/home') }}" class="btn btn-default pull-left">Batal</a>                               
                <button class="btn btn-success"><i class="fa fa-save"></i>Submit</button>
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
	$('#saham').mask('#.##0', {reverse: true});
</script>
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.satuan').select2();
        $('.status_kepegawaian').select2();
    });
</script>
@stop
