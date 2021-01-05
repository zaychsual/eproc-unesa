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
                        <li class="active"><a href="#tab1administrasi" data-toggle="tab">Evaluasi Administrasi</a></li>
                        <li><a href="#tab2kualifikasi" data-toggle="tab">Evaluasi Kualifikasi</a></li>
                        <li><a href="#tab3teknis" data-toggle="tab">Evaluasi Teknis</a></li>
                        <li><a href="#tab4harga" data-toggle="tab">Evaluasi Harga</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <form action="{{ route('evaluasi.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                        <input type="hidden" name="rekanan_id" value="{{ $rekanan->id }}">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1administrasi">
                                <div class="alert alert-info push-down-20">
                                <span style="color: #fff;">Evaluasi Administrasi</span>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan=10><b>Persyaratan</b></th>
                                        <th><b>Memenuhi</b></th>
                                    </tr>
                                    @foreach($paketDok as $key => $value)
                                    @if($value->is_doc_type == \App\Models\Procurement\PaketDokumenPenawarans::Administrasi)
                                    <tr>
                                        <td colspan=10>{{ $value->name }}</td>
                                        <td>
                                            <input type="hidden" name="dokumen_penawaran_id[]" value="{{ $value->mt_dokumen_penawaran_id }}">
                                            <input type="hidden" name="is_doc_type[]" value="1">
                                            <input type="checkbox" name="memenuhi_administrasi[]" value="1">
                                            <input type="checkbox" name="mt_dokumen_penawran_id[]" value="{{ $value->mt_dokumen_penawaran_id }}">
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </table>
                                <div class="radio">
                                    <label><input type="radio" name="is_lulus_administrasi" value="1">Lulus</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="is_lulus_administrasi" value="0">Tidak Lulus</label>
                                </div>
                                <b>Alasan tidak lulus</b><br><br>
                                <p>
                                    <textarea cols=80 rows=10 name="alasan_tidak_lulus_administrasi" id="alasan_tidak_lulus_administrasi" disabled></textarea>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="tab2kualifikasi">
                                <div class="alert alert-info push-down-20">
                                <span style="color: #fff;">Evaluasi Kualifikasi</span>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan=10><b>Persyaratan Kualifikasi</b></th>
                                        <th><b>Memenuhi</b></th>
                                    </tr>
                                    @foreach($paketKualifikasi as $key => $rows)
                                    <tr>
                                        <td colspan=10>{{ $rows->nama }}</td>
                                        <td>
                                            <input type="hidden" name="is_doc_type[]" value="2">
                                            <input type="checkbox" name="memenuhi_kualifikasi[]" value="1">
                                            <input type="checkbox" name="mt_kualifikasi_id[]" value="{{ $value->mt_kualifikasi_id }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                <div class="radio">
                                    <label><input type="radio" name="is_lulus_kualifikasi" value="1">Lulus</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="is_lulus_kualifikasi" value="0">Tidak Lulus</label>
                                </div>
                                <b>Alasan tidak lulus</b><br><br>
                                <p>
                                    <textarea cols=80 rows=10 name="alasan_tidak_lulus_kualifikasi" id="alasan_tidak_lulus_kualifikasi" disabled></textarea>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="tab3teknis">
                                <div class="alert alert-info push-down-20">
                                <span style="color: #fff;">Evaluasi Teknis</span>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan=10><b>Persyaratan</b></th>
                                        <th><b>Memenuhi</b></th>
                                    </tr>
                                    @foreach($paketDok as $key => $value)
                                        @if($value->is_doc_type == \App\Models\Procurement\PaketDokumenPenawarans::Teknis)
                                        <tr>
                                            <td colspan=10>{{ $value->name }}</td>
                                            <td>
                                                <input type="hidden" name="is_doc_type[]" value="3">
                                                <input type="checkbox" name="memenuhi_teknis[]" value="1">
                                                <input type="checkbox" name="mt_dokumen_penawaran_id" value="{{ $value->mt_dokumen_penawaran_id }}">
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </table>
                                <div class="radio">
                                    <label><input type="radio" name="is_lulus_teknis" value="1">Lulus</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="is_lulus_teknis" value="0">Tidak Lulus</label>
                                </div>
                                <b>Alasan tidak lulus</b><br><br>
                                <p>
                                    <textarea cols=80 rows=10 name="alasan_tidak_lulus_teknis" id="alasan_tidak_lulus_teknis" disabled></textarea>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="tab4harga">
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
                                                <input type="checkbox" name="memenuhi_harga[]" value="1">
                                                <input type="checkbox" name="mt_dokumen_penawaran_id" value="{{ $value->mt_dokumen_penawaran_id }}">
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
                                {{-- <p>
                                    <textarea cols=80 rows=10></textarea>
                                </p> --}}
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