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
    <div class="panel with-nav-tabs panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"></h3>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tabInfoPaket" data-toggle="tab">Informasi Paket</a></li>
                <li><a href="#tabPenawaran" data-toggle="tab">Penawaran Peserta</a></li>
                <li><a href="#tabEvaluasi" data-toggle="tab">Evaluasi</a></li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tabInfoPaket">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Detail</strong> Paket</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
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
                                        <tr>
                                            <td>Jadwal</td>
                                            <td>:</td>
                                            <td>
                                                @if(null == $jadwal)
                                                <a class="btn btn-default" href=""
                                                data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;
                                                Belum ada jadwal 
                                                </a>
                                                @else 
                                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;Semua jadwal sudah tersimpan
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dokumen Pemilihan &nbsp;
                                            </td>
                                            <td>:</td>
                                            <td style="background-color:#1caf9a;color:white;">
                                                Dokumen Pemilihan
                                                @php
                                                    $checkDok = \App\Models\Procurement\PaketDokumen::where('paket_id', $paket->id)->first();
                                                @endphp
                                                @if( $checkDok != null)
                                                    <a style="color:black;" class="btn btn-warning pull-right" href="{{ asset('uploads/file/'.$checkDok->dokumen) }}" target="_blank">
                                                        Lihat Dokumen
                                                    </a>
                                                @else 
                                                    <a style="color:black;" class="btn btn-warning pull-right" href="{{ route('upload-dokumen-pemilihan', Crypt::encrypt($paket['id'])) }}">
                                                        Upload
                                                    </a>
                                                @endif
                                                <tr>
                                                    <td></td>
                                                    <td>:</td>
                                                    <td>
                                                        <a class="" href="{{ route('input-persyaratan-kualifikasi', Crypt::encrypt($paket['id'])) }}">
                                                            Persyaratan Kualifikasi
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if(null == $lembarKualifikasi)
                                                        <i class="fa fa-times"></i>
                                                        @else 
                                                        <i class="fa fa-check"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>:</td>
                                                    <td>
                                                        @php
                                                            $masaBerlaku = \App\Models\Procurement\PaketMasaBerlaku::where('paket_id', $paket->id)->first();
                                                            $total = 0;
                                                            $disabled = "";
                                                            if( $masaBerlaku != null ) {
                                                                $disabled = "X";
                                                                $total = $masaBerlaku->masa_berlaku;
                                                            }
                                                        @endphp

                                                        <a class="" href="" data-toggle="modal" data-target="#myModals{{ $disabled }}">
                                                            Masa Berlaku Penawaran {{ $total }} hari sejak akhir pemasukan dokumen penawaran
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if(0 == $total)
                                                        <i class="fa fa-times"></i>
                                                        @else 
                                                        <i class="fa fa-check"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>:</td>
                                                    <td>
                                                        <a class="" href="{{ route('input-persyaratan-dokumen', Crypt::encrypt($paket['id'])) }}">
                                                        Dokumen Penawaran teknis
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if(null == $lembarKualifikasi)
                                                        <i class="fa fa-times"></i>
                                                        @else 
                                                        <i class="fa fa-check"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>:</td>
                                                    <td>
                                                        <a class="" href="{{ asset('uploads/file/'.$getFileKak->files) }}" target="_blank">
                                                            Kerangka acuan kerja (KAK) Spesifikasi teknis dan gambar
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if(null == $getFileKak)
                                                        <i class="fa fa-times"></i>
                                                        @else 
                                                        <i class="fa fa-check"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Daftar Penyedia</td>
                                            <td>:</td>
                                            <td>
                                                <a class="btn btn-success" href="{{ route('pilih-rekanan', Crypt::encrypt($paket['id'])) }}">
                                                    <i class="fa fa-arrow-down"></i>
                                                    Pilih penyedia
                                                </a>
                                                <br>
                                                <br>
                                                @if(!empty($rekanan))
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Penyedia</th>
                                                        {{-- <th>Status</th> --}}
                                                    </tr>
                                                    @foreach($rekanan as $i => $rows)
                                                    <tr>
                                                        <td>{{ ($i + 1) }}</td>
                                                        <td>{{ $rows->getMtRekanan['nama'] }}</td>
                                                        {{-- <td>{{ \App\Models\Procurement\Rekanans::TypeStatusActive[$rows->is_active] }}</td> --}}
                                                    </tr>
                                                    @endforeach
                                                </table>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($paket->is_pic == \App\Models\Procurement\Pakets::picPokja)
                                        <tr>
                                            <td>Status Persetujuan</td>
                                            <td>:</td>
                                            <td>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Pokja</th>
                                                        <th>Status</th>
                                                        <th>Tanggal</th>
                                                        <th>Alasan Tidak Setuju</th>
                                                    </tr>
                                                    @foreach($getApproval as $key => $value)
                                                    <tr>
                                                        <td>{{ ($key + 1) }}</td>
                                                        <td>{{ $value->name }}</td>
                                                        <td>
                                                            @if(\App\Models\Procurement\Pakets::Approve == $value->status)
                                                            <i class="fa fa-check"></i>
                                                            @elseif(\App\Models\Procurement\Pakets::Waiting == $value->status)
                                                                -
                                                            @else
                                                            <i class="fa fa-times"></i>
                                                            @endif
                                                        </td>
                                                        {{-- <td>{{ \App\Models\Procurement\Pakets::StatusApproval[$value->status] }}</td> --}}
                                                        <td>{{ $value->approval_date }}</td>
                                                        <td>{{ $value->reason }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                        @else 
                                        <div class="from-group">
                                            <buton type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Publish
                                            </buton>
                                        </div>
                                        @endif
                                    </table>
                                    @php
                                        $check = \checkApprovePokja(Auth::user()->id, $paket->id);
                                        //dd($check->status);
                                    @endphp

                                    @if( $check->status == \App\Models\Procurement\Pakets::Waiting)
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            Persetujuan
                                        </div>
                                        <div class="panel-body">
                                            <form>
                                            <center>PAKTA INTEGRITAS</center>
                                            <p>
                                                Saya menyetujui bahwa: <br>
                                                1. Tidak akan melakukan korupsi, kolusi,dan nepotisme <br>
                                                2. akan melaporkan kepada PA/KPA jika mengetahui  terjadinya praktik korupsi
                                            </p>
                                            <p><b>Alasan tidak setuju</b></p>
                                            <p>
                                                <textarea name="reason" id="reason" rows=10 cols=120></textarea>
                                            </p>
                                            <p>
                                                {{-- <input type="text" name="paket_ids" value="{{ $paket->id }}"> --}}
                                                <button type="submit" class="btn btn-success" id="setuju" data-paket_id="{{ $paket->id }}"><i class="fa fa-check"></i> Setuju</button>
                                                <button type="submit" class="btn btn-danger" id="tidaksetuju" data-pakets_id="{{ $paket->id }}"><i class="fa fa-times"></i> Tidak Setuju</button>
                                            </p>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabPenawaran">
                    <table class="table table-hover" id="berita">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Penyedia Barang/Jasa</th>
                                <th>Tanggal Mendaftar</th>
                                <th>Dokumen Kualifikasi</th>
                                <th colspan="8" style="text-align:center;">Dokumen Penawaran</th>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <th colspan="">Surat Penawaran</th>
                                <th colspan="">Administrasi dan Teknis</th>
                                <th colspan="">Harga</th>
                                <th colspan="">Masa Berlaku</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penawaran as $key => $rows)
                            @php
                                $rekananHarga = \App\Models\Procurement\RekananSubmitHargaPenawaran::where('paket_id', $rows->paket_id)
                                    ->where('mt_rekanan_id',$rows->mt_rekanan_id)
                                    ->first();
                            @endphp
                            <tr>
                                <td>{{ ($key + 1) }}</td>
                                <td>{{ $rows->getRekanan['nama'] }}</td>
                                <td>{{ $rows->getRekanan['created_at'] }}</td>
                                <td><a class="btn btn-primary" href="{{ route('detail-kualifikasi',['paket_id' => $rows->paket_id,'rekanan_id' => $rows->mt_rekanan_id]) }}" target="_blank">Kualifikasi</a></td>
                                <td><a class="btn btn-primary" href="{{ route('detail-surat-penawaran',['paket_id' => $rows->paket_id,'rekanan_id' => $rows->mt_rekanan_id]) }}" target="_blank">Cetak</a></td>
                                <td><a class="btn btn-primary" href="" onclick="basicPopup(this.href);return false">Cetak</a></td>
                                <td><a class="btn btn-primary" href="{{ route('detail-penawaran-harga',['paket_id' => $rows->paket_id,'rekanan_id' => $rows->mt_rekanan_id]) }}" onclick="basicPopup(this.href);return false">Cetak</a></td>
                                <td>{{ $rows->masa_berlaku. " Hari" }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tabEvaluasi">
                    <table class="table table-hover" id="berita">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Peserta</th>
                                <th>Harga Penawaran</th>
                                <th>Harga Terkoreksi</th>
                                <th>Harga Negosiasi</th>
                                <th>Undangan Verifikasi</th>
                                <th><span class="badge badge-success">A</span></th>
                                <th><span class="badge badge-default">K</span></th>
                                <th><span class="badge badge-info">T</span></th>
                                <th><span class="badge badge-primary">H</span></th>
                                <th><span class="badge badge-danger">B</span></th>
                                <th><span class="badge badge-warning">P</span></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekananPenawaran as $key => $values)
                            <tr>
                                <td>{{ ($key + 1) }}</td>
                                <td>
                                    <a class="" href="
                                        {{ route('evaluasi.proses',[
                                            'paket_id' => $values->paket_id,
                                            'rekanan_id' => $values->rekanan_id
                                        ]) }}">
                                        {{ $values->nama }}
                                    </a>
                                </td>
                                <td>@currency($values->harga_penawaran)</td>
                                <td>@currency($values->harga_terkoreksi)</td>
                                <td>@currency($values->harga_negoisasi)</td>
                                <td>
                                </td>
                                <td>
                                    @php
                                        $eA = \App\Models\Procurement\EvaluasiAdministrasi::where('paket_id', $values->paket_id)
                                            ->where('mt_rekanan_id',$values->rekanan_id)
                                            ->first();
                                    @endphp
                                    @if(null != $eA)
                                    <i class="fa fa-check"></i>
                                    @else 
                                    <i class="fa fa-times"></i>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $eK = \App\Models\Procurement\EvaluasiKualifikasi::where('paket_id', $values->paket_id)
                                            ->where('mt_rekanan_id',$values->rekanan_id)
                                            ->first();
                                    @endphp
                                    @if(null != $eK)
                                    <i class="fa fa-check"></i>
                                    @else 
                                    <i class="fa fa-times"></i>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $eT = \App\Models\Procurement\EvaluasiTeknis::where('paket_id', $values->paket_id)
                                            ->where('mt_rekanan_id',$values->rekanan_id)
                                            ->first();
                                    @endphp
                                    @if(null != $eT)
                                    <i class="fa fa-check"></i>
                                    @else 
                                    <i class="fa fa-times"></i>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $eH = \App\Models\Procurement\EvaluasiHarga::where('paket_id', $values->paket_id)
                                            ->where('mt_rekanan_id',$values->rekanan_id)
                                            ->first();
                                    @endphp
                                    @if(null != $eH)
                                    <i class="fa fa-check"></i>
                                    @else 
                                    <i class="fa fa-times"></i>
                                    @endif
                                </td>
                                <td></td>
                                <td>
                                    @php
                                        $getPemenang = \App\Models\Procurement\PaketRekanan::getPemenang($values->paket_id, $values->rekanan_id);
                                    @endphp
                                    @if($getPemenang != null)
                                        <i class="fa fa-check" style="color:blue;"></i>
                                    @else 
                                        <i class="fa fa-times" style="color:blue;"></i>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $verifikasi = \App\Models\Procurement\Verifikasi::where('paket_id', $values->paket_id)
                                        ->where('mt_rekanan_id', $values->rekanan_id)
                                        ->first();
                                    @endphp
                                    <a class="btn btn-warning" href="
                                        {{ 
                                            route('verifikasi.proses',[
                                                'paket_id' => $values->paket_id,
                                                'rekanan_id' => $values->rekanan_id
                                            ]) 
                                        }}
                                    ">
                                    Verifikasi
                                    </a>
                                    @if($verifikasi !=null )
                                        @if($getPemenang == null)
                                        <a class="btn btn-success" href="
                                            {{ 
                                                route('set-pemenang',[
                                                    'paket_id' => $values->paket_id,
                                                ]) 
                                            }}
                                        ">
                                        Penetapan Pemenang
                                        </a>
                                        @endif
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        <span class="badge badge-success">A</span>
                        <p>Evaluasi Administrasi</p>
                        <span class="badge badge-default">K</span>
                        <p>Evaluasi Kualifikasi</p>
                        <span class="badge badge-info">T</span>
                        <p>Evaluasi Teknis</p>
                        <span class="badge badge-primary">H</span>
                        <p>Evaluasi Harga</p>
                        <span class="badge badge-danger">B</span>
                        <p>Pembuktian Kualifikasi</p>
                        <span class="badge badge-warning">P</span>
                        <p>Pemenang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Isi Jadwal Pengadaan</h4>
            </div>
            <form id="form-jadwal">
                <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>No.</th>
                            <th>Tahap</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Upload Dokumen Penawaran</td>
                            <td>
                                <input type="text" name="dok_penawaran_mulai" class="form-control datetime" id="datetimepicker2">
                            </td>
                            <td>
                                <input type="text" name="dok_penawaran_selesai" class="form-control datetime" id="datetimepicker2">
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pembukaan Dokumen Penawaran</td>
                            <td>
                                <input type="text" name="dok_pembukaan_penawaran_mulai" class="form-control datetime" id="datetimepicker2">
                            </td>
                            <td>
                                <input type="text" name="dok_pembukaan_penawaran_selesai" class="form-control datetime" id="datetimepicker2">
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Evaluasi Penawaran</td>
                            <td>
                                <input type="text" name="dok_evaluasi_penawaran_mulai" class="form-control datetime" id="datetimepicker2">
                            </td>
                            <td>
                                <input type="text" name="dok_evaluasi_penawaran_selesai" class="form-control datetime" id="datetimepicker2">
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Klarifikasi teknis dan negosiasi</td>
                            <td>
                                <input type="text" name="dok_klarifikasi_teknis_mulai" class="form-control datetime" id="datetimepicker2">
                            </td>
                            <td>
                                <input type="text" name="dok_klarifikasi_teknis_selesai" class="form-control datetime" id="datetimepicker2">
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Penandatanganan kontrak</td>
                            <td>
                                <input type="text" name="dok_ttd_kontrak_mulai" class="form-control datetime" id="datetimepicker2">
                            </td>
                            <td>
                                <input type="text" name="dok_ttd_kontrak_selesai" class="form-control datetime" id="datetimepicker2">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="submits"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="myModals" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form class="form-inline" action="{{ route('store-masa-berlaku') }}" method="post">
            <input type="hidden" name="paket_id" value="{{ $paket->id }}" id="paket_id">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Isi masa berlaku penawaran</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="sr-only" for="exampleInputAmount"></label>
                        <div class="input-group">
                            <div class="input-group-addon">Masa berlaku penawaran</div>
                            <input type="text" name="masa_berlaku" id="masa_berlaku" class="form-control" id="exampleInputAmount" placeholder="">
                            <div class="input-group-addon">
                                hari sejak batas akhir pemasukan dokumen penawaran
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@stop
@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
    <script>
    //init const persetujuan
    const Approve = 1
    const Reject  = 3

    $('button#submit').on('click', function(e){
        e.preventDefault();
        let paket_id = $("#paket_id").val()
        let masa_berlaku = $("#masa_berlaku").val()

        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan disubmit!",
            type              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText : "Yes",
            cancelButtonText  : "No",
            closeOnConfirm    : false,
            closeOnCancel     : false
        },
        function(isConfirm){
            if(isConfirm){
                const urlYes = "{{ route('store-masa-berlaku') }}"
                $.ajax({
                    url : urlYes,
                    type : 'POST',
                    data: {
                        paket_id : paket_id,
                        masa_berlaku : masa_berlaku
                    },
                    dataType: 'json',
                    success:function (response) {
                        if( response.is_error == true ) {
                            swal("Oopss!!!",response.error_msg, "error")
                            return false
                        } else {
                            setTimeout(function() {
                                location.reload()
                            },200)
                            swal("Success",response.error_msg, "success")
                        }
                    }
                })                
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        });
    });

    $('button#submits').on('click', function(e){
        e.preventDefault();

        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan disubmit!",
            type              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText : "Yes",
            cancelButtonText  : "No",
            closeOnConfirm    : false,
            closeOnCancel     : false
        },
        function(isConfirm){
            if(isConfirm){
                const urlYesJadwal = "{{ route('store-jadwal-pengadaans') }}"
                $.ajax({
                    url : urlYesJadwal,
                    type : 'POST',
                    data: $("#form-jadwal").serialize(),
                    dataType: 'json',
                    success:function (response) {
                        if( response.is_error == true ) {
                            swal("Oopss!!!",response.error_msg, "error")
                            return false
                        } else {
                            setTimeout(function() {
                                location.reload()
                            },200)
                            swal("Success",response.error_msg, "success")
                        }
                    }
                })                
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        });
    });
    
    $('button#setuju').on('click', function(e){
        e.preventDefault();

        let paket_idx = $(this).data('paket_id')
        console.log(paket_idx)

        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan disubmit!",
            type              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText : "Yes",
            cancelButtonText  : "No",
            closeOnConfirm    : false,
            closeOnCancel     : false
        },
        function(isConfirm){
            if(isConfirm){
                const urlYes = "{{ route('store-approval-pokja') }}"
                $.ajax({
                    url : urlYes,
                    type : 'POST',
                    data: {
                        paket_id : paket_idx,
                        status : Approve
                    },
                    dataType: 'json',
                    success:function (response) {
                        if( response.is_error == true ) {
                            swal("Oopss!!!",response.error_msg, "error")
                            return false
                        } else {
                            setTimeout(function() {
                                location.reload()
                            },200)
                            swal("Success",response.error_msg, "success")
                        }
                    }
                })                
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        })
    })

    $('button#tidaksetuju').on('click', function(e){
        e.preventDefault()
        let paket_ids = $(this).data('pakets_id')
        let reason = $("#reason").val()


        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan disubmit!",
            type              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText : "Yes",
            cancelButtonText  : "No",
            closeOnConfirm    : false,
            closeOnCancel     : false
        },
        function(isConfirm){
            if(isConfirm){
                const urlYes = "{{ route('store-approval-pokja') }}"
                $.ajax({
                    url : urlYes,
                    type : 'POST',
                    data: {
                        paket_id : paket_ids,
                        status : Reject,
                        reason : reason
                    },
                    dataType: 'json',
                    success:function (response) {
                        if( response.is_error == true ) {
                            swal("Oopss!!!",response.error_msg, "error")
                            return false
                        } else {
                            setTimeout(function() {
                                location.reload()
                            },200)
                            swal("Success",response.error_msg, "success")
                        }
                    }
                })                
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        })
    })

    function basicPopup(url) {
        popupWindow = window.open(url,'popUpWindow','height=300,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')
	}
    </script>
@endsection