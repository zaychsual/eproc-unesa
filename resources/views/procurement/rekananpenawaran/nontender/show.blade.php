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
                            <td>Kode Paket</td>
                            <td>:</td>
                            <td>{{ Form::number('kode_paket', $paket['kode'], array('class' => 'form-control', '')) }}</td>
                        </tr>
                        <tr>
                            <td>Tahap Paket Saat ini</td>
                            <td>:</td>
                            <td>
                                <a class="btn btn-success" href="">
                                    Upload Dokumen Penawaran
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
                                        <a href="{{ asset('uploads/file/'.isset($paketDokPemilihan->dokumen) ) }}" target="_blank">
                                            <p>[ {{ isset($paketDokPemilihan->nomor_dokumen) ?? '-' }} ] - {{ isset($paketDokPemilihan->dokumen) ?? '-'}}</p>
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
                                            <a href="{{ route('penawaran.input-kualifikasi', \Crypt::encrypt($paket->id)) }}" class="btn btn-primary">
                                                Kirim Data
                                            </a>
                                            <a href="" target="_blank" class="btn btn-primary">
                                                Status : Belum Dikirim, Jadwal Pengiriman : &nbsp; s.d &nbsp;
                                                   
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
                                            $buttons = 'hide';
                                        @endphp
                                        <p>
                                            Surat Penawaran : <span class="badge badge-success">Sudah Dikirim, ({{ \tglindo($submitDates->created_at) }})</span> <br>
                                            <br>
                                            Dokumen Harga : <span class="badge badge-success">Sudah Dikirim, ({{ \tglindo($submitDates->created_at) }})</span> <br>
                                            <br>
                                            Dokumen Teknis : <span class="badge badge-success">Sudah Dikirim, ({{ \tglindo($submitDates->created_at) }})</span> <br>
                                        </p> 

                                        @endif
                                        <hr/>
                                        <p>
                                            Total Penawaran : Rp. <span class="badge badge-info">{{ countTotalPenawaran($paket->id, Auth::user()->mt_rekanan_id)->totalpenawaran ?? 0 }}</span>
                                        </p>
                                        @if($buttons == 'show')
                                        <p class="pull-right">
                                            <a class="btn btn-rounded btn-info" href="{{ route('laman-nontender.input-penawaran', \Crypt::encrypt($paket->id)) }}">Kirim Penawaran</a>
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
