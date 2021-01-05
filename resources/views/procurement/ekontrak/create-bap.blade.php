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
		{!! Form::open(array('url' => route('e-kontrak.store-bap'), 'method' => 'POST', 'id' => 'tahaps', 'class' => 'form-horizontal','files' => true)) !!}
		{!! csrf_field() !!}
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
        <input type="hidden" name="mt_rekanan_id" value="{{ @$rekanan->id }}">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-info push-down-20">
                    <span style="color: #FFF500;">Form Informasi Paket</span>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
                <div class="row">
                    <div clas="col-md-12">
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Kode Tender</td>
                                    <td>:</td>
                                    <td>{{ $paket->kode }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Tender</td>
                                    <td>:</td>
                                    <td>{{ $paket->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Satuan Kerja</td>
                                    <td>:</td>
                                    <td>{{ $paket->getSatuanKerja }}</td>
                                </tr>
                                <tr>
                                    <td>Instansi</td>
                                    <td>:</td>
                                    <td>{{ @$rekanan->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Pemenang</td>
                                    <td>:</td>
                                    <td>{{ @$rekanan->nama }}</td>
                                </tr>
                                
                            </table>
                        </div>
                        <div class="alert alert-info push-down-20">
                            <span style="color: #FFF500;">Form Infomasi BA Serah Terima</span>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr>
                                    <td>No BAST</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="bast_no" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal BAST</td>
                                    <td>:</td>
                                    <td>
                                        <input type="date" name="bast_tanggal" class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="alert alert-info push-down-20">
                            <span style="color: #FFF500;">Form Informasi BA Pembayaran</span>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr>
                                    <td>No BAP</td>
                                    <td>:</td>
                                    <td><input type="text" name="bap_no" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal BAP</td>
                                    <td>:</td>
                                    <td><input type="date" name="bap_tanggal" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Besar Pembayaran</td>
                                    <td>:</td>
                                    <td><input type="number" name="bap_besar_pembayaran" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Progres Fisik</td>
                                    <td>:</td>
                                    <td><input type="number" placeholder="100" name="bap_progress_fisik" class="form-control"></td>
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
                                    <td>Dokumen Cetak BAST</td>
                                    <td>:</td>
                                    <td><input type="file" name="bast_file" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Dokumen Cetak BAST</td>
                                    <td>:</td>
                                    <td><input type="file" name="bap_file_upload" class="form-control"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">     
                <a href="{{ URL::to('/home') }}" class="btn btn-default pull-left">Batal</a>
                <a class="btn btn-primary" href="{{ route('e-kontrak.print-bast',$paket_id) }}"><i class="fa fa-print"></i>Cetak BAST</a>
                <a class="btn btn-primary" href="{{ route('e-kontrak.print-bap',$paket_id) }}"><i class="fa fa-print"></i>Cetak BAP</a>                               
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
