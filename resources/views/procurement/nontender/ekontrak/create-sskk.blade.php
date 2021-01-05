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
	{!! Form::open(array('url' => route('e-kontrak.store-sskk'), 'method' => 'POST', 'id' => 'tahaps', 'class' => 'form-horizontal','files' => true)) !!}
		{!! csrf_field() !!}
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
        <input type="hidden" name="mt_rekanan_id" value="{{ $rekanan->rekanan_id }}">
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
                <table class="table table-bordered">
                    <tr>
                        <td>Upload SSKK</td>
                        <td>:</td>
                        <td><input type="file" name="file_sskk"> </td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">     
                <a href="{{ URL::to('/home') }}" class="btn btn-default pull-left">Batal</a>                               
                <button class="btn btn-success"><i class="fa fa-save"></i>Submit</button>
            </div>
        </div>
    </div>
</div>
@stop