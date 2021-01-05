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
	    <div class="panel panel-default">
	        <div class="panel-heading">
	             <p>
                    <b> 
                        Input harga negoisasi
                    </b>
                </p>
	        </div>
	        <div class="panel-body">
	            <div class="row">
                    <form action="{{ route('epurchasing.store-negoisasi') }}" method="post">
                        @csrf
                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                        <input type="hidden" name="rekanan_id" value="{{ $rekanan_id }}">
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
                                <td>{{ $value->harga * $value->qty }}</td>
                                <td>{{ $value->keterangan }}</td>
                            </tr>
                            @endforeach
                        </table>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop