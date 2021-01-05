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
                    Petunjuk Pembuatan Dokumen Non Tender/Pemilihan : <br>
                    </b>
                    Perubahan kalimat dalam standar Dokumen agar konsisten dengan isian SPSE
                    <br>
                    <b>1. BAB Lembar Data Kualifikasi (LDK)</b><br>
                    Persyaratan Kualifikasi sesuai dengan yang tercantum dalam aplikasi SPSE
                </p>
	        </div>
	        <div class="panel-body">
	            <div class="row">
                    {!! Form::open(array('url' => route('tender.store-dokumen-pemilihan'), 'method' => 'POST', 'id' => 'file', 'class' => 'form-horizontal', 'files' => true)) !!}
                        @csrf
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nomor Dokumen Pemilihan *</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                                <input type="text" class="form-control" id="inputEmail3" name="nomor_dokumen">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Tanggal Dokumen Pemilihan*</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="inputEmail3" name="tanggal_dokumen">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Dokumen Pemilihan *</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="inputEmail3" name="dokumen">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Upload Dokumen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop