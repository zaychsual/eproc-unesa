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
	<div class="col-md-7">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h6>Detail Paket</h6>
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
                            <td>Kode Paket</td>
                            <td>:</td>
                            <td>{{ Form::number('kode_paket', $paket['kode'], array('class' => 'form-control', '')) }}</td>
                        </tr>
                        <tr>
                            <td>Tahap Paket Saat ini</td>
                            <td>:</td>
                            <td>
                                {{-- get tahapan --}}
                                @php
                                    $tenderTahapan = \App\Models\Procurement\PaketTahapans::getTahapans($paket['id']);
                                    //dd($tenderTahapan);
                                    $url = "";
                                    $is_blank = '';
                                    $download = '';
                                @endphp
                                @if( !empty( $tenderTahapan))
                                @php
                                    
                                    if( $tenderTahapan->nama == 'Pengambilan Dokumen Pengadaan') {
                                        $download = 'download';
                                        $is_blank = 'target=_blank';
                                        $dok = \App\Models\Procurement\PaketDokumen::where('paket_id',$paket['id'])->first();
                                        $url = asset('upload/file/'.$dok->dokumen);
                                    } else if( $tenderTahapan->nama == 'Pemberian Penjelasan' ) {
                                        echo '<input type="hidden" name="penjelasan" id="penjelasan" value="1">';
                                        echo '<input type="hidden" name="penjelasan_button" id="penjelasan_button" value="1">';
                                    } else if( $tenderTahapan->nama == 'Pemasukan Dokumen Penawaran') {
                                        echo '<input type="hidden" name="kirimdata" id="kirimdata" value="1">';
                                    }
                                @endphp
                                @endif
                                <a class="btn btn-success" {{ $download }} href="{{ $url }}" {{ $is_blank }}>
                                    {{ $tenderTahapan->nama ?? '' }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Dokumen Pemilihan</td>
                            <td>:</td>
                            <td>
                                <div class="panel panel-info">
                                <div class="panel-heading">Dokumen Pemilihan</div>
                                    <div class="panel-body">
                                        <a href="{{ asset('uploads/file/'.$paketDokPemilihan->dokumen ?? '' ) }}" target="_blank">
                                            <p>[ {{ $paketDokPemilihan->nomor_dokumen ?? '-' }} ] - {{ $paketDokPemilihan->dokumen ?? '-'}}</p>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Kualifikasi</td>
                            <td>:</td>
                            <td>
                                <div class="panel panel-info">
                                <div class="panel-heading">Data Kualifikasi</div>
                                    <div class="panel-body">
                                        <p>
                                            Dokumen Kualifikasi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            @if($isSubmit)
                                            <a href="{{ route('penawaran.input-kualifikasi', \Crypt::encrypt($paket->id)) }}" target="_blank" class="btn btn-primary">
                                                Lihat Data
                                            </a>
                                            <a href="" class="btn btn-primary">
                                                @php
                                                    $submitDate = \DB::table('e_rekanan_submit_kualifikasi')
                                                        ->where('paket_id', $paket->id)
                                                        ->where('mt_rekanan_id', \Auth::user()->mt_rekanan_id)
                                                        ->first();
                                                @endphp
                                                Status : Sudah Dikirim, pada : {{ \tglindo($submitDate->created_at) }}
                                            </a>
                                            @else
                                            @php
                                                $jadwalKirimDok = \App\Models\Procurement\PaketTahapans::getTahapanKirimPenawaran($paket->id);
                                            @endphp
                                            <a href="{{ route('laman-tender.input-kualifikasi', \Crypt::encrypt($paket->id)) }}" class="btn btn-primary" id="kirimdatass">
                                                Kirim Data
                                            </a>
                                            <a href="" target="_blank" class="btn btn-primary">
                                                Status : Belum Dikirim, Jadwal Pengiriman : {{ \tglindo($jadwalKirimDok->waktu_mulai) }}  <br>&nbsp; s.d &nbsp;
                                                    {{ \tglindo($jadwalKirimDok->waktu_selesai) }} 
                                            </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Penawaran Anda</td>
                            <td>:</td>
                            <td>
                                <div class="panel panel-info">
                                <div class="panel-heading">Status Pengiriman Dokumen</div>
                                    <div class="panel-body">
                                        @if(checkKirimDatapenawaran($paket->id, Auth::user()->mt_rekanan_id) < 1)
                                        @php
                                            $buttons = 'show';
                                        @endphp
                                        <p>
                                            Surat Penawaran : <span class="badge badge-danger">Belum Dikirim</span> <br>
                                            <br>
                                            Dokumen Harga : <span class="badge badge-danger">Belum Dikirim</span> <br>
                                            <br>
                                            Dokumen Teknis : <span class="badge badge-danger">Belum Dikirim</span> <br>
                                        </p>
                                        @else
                                        @php
                                            $submitDates = \App\Models\Procurement\RekananSubmitPenawaran::firstData($paket->id);
                                            $totalpenawaran = \App\Models\Procurement\RekananSubmitPenawaran::where('paket_id', $paket->id)
                                                ->where('mt_rekanan_id', Auth::user()->mt_rekanan_id)
                                                ->first();
                                            //dd($totalpenawaran);
                                            $buttons = 'hide';
                                        @endphp
                                        <p>
                                            Surat Penawaran : <span class="badge badge-success">Sudah Dikirim, ({{ \tglindo($submitDates->created_at) }})</span> <br>
                                            <br>
                                            Dokumen Harga : <span class="badge badge-success">Sudah Dikirim, ({{ \tglindo($submitDates->created_at) }})</span> <br>
                                            <br>
                                            Dokumen Teknis : <span class="badge badge-success">Sudah Dikirim, ({{ \tglindo($submitDates->created_at) }})</span> <br>
                                        </p> 

                                        <p>
                                            Total Penawaran : Rp. <span class="badge badge-info">@currency($totalpenawaran->total_harga_penawaran)</span>
                                        </p>
                                        @endif
                                        <hr/>
                                        @if($buttons == 'show')
                                        <p class="pull-right">
                                            <a class="btn btn-rounded btn-info" href="{{ route('laman-tender.input-penawaran', \Crypt::encrypt($paket->id)) }}">Kirim Penawaran</a>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hasil Evaluasi</td>
                            <td>:</td>
                            <td>
                                <tr>
                                    <td>Pengumuman Pemenang</td>
                                </tr>
                            </td>
                        </tr>
                    </table>
                </div>
	        </div>
	    </div>
	</div>
    <div class="col-md-5" style="display:none" id="penjelasans">
        <div class="panel-heading">
            <h6>Penjelasan Dan Pertanyaan </h6>
            <p class="pull-right" id="penjelasan_buttons" style="display:none">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope"></i> Kirim Pertanyaan</button>
            </p>
        </div>
        <div class="panel panel-primary">
	        <div class="panel-body">
                <div class="panel panel-info">
                    <div class="panel-heading">Pembukaan
                    </div>
                    <div class="panel-body">
                        @php
                            $pembukaan = \App\Models\Procurement\PemberianPenjelasanPembukaan::where('paket_id', $paket['id'])->first();
                        @endphp
                        <div class="row">
                            <textarea class="form-control">{!! $pembukaan->pembukaan ?? '' !!}</textarea>
                        </div>
                    </div>
                </div>
                @php
                    $pertanyaan = \App\Models\Procurement\PemberianPenjelasanPertanyaan::where('paket_id', $paket['id'])
                        ->where('mt_rekanan_id',\Auth::user()->mt_rekanan_id)
                        ->where('is_jawaban','NO')
                        ->get();
                @endphp
                @foreach($pertanyaan as $key => $value)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        {{ $value->dokumen }} - {{ $value->bab }}
                    </div>
                    <div class="panel-body">
                        @php
                            $pertanyaans = \App\Models\Procurement\PemberianPenjelasanPertanyaan::where('paket_id', $paket['id'])
                                ->whereOr('to_rekanan_id', $value->mt_rekanan_id)
                                ->orderBy('created_at','asc')
                                ->get();
                        @endphp
                        @foreach($pertanyaans as $key => $r)
                            <div class="form-group">
                                <label class="pull-right">
                                    @if($r->is_jawaban == 'NO')
                                    <span class="badge badge-primary">R</span>
                                    @else 
                                    <span class="badge badge-warning">p</span>
                                    @endif
                                </label>
                                <textarea class="form-control">{!! $r->uraian !!}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ route('laman-tender.store-pertanyaan') }}" method="post">
                @csrf
                <input type="hidden" name="paket_id" value="{{ \Crypt::encrypt($paket['id']) }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Kirim Pertanyaan</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Dokumen</label>
                        <input type="text" name="dokumen" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Bab</label>
                        <input type="text" name="bab" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Uraian</label>
                        <textarea class="form-control" name="uraian"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Lampiran</label>
                        <input type="file" name="lampiran" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- page end-->
@stop

@section('script')
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('ress/js/plugins/summernote/summernote.js') !!}

{{Html::script('js/jquery.mask.min.js')}}
<script>
    var urlKota = "{{url('/selectkota')}}";
    $('#telepon').mask("#");
    $('#fax').mask("#");
    $('#hp').mask("#");

   $(document).ready(function() {
        let penjelas = $("#penjelasan").val()
        if( penjelas == 1) {
            $("#penjelasans").show()
        } else {
            $("#penjelasans").hide()
        }

        let penjelasbtn = $("#penjelasan_button").val()
        if( penjelasbtn == 1) {
            $("#penjelasan_buttons").show()
        } else {
            $("#penjelasan_buttons").hide()
        }

        let kirimdata = $("#kirimdata").val()
        if( kirimdata == 1) {
            $("#kirimdatas").show()
        } else {
            $("#kirimdatas").hide()
        }
    })

    $("#is_pic").change(function () {
        let id = $(this).val()
        $("#pokjas").hide()
        $("#pejabats").hide()
        if( id == '10' ) 
        {   
            $("#pokjas").show()
            $("#pejabats").hide()
        } else if( id == '20') {
            $("#pokjas").hide()
            $("#pejabats").show()
        }
    })
</script>
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.klpd_id').select2();
        $('.satuankerja_id').select2();
        $('.provinsi_id').select2();
        $('.kota_id').select2();
        $('.tahun_id').select2();
        $('.jenispengadaan_id').select2();
        $('.kualifikasi_id').select2();
        $('.mtd_kualifikasi_id').select2();
        $('.pemenang_id').select2();
        $('.jeniskontrak_id').select2();
        $("#pokja_id").select2();
        $("#pejabat_id").select2();
    });
</script>

<script type="text/javascript">
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var paket_ids = "{{ $paket['id'] }}"
    console.log(paket_ids)
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var app = new Vue({
    el: "#ikuti_form",
    data() {
      return {
        paket : {
            paket_id: paket_ids,
        },
        message: '',
      };
    },
    methods: {
      handleSubmit(){
            var $this = this
            var form = new FormData();
            //form.append('paket_id', this.paket.paket_id)
            fetch('{{ route('store-ikuti-paket') }}', {
                method:'post',
                body: JSON.stringify(this.paket),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf_token,
                }
            })
            .then(res => res.json())
            .then(function(data){
                if(data.status) {
                  $this.message = data.message
                  setTimeout(() => {
                        window.location.href = '{{ route('listpaket.index') }}'
                  }, 1500);
                }
                console.log(data)
            })
        }
    },
});
    
</script>
{{Html::script('js/kota.js')}}
@stop
