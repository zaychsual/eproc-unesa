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
                                    <tr>
                                        <td colspan=10>Masa Berlaku Penawaran</td>
                                        <td>
                                            <input type="checkbox" name="masa_berlaku_penawaran" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=10> Penawaran</td>
                                        <td>
                                            <input type="checkbox" name="penawaran" value="1">
                                        </td>
                                    </tr>
                                </table>
                                <b>Alasan tidak lulus</b><br><br>
                                <p>
                                    <textarea cols=80 rows=10 name="alasan_tidak_lulus_administrasi"></textarea>
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
                                    <tr>
                                        <td colspan=10>SIUP</td>
                                        <td>
                                            <input type="checkbox" name="siup" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=10> Telah melunasi pajak akhir tahun</td>
                                        <td>
                                            <input type="checkbox" name="lunas_pajak_akhir_tahun" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=10> Tidak masuk daftar hitam</td>
                                        <td>
                                            <input type="checkbox" name="tidak_masuk_daftar_hitam" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=10> Memiliki NPWP</td>
                                        <td>
                                            <input type="checkbox" name="memiliki_npwp" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=10>Yang bersangkutan dan menajemennya tidak dalam pengawasan pengadilan ,tidak pailit dan kegiatan usahanya tidak sedang dihentikan</td>
                                        <td>
                                            <input type="checkbox" name="tidak_dalam_pengawasan" value="1">
                                        </td>
                                    </tr>
                                </table>
                                <b>Alasan tidak lulus</b><br><br>
                                <p>
                                    <textarea cols=80 rows=10 name="alasan_tidak_lulus_kualifikasi"></textarea>
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
                                    <tr>
                                        <td colspan=10>Spesifikasi Teknis dan identitas</td>
                                        <td colspan=><input type="checkbox" name="spesifikasi_teknis_identitas" value="1"></td>
                                    </tr>
                                </table>
                                <b>Alasan tidak lulus</b><br><br>
                                <p>
                                    <textarea cols=80 rows=10 name="alasan_tidak_lulus_teknis"></textarea>
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
                                    <tr>
                                        <td colspan=10>Daftar Kuantitas dan harga</td>
                                        <td colspan=><input type="checkbox" name="daftar_kuantitas_n_harga" value="1"></td>
                                    </tr>
                                </table>
                                <b>Penilaian</b><br><br>
                                Lulus &nbsp;&nbsp;<input type="radio" name="penilaian" checked value="1"> <br>
                                Tidak Lulus&nbsp;&nbsp;<input type="radio" name="penilaian" value="3"> <br>
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
