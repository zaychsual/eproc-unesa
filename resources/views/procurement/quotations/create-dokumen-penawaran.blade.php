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
                    Pilih daftar dokumen yang dipersyaratkan untuk melengkapi penawaran peserta pengadaan
                    </b>
                </p>
	        </div>
	        <div class="panel-body">
	            <div class="row">
                    <form action="{{ route('quotation.store-dok-penawaran') }}" method="post">
                        @csrf
                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                        <h2>Administrasi</h2>
                        @foreach($dokPenawaran as $key => $value)
                        @if($value->is_doc_type == \App\Models\Procurement\DokumenPenawarans::Administrasi)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="{{ $value->id }}" name="mt_dokumen_penawaran_id[]">
                               {{ $value->name }}
                            </label>
                        </div>
                        @endif
                        @endforeach
                        <h2>Teknis</h2>
                        @foreach($dokPenawaran as $key => $value)
                        @if($value->is_doc_type == \App\Models\Procurement\DokumenPenawarans::Teknis)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="{{ $value->id }}" name="mt_dokumen_penawaran_id[]">
                               {{ $value->name }}
                            </label>
                        </div>
                        @endif
                        @endforeach
                        <h2>Harga</h2>
                        @foreach($dokPenawaran as $key => $value)
                        @if($value->is_doc_type == \App\Models\Procurement\DokumenPenawarans::Harga)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="{{ $value->id }}" name="mt_dokumen_penawaran_id[]">
                               {{ $value->name }}
                            </label>
                        </div>
                        @endif
                        @endforeach

                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop