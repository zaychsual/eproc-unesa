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
                    <form action="{{ route('store-syarat-dok') }}" method="post">
                        @csrf
                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                        <h2>Administrasi</h2>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="masa_berlaku">
                                Masa berlaku penawaran
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="penawaran">
                                Penawaran
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="jaminan">
                                Jaminan Penawaran
                            </label>
                        </div>
                        <h2>Teknis</h2>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="pengiriman_barang">
                                Jadwal Penyerahan atau Pengiriman Barang
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="brosur">
                                Brosur atau Gambar-gambar
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="jaminan_purnajual">
                                Jaminan purnajual
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="tenaga_teknis">
                                Tenaga teknis
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="">
                               <textarea class="form-control" name="" cols=100></textarea>
                               <i style="color:red">*Pastikan syarat tambahan sudah di ceklist sebelum menyimpan</i>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop