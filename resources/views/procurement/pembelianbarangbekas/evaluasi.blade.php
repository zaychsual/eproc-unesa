@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@endsection

@section('breadcrumbs')
<li class="active">{{ $title }}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {{ $title }}</h2>
@stop

@section('content')
<div class="page-content-wrap">
                    
    <!-- START WIDGETS -->  
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info push-down-20">
                <span style="color: #FFF500;">Evaluasi {{ $rekanan->nama }}</code>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1administrasi" data-toggle="tab">Evaluasi Harga</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <form action="{{ route('pembelian-barang-bekas.evaluasi-store') }}" method="post">
                        @csrf
                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                        <input type="hidden" name="rekanan_id" value="{{ $rekanan->id }}">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab4harga">
                                <div class="alert alert-info push-down-20">
                                <span style="color: #fff;">Evaluasi Harga</span>
                                </div>
                                 <table class="table table-bordered">
                                    <tr>
                                        <th colspan=10><b>Persyaratan</b></th>
                                        <th><b>Memenuhi</b></th>
                                    </tr>
                                    @foreach($paketDok as $key => $value)
                                        @if($value->is_doc_type == \App\Models\Procurement\PaketDokumenPenawarans::Harga)
                                        <tr>
                                            <td colspan=10>{{ $value->name }}</td>
                                            <td>
                                                <input type="hidden" name="is_doc_type[]" value="4">
                                                <input type="checkbox" name="memenuhi_dok_penawaran[]" value="1">
                                                <input type="hidden" name="mt_dokumen_penawaran_id[]" value="{{ $value->mt_dokumen_penawaran_id }}">
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </table>
                                <b>Penilaian</b><br><br>
                                <div class="radio">
                                    <label><input type="radio" name="is_lulus_harga" value="1">Lulus</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="is_lulus_harga" value="0">Tidak Lulus</label>
                                </div>
                                
                                Harga terkoreksi (Rp)&nbsp;<input type="text" name="harga_terkoreksi">
                                <br>
                                <br>
                                <p class="pull-right">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
    const TidakLulus = 0
    $("input[name='is_lulus_administrasi']").click(function(){
        if($('input:radio[name=is_lulus_administrasi]:checked').val() == TidakLulus ){
           $("#alasan_tidak_lulus_administrasi").prop('disabled',false)
        } else {
            $("#alasan_tidak_lulus_administrasi").prop('disabled',true)
        }
    });

    $("input[name='is_lulus_kualifikasi']").click(function(){
        if($('input:radio[name=is_lulus_kualifikasi]:checked').val() == TidakLulus ){
           $("#alasan_tidak_lulus_kualifikasi").prop('disabled',false)
        } else {
            $("#alasan_tidak_lulus_kualifikasi").prop('disabled',true)
        }
    });

    $("input[name='is_lulus_teknis']").click(function(){
        if($('input:radio[name=is_lulus_teknis]:checked').val() == TidakLulus ){
           $("#alasan_tidak_lulus_teknis").prop('disabled',false)
        } else {
            $("#alasan_tidak_lulus_teknis").prop('disabled',true)
        }
    });

    $("input[name='is_lulus_harga']").click(function(){
        if($('input:radio[name=is_lulus_harga]:checked').val() == TidakLulus ){
           $("#alasan_tidak_lulus_harga").prop('disabled',false)
        } else {
            $("#alasan_tidak_lulus_harga").prop('disabled',true)
        }
    });
</script>
@stop 