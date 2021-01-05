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
                    Edit Metode Pengadaan 
                </p>
	        </div>
	        <div class="panel-body">
	            <div class="row">
                    {!! Form::open(array('url' => route('tender.store-edit-pengadaan'), 'method' => 'POST', 'id' => 'file', 'class' => 'form-horizontal', 'files' => true)) !!}
                        @csrf
                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                         <div class="form-group @if ($errors->has('jenispengadaan_id')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Jenis Pengadaan *</label>
                            <div class="col-md-6 col-xs-12">                                              
                                {{ Form::select('jenispengadaan_id', $jenisPengadaan, $paket->jenispengadaan_id, ['class' => 'form-control jenispengadaan_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'jenispengadaan_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </div>
                        </div>  
                        <div class="form-group @if ($errors->has('mtd_kualifikasi_id')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Metode Kualifikasi</label>
                            <div class="col-md-6 col-xs-12">                                              
                                {{ Form::select('mtd_kualifikasi_id', $mtd_kualifikasi_id,$paket->mtd_kualifikasi_id, ['class' => 'form-control mtd_kualifikasi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'mtd_kualifikasi_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </div>
                        </div> 
                        <div class="form-group @if ($errors->has('mtd_kualifikasi_id')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Metode Dokumen</label>
                            <div class="col-md-6 col-xs-12">        
                                <select name="is_metode_dokumen" class="form-control">
                                    <option value="1">Metode Satu Sampul</option>
                                    <option value="2">Metode dua sampul</option>
                                    <option value="3">Metode dua tahap</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('mtd_kualifikasi_id')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Metode Evaluasi</label>
                            <div class="col-md-6 col-xs-12">                                              
                                {{ Form::select('evaluasi_kriteria_id', $evaluasiKriteria,[], ['class' => 'form-control evaluasi_kriteria_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'mtd_kualifikasi_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </div>
                        </div> 
                        
                        
                        <br>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop