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
       {!! Form::open(array('url' => route('laman-nontender.store-kirim-penawaran-pbb'), 'method' => 'POST', 'id' => 'file', 'class' => 'form-horizontal', 'files' => true)) !!}
            @csrf
            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                    <ul class="nav nav-tabs">
                        <li><a href="#tabharga" data-toggle="tab">Penawaran Harga</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tabharga">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload File Penawaran</label>
                                    <input type="file" name="file_penawaran" class="form-control">
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
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
                            @if(\App\Models\Procurement\RekananSubmitPenawaran::where('mt_rekanan_id' , Auth::user()->mt_rekanan_id)
                                ->where('paket_id', $paket->id)
                                ->first() == null)
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                    Simpan
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop