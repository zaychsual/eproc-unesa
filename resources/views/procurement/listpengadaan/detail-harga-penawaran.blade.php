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
	            Rincian Penawaran Peserta
	        </div>
	        <div class="panel-body">
	            <div class="row">
                    <table class="table table-hover" id="berita">
                        <tr>
                            <td>Kode Paket</td>
                            <td>:</td>
                            <td>{{ $paket->kode }}</td>
                        </tr>
                        <tr>
                            <td>Nama Paket</td>
                            <td>:</td>
                            <td>{{ $paket->nama }}</td>
                        </tr>
                        <tr>
                            <td>Nama Peserta</td>
                            <td>:</td>
                            <td>{{ $rekanan->nama }}</td>
                        </tr>
                    </table>
                    <br><br>
                    <table class="table table-hover table-bordered" id="berita">
                        <thead>
                            <tr>
                                <th>Jenis Barang/Jasa</th>
                                <th>Satuan Unit</th>
                                <th>Volume</th>
                                <th>Harga</th>
                                <th>Pajak(%)</th>
                                <th>Total Setelah Pajak</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach($penawaran as $key => $penawarans)
                            @php
                                $total += $penawarans->harga_penawaran;
                            @endphp
                            <tr>
                                <td>{{ $penawarans->getHpsDetail['jenis_barang_jasa'] }}</td>
                                <td>{{ $penawarans->getHpsDetail['satuan'] }}</td>
                                <td>{{ $penawarans->getHpsDetail['qty'] }}</td>
                                <td>{{ number_format($penawarans->harga_penawaran,2) }}</td>
                                <td>{{ $penawarans->pajak ?? 0 }}</td>
                                <td>
                                    @if($penawarans->pajak != null and $penawarans->pajak != 0) 
                                        {{ number_format(($penawarans->harga_penawaran ) * ($penawarans->pajak/100) ,2) }}
                                    @else 
                                         {{ number_format($penawarans->harga_penawaran,2) }}
                                    @endif
                                </td>
                                <td>{{ $penawarans->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan=4></td>
                                <td colspan="">Total Penawaran :</td>
                                <td colspan="">{{ number_format($total,2) }}</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop