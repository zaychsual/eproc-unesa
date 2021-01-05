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
		{!! Form::open(array('url' => route('e-kontrak.store-spp'), 'method' => 'POST', 'id' => 'tahaps', 'class' => 'form-horizontal')) !!}
		{!! csrf_field() !!}
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
        <input type="hidden" name="mt_rekanan_id" value="{{ @$rekanan->id }}">
        <input type="hidden" name="kotrak_id" value="{{ @$kontrak->id }}">
        <div class="panel panel-default">
            <div class="panel-body">
               <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">No Surat Perintah Pengiriman </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('spp_no', old('spp_no'), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal SPP </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::date('spp_tanggal', old('spp_tanggal'), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama Tender </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <label>{{$paket->nama}}</label>
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama PPK </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <label>{{$ppk->nama}}</label>
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jabatan PPK </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            {{$ppk->jabatan}}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">NIP PPK </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            {{@$ppk->nip}}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama Satuan Kerja </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <label></label>
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">No. Surat Perjanjian </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Surat Perjanjian</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Nama Pemenang</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Alamat Pemenang</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Wakil Sah Penyedia </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::text('spp_wakil_sah_penyedia', old('spp_wakil_sah_penyedia'), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                
                <div class="form-group @if ($errors->has('spp_jabatan_wakil_penyedia')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jabatan Wakil Penyedia </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::text('spp_jabatan_wakil_penyedia', old('spp_jabatan_wakil_penyedia')), array('class' => 'form-control', 'required') }}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('spp_tgl_brg_diterima')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Barang di Terima</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::date('spp_tgl_brg_diterima', old('spp_tgl_brg_diterima')), array('class' => 'form-control', 'required') }}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Waktu Penyelesaian </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::text('sppbj_tembusan', old('sppbj_tembusan')), array('class' => 'form-control', 'required','placeholder'=>'Contoh Pengisian 30 Hari,2 Tahun, 3 Bulan') }}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('spp_waktu_penyelesaian')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Pekerjaan Selesai</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::date('spp_waktu_penyelesaian', old('spp_waktu_penyelesaian')), array('class' => 'form-control', 'required') }}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('spp_alamat_pengiriman')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Alamat Pengiriman</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::text('spp_alamat_pengiriman', old('spp_alamat_pengiriman')), array('class' => 'form-control', 'required') }}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('spp_kota')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Kota SPP</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::text('spp_kota', old('spp_kota')), array('class' => 'form-control', 'required') }}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('spp_jaminan_cacat')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jaminan Bebas Cacat/Mutu/Garansi(Bulan)</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::text('spp_jaminan_cacat', old('spp_jaminan_cacat')), array('class' => 'form-control', 'required') }}
                        </div>  
                    </div>
                </div>
            </div>
            <div class="panel-footer">     
                <a href="{{ URL::to('/home') }}" class="btn btn-default pull-left">Batal</a>                               
                <button class="btn btn-success"><i class="fa fa-save"></i>Submit</button>
                @if($spp->id != null)
                <a class="btn btn-primary" href="{{ route('e-kontrak.print-sppbj',$paket_id) }}"><i class="fa fa-print"></i>Print</a>
                @endif
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
