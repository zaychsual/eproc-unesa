@extends('procurement.layouts.tender.app')

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
@section('content')
<!-- page start-->
<div class="row">
	<div class="col-md-12">
       {!! Form::open(array('url' => route('laman-tender.store-data-penawaran'), 'method' => 'POST', 'id' => 'file', 'class' => 'form-horizontal', 'files' => true)) !!}
            @csrf
            <input type="hidden" name="paket_id" value="{{ \Crypt::encrypt($paket->id) }}">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabsurat" data-toggle="tab">Surata Penawaran</a></li>
                        <li><a href="#tabteknis" data-toggle="tab">Penawaran Teknis</a></li>
                        <li><a href="#tabharga" data-toggle="tab">Penawaran Harga</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tabsurat">
                            <p>Status : </p>
                            <p>
                                <h1></h1> <br>
                                Perihal : Penawaran pekerjaan {{ $paket->nama }} <br>

                                Penawaran ini berlaku selama <input type="text" name="masa_berlaku"> <br>
                            </p>
                            <input type="checkbox" name="is_setuju" value="1">
                            <lable>Setuju</lable>
                        </div>
                        <div class="tab-pane fade" id="tabteknis">
                            <table class="table table-responsive">
                                <tr>
                                    <th>Dokumen</th>
                                    <th></th>
                                </tr>
                                @foreach($paketDokPenawran as $key => $value)
                                    <tr>
                                        <td>{{ $value->getDokPenawaran['name'] }}</td>
                                        <td>
                                            <input type="hidden" name="paket_dokumen_penawaran_id[]" value="{{ $value->id }}"> 
                                            <input type="file" name="files_{{ $value->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabharga">
                            <div class="form-group">
                                <input type="file" name="file_penawaran" id="file_penawaran">
                                <button class="btn btn-default" type="button" id="uploadTrigger">
                                    <i class="fa fa-upload"></i> Upload Penawaran
                                </button>
                                <a class="btn btn-default" href="">
                                    <i class="fa fa-download"></i> Download Template Penawaran
                                </a>
                            </div>
                            <hr>
                            <br>
                            <br>
                            <div class="row">
                                <table class="table table-responsive">
                                    <tr>
                                        <th>Jenis Barang/Jasa</th>
                                        <th>Satuan</th>
                                        <th>Vol</th>
                                        <th>Harga Penawaran</th>
                                        <th>Pajak (%)</th>
                                        <th>Total</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    @foreach($paketHps as $key => $value)
                                    <tr>
                                        <input type="hidden" name="paket_hps_id[]" value="{{ $value->id }}">
                                        <td>{{ $value->jenis_barang_jasa }}</td>
                                        <td>{{ $value->satuan }}</td>
                                        <td>{{ $value->qty }}</td>
                                        <td><input type="number" name="harga_penawaran[]"></td>
                                        <td>{{ $value->pajak }}</td>
                                        <td>{{ $value->total }}</td>
                                        <td>{{ $value->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <br><br>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
@section('script')
<script>
    $("#uploadTrigger").click(function(){
        $("#file_penawaran").click();
    });

    $("#file_penawaran").hide()

</script>
@stop