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
       {!! Form::open(array('url' => route('penawaran.store-data-penawaran'), 'method' => 'POST', 'id' => 'file', 'class' => 'form-horizontal', 'files' => true)) !!}
            @csrf
            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
            <div class="panel panel-default">
                <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tabsurat" data-toggle="tab">Surata Penawaran</a></li>
                            <li><a href="#tabteknis" data-toggle="tab">Penawaran Teknis</a></li>
                            <li><a href="#tabharga" data-toggle="tab">Penawaran Harga</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tabsurat">
                            <p>Status : </p>
                            <p>
                                <h1>REKANAN 9</h1> <br>
                                Perihal : Penawaran pekerjaan {{ $paket->nama }} <br>

                                Penawaran ini berlaku selama <input type="text" name="masa_berlaku"> <br>
                            </p>
                            <input type="checkbox" name="is_setuju" value="1">
                            <lable>Setuju</lable>
                        </div>
                        <div class="tab-pane fade" id="tabteknis">
                            <div class="panel panel-info">
                                <div class="panel-heading">Jadwal penyerahan atau pengiriman barang</div>
                                <input type="file" name="file_jadwal_penyerahan">
                            </div>
                            <hr/>
                            <br>
                            <div class="panel panel-info">
                                <div class="panel-heading">Brosur atau gambar-gambar</div>
                                <input type="file" name="file_brosur">
                            </div>

                            <div class="panel panel-info">
                                <div class="panel-heading">Tenaga teknis</div>
                                <input type="file" name="file_tenaga_teknis">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabharga">
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