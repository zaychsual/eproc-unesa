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
                    Penetapan Pemenang
                </p>
	        </div>
	        <div class="panel-body">
                <form action="{{ route('quotation.store-pemenang') }}" method="post">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Harga Penawaran</th>
                            <th>Harga Terkoreksi</th>
                        </tr>
                        @foreach($rekanan as $row)
                        <tr>
                            <td><input type="checkbox" name="rekanan_id[]" value="{{ $row->id }}"></td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->harga_penawaran }}</td>
                            <td>{{ $row->harga_terkoreksi }}</td>
                        </tr>
                        @endforeach
                    </table>

                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Simpan 
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
