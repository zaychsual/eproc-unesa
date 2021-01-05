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
@php
    $lokasi = $data['lokasi'];
    $sumberdana = $data['sumberdana'];
@endphp

<!-- page start-->
<div class="row">
	<div class="col-md-6">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Detail</strong> PPK</h3>
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
                            <td>K/L/PD</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('klpd_id', $data['klpd_id'], $paket['klpd_id'], ['class' => 'form-control klpd_id', 'style' => 'width: 100%;', 'id' => 'klpd_id', 'placeholder' => 'Pilih Data', 'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Satuan Kerja</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('satuankerja_id',$data['satuankerja_id'], $paket['satuankerja_id'], ['class' => 'form-control satuankerja_id', 'style' => 'width: 100%;', 'id' => 'satuankerja_id', 'placeholder' => 'Pilih Data', 'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai Pagu Paket</td>
                            <td>:</td>
                            <td>
                                {{ Form::number('pagu', $paket['pagu'], array('class' => 'form-control', 'id'=>'pagu', 'required')) }}
                            </td>
                        </tr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:20%">Provinsi*</th>
                                    <th style="width:45%">Kabupaten/Kota*</th>
                                    <th style="width:35%">Detail Lokasi*</th>
                                </tr>
                            </thead>
                            <tbody id="tbDataLokasi">
                                @forelse ($lokasi as $item)
                                <tr>
                                    <td>
                                        {{ Form::select('provinsi_id[]', $data['provinsi'], $item->provinsi_id, ['class' => 'form-control provinsi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'provinsi_id', 'placeholder' => '- Pilih Data -', 'required']) }}

                                        @if ($errors->has('provinsi_id'))
                                        <span class="help-block">{{$errors->first('provinsi_id')}}</span>
                                        @endif
                                    </td>
                                    <td>                                           
                                        {{ Form::select('kota_id[]', $data['kota'], $item->kota_id, ['class' => 'form-control kota_id', 'style' => 'width: 100%;', 'id' => 'kota_id', 'placeholder' => '- Pilih Data -', 'required']) }}

                                        @if ($errors->has('kota_id'))
                                        <span class="help-block">{{$errors->first('kota_id')}}</span>
                                        @endif
                                    </td>
                                    <td>                                           
                                        {{ Form::textarea('alamat[]', $item->alamat, array('class' => 'form-control', 'rows' => 2, 'cols' => 40, 'required')) }}
                                            @if ($errors->has('alamat'))
                                            <span class="help-block">{{$errors->first('alamat')}}</span>
                                            @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td>
                                        {{ Form::select('provinsi_id[]', $data['provinsi'], old('provinsi_id'), ['class' => 'form-control provinsi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'provinsi_id', 'placeholder' => '- Pilih Data -', 'required']) }}

                                        @if ($errors->has('provinsi_id'))
                                        <span class="help-block">{{$errors->first('provinsi_id')}}</span>
                                        @endif
                                    </td>
                                    <td>                                           
                                        {{ Form::select('kota_id[]', [], old('kota_id'), ['class' => 'form-control kota_id', 'style' => 'width: 100%;', 'id' => 'kota_id', 'placeholder' => '- Pilih Data -', 'required']) }}

                                        @if ($errors->has('kota_id'))
                                        <span class="help-block">{{$errors->first('kota_id')}}</span>
                                        @endif
                                    </td>
                                    <td>                                           
                                        {{ Form::textarea('alamat[]', old('alamat'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40, 'required')) }}
                                            @if ($errors->has('alamat'))
                                            <span class="help-block">{{$errors->first('alamat')}}</span>
                                            @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('category_id',$data['category_id'], $paket['category_id'], ['class' => 'form-control category_id', 'style' => 'width: 100%;', 'id' => 'category_id', 'placeholder' => 'Pilih Data', 'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tahun Anggaran</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('tahun_id', $data['tahun_id'], $paket['tahun_id'], ['class' => 'form-control tahun_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'tahun_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Pengadaan</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('jenispengadaan_id', $data['jenispengadaan_id'], $paket['jenispengadaan_id'], ['class' => 'form-control jenispengadaan_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'jenispengadaan_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai HPS</td>
                            <td>:</td>
                            <td>
                                {{ Form::number('nilai_hps', $paket['nilai_hps'], array('class' => 'form-control', 'id'=>'nilai_hps', 'required')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kontrak</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('jeniskontrak_id', $data['jeniskontrak_id'], $paket['jeniskontrak_id'], ['class' => 'form-control jeniskontrak_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'jeniskontrak_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </td>
                        </tr>
                    </table>
	            </div>
	        </div>
	    </div>
	</div>
    <div class="col-md-6">
        <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Mengikuti Paket</strong></h3>
	        </div>
	        <div class="panel-body">
                <div id="ikuti_form">
                    <div class="row">
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Jenis Izin</th>
                                    <th>Klasifikasi</th>
                                </tr>
                                @foreach($data['lembarIzin'] as $key => $value)
                                    <tr>
                                        <td>{{ $value->jenis_izin }}</td>
                                        <td>{{ $value->klasifikasi }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <table>
                                <tr>
                                    <td>
                                        &nbsp; Memiliki TDP atau NIB
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; Memiliki NPWP
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; Telah melunasi kewajiban pajak tahun terakhir
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; Mempunyai atau menguasai tempat usaha/kantor dengan alamat yang benar, dan jelas berupa milik sendiri atau sewa
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; Secara hukum mempunyai kapasitas untuk meningkatkan diri pada kontrak yang dibuktikan dengan : <br>
                                        a) Akta pendirian perusahaan dan/atau perubahannya(akta perubahan bisa berlaku seluruhnya) <br>
                                        b) Surat kuasa (Apabila dikuasakan) <br>
                                        c) Bukti bahwa yang diberikan kuasa merupakan pegawai tetap (apabila dikuasakan) dan <br>
                                        d) KTP
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; Surat pernyataan <br>
                                        a) Yang bersangkutan dan menajemennya tidak dalam pengawasan pengadilan, tidak pailit dan kegiatan usahanya tidak sedang dihentikan <br>
                                        b) Yang bersangkutan berikut pengurus badan usaha tidak sedang dikenakan sanksi daftar hitam 
                                        c)
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; Tidak masuk dalam daftar hitam
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; Dalam hal peserta akan melakukan konsorsium/kerja sama operasi/kemitraan/bentuk kerjasama lain harus mempunyai perjanjian
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp; Pengalaman pekerjaan
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <form action="{{ route('paket-baru.store-ikut-paket') }}" method="post">
                            @csrf
                            <input type="hidden" name="paket_id" id="paket_id" value="{{ $paket->id }}">
                            <input type="hidden" name="is_tender" id="is_tender" value="{{ $data['is_tender'] }}">
                        <p>
                            <center> PAKTA INTEGRITAS</center>
                            <p>
                                Untuk Mengikuti pengadaan, Anda harus membaca dan menyetujui Pakta integritas dibawah ini: <br>
                                <br>
                                Saya menyetujui bahwa : <br>
                                1. Tidak akan melakukan praktek-praktek korupsi,kolusi dan Nepotisme (KKN)
                            </p>
                        </p>
                        {{-- <p v-if="message" style="background:#0095eb;padding:8px 6px;color:white;">@{{ message }}</p> --}}
                        <button class="btn btn-info pull-right" id="submit" type="submit"><i class="fa fa-save"></i> Setuju & ikuti paket</button>
                        &nbsp;&nbsp;
                        </form>
                    </div>
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
{{Html::script('js/kota.js')}}
@stop
