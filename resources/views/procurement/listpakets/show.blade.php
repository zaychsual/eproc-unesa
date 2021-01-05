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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:40%">Sumber Dana</th>
                                    <th style="width:30%">Kode Anggaran</th>
                                    <th style="width:30%">Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="tbDataSumberdana">
                                @forelse ($sumberdana as $item)
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            {{ Form::text('sumber_dana[]', $item->sumber_dana, array('class' => 'form-control', 'readonly', 'style' => 'color:black')) }}
                                        </div>  
                                        @if ($errors->has('sumber_dana'))
                                        <span class="help-block">{{$errors->first('sumber_dana')}}</span>
                                        @endif
                                    </td>
                                    <td>                                           
                                        {{ Form::number('kode_anggaran[]', $item->kode_anggaran, array('class' => 'form-control', 'rows' => 2, 'cols' => 40, 'readonly', 'style' => 'color:black')) }}
                                            @if ($errors->has('kode_anggaran'))
                                            <span class="help-block">{{$errors->first('kode_anggaran')}}</span>
                                            @endif
                                    </td>
                                    <td>                                           
                                        {{ Form::number('nilai[]', $item->nilai, array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                            @if ($errors->has('nilai'))
                                            <span class="help-block">{{$errors->first('nilai')}}</span>
                                            @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            {{ Form::text('sumber_dana[]', old('sumber_dana'), array('class' => 'form-control')) }}
                                        </div>  
                                        @if ($errors->has('sumber_dana'))
                                        <span class="help-block">{{$errors->first('sumber_dana')}}</span>
                                        @endif
                                    </td>
                                    <td>                                           
                                        {{ Form::number('kode_anggaran[]', old('kode_anggaran'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                            @if ($errors->has('kode_anggaran'))
                                            <span class="help-block">{{$errors->first('kode_anggaran')}}</span>
                                            @endif
                                    </td>
                                    <td>                                           
                                        {{ Form::number('nilai[]', old('nilai'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                            @if ($errors->has('nilai'))
                                            <span class="help-block">{{$errors->first('nilai')}}</span>
                                            @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <tr></tr>
                        <tr>
                            <td>Kualifikasi Usaha</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('kualifikasi_id', $data['kualifikasi_id'],$paket['kualifikasi_id'], ['class' => 'form-control kualifikasi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'kualifikasi_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Metode Kualifikasi</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('mtd_kualifikasi_id', $data['mtd_kualifikasi_id'],$paket['mtd_kualifikasi_id'], ['class' => 'form-control mtd_kualifikasi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'mtd_kualifikasi_id', 'placeholder' => '- Pilih Data -', 'required']) }}
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
                            <td>Dokumen Pengadaan</td>
                            <td>:</td>
                            <td>
                                <?php
                                    if($paket->link_file_dok_pengadaan)
                                    {
                                        $file_dok_pengadaan = explode("###", $paket->link_file_dok_pengadaan);
                                        $no = 1;
                                        for($i=0; $i<count($file_dok_pengadaan); $i++)
                                        {
                                ?>
                                <a href="{{URL::to('https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/eproc/dok_pengadaan/'.$file_dok_pengadaan[$i])}}" target="_blank">Lihat file {{$no}}</a><br>
                                <?php
                                    $no++;
                                    }
                                }
                                else
                                {
                                ?>
                                    <img id="uploadPreview" style="width: 50px; height: 100%;" src="{{ asset('ress/img/files-icon.png') }}"/><br>
                                <?php
                                }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kontrak</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('jeniskontrak_id', $data['jeniskontrak_id'], $paket['jeniskontrak_id'], ['class' => 'form-control jeniskontrak_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'jeniskontrak_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Link Rapat Penjelasan</td>
                            <td>:</td>
                            <td>
                                {{ Form::text('link', $paket['link'], array('class' => 'form-control', 'id'=>'link', 'required')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Setting Unduh (Open)</td>
                            <td>:</td>
                            <td>
                                {{ Form::date('setting_unduh_buka', $paket['setting_unduh_buka'], array('class' => 'form-control', 'id'=>'setting_unduh_buka', 'required')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Setting Unduh (Closed)</td>
                            <td>:</td>
                            <td>
                                {{ Form::date('setting_unduh_tutup', $paket['setting_unduh_tutup'], array('class' => 'form-control', 'id'=>'setting_unduh_tutup', 'required')) }}
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
                        <form action="" @submit.prevent="handleSubmit">
                            @csrf
                            <input type="hidden" v-model="paket.paket_id" name="paket_id" id="paket_id" :value="paket.paket_id">
                        <p>
                            <center> PAKTA INTEGRITAS</center>
                            <p>
                                Untuk Mengikuti pengadaan, Anda harus membaca dan menyetujui Pakta integritas dibawah ini: <br>
                                <br>
                                Saya menyetujui bahwa : <br>
                                1. Tidak akan melakukan praktek-praktek korupsi,kolusi dan Nepotisme (KKN)
                            </p>
                        </p>
                        <p v-if="message" style="background:#0095eb;padding:8px 6px;color:white;">@{{ message }}</p>
                        <button class="btn btn-info pull-right" id="submit"><i class="fa fa-save"></i> Setuju & ikuti paket</button>
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
