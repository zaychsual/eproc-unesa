@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Tambah {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')

<!-- page start-->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <li>{{$errors->first()}}</li>
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        {!! Form::open(array('url' => route('pakets.store'), 'method' => 'POST', 'id' => 'pakets', 'class' => 'form-horizontal', 'files' => true)) !!}
        {!! csrf_field() !!}
        
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Form</strong> </h3>
                </div>
                <div class="panel-body">
                    <div class="form-group @if ($errors->has('kode_rup')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Kode REGINA/RUP</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::number('kode_rup', old('kode_rup'), array('class' => 'form-control', 'required')) }}
                            </div>  
                                @if ($errors->has('kode_rup'))
                                <span class="help-block">{{$errors->first('kode_rup')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('nama')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Nama Paket</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('nama', old('nama'), array('class' => 'form-control', 'id'=>'nama', 'required')) }}
                            </div> 
                                @if ($errors->has('nama'))
                                <span class="help-block">{{$errors->first('nama')}}</span>
                                @endif                                           
                        </div>
                    </div>

                    <div class="form-group @if ($errors->has('klpd_id')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">K/L/PD</label>
                        <div class="col-md-6 col-xs-12">                                              
                            {{ Form::select('klpd_id', $data['klpd_id'], old('klpd_id'), ['class' => 'form-control klpd_id', 'style' => 'width: 100%;', 'id' => 'klpd_id', 'placeholder' => 'Pilih Data', 'required']) }}
                                @if ($errors->has('klpd_id'))
                                <span class="help-block">{{$errors->first('klpd_id')}}</span>
                                @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->has('satuankerja_id')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Satuan Kerja</label>
                        <div class="col-md-6 col-xs-12">                                              
                            {{ Form::select('satuankerja_id',$data['satuankerja_id'], '9f4ca0a0-b1e0-11ea-8c84-830238e6326e', ['class' => 'form-control satuankerja_id', 'style' => 'width: 100%;', 'id' => 'satuankerja_id', 'placeholder' => 'Pilih Data', 'required']) }}
                                @if ($errors->has('satuankerja_id'))
                                <span class="help-block">{{$errors->first('satuankerja_id')}}</span>
                                @endif
                        </div>
                    </div> 

                    <div class="form-group @if ($errors->has('pagu')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Nilai Pagu Paket</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::number('pagu', old('pagu'), array('class' => 'form-control', 'id'=>'pagu', 'required')) }}
                            </div> 
                                @if ($errors->has('pagu'))
                                <span class="help-block">{{$errors->first('pagu')}}</span>
                                @endif                                           
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Lokasi Pekerjaan</label>
                        <div class="col-md-6 col-xs-12">                                              
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Provinsi*</th>
                                        <th style="width:45%">Kabupaten/Kota*</th>
                                        <th style="width:35%">Detail Lokasi*</th>
                                    </tr>
                                </thead>
                                <tbody id="tbDataLokasi">
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
                                </tbody>
                                
                            </table>
                        </div>
                    </div> 

                    <div class="form-group @if ($errors->has('category_id')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Metode Pemilihan</label>
                        <div class="col-md-6 col-xs-12">
                            {{ Form::text('nama', 'Pembelian Langsung', array('class' => 'form-control', 'id'=>'nama', 'disabled')) }}
                            <input type="hidden" name="category_id" id="category_id" value="abab07b0-0e6e-11eb-adc1-0242ac120002">
                            {{-- {{ Form::select('category_id', $data['category'], 'abab07b0-0e6e-11eb-adc1-0242ac120002', ['class' => 'form-control category_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'category_id', 'placeholder' => '- Pilih Data -', 'readonly']) }} --}}
                            @if ($errors->has('category_id'))
                            <span class="help-block">{{$errors->first('category_id')}}</span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group @if ($errors->has('tahun_id')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Tahun Anggaran</label>
                        <div class="col-md-6 col-xs-12">                                              
                            {{ Form::select('tahun_id', $data['tahun_id'], old('tahun_id'), ['class' => 'form-control tahun_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'tahun_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            @if ($errors->has('tahun_id'))
                            <span class="help-block">{{$errors->first('tahun_id')}}</span>
                            @endif
                        </div>
                    </div> 

                    <div class="form-group @if ($errors->has('jenispengadaan_id')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Jenis Pengadaan *</label>
                        <div class="col-md-6 col-xs-12">                                              
                            {{ Form::select('jenispengadaan_id', $data['jenispengadaan_id'], old('jenispengadaan_id'), ['class' => 'form-control jenispengadaan_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'jenispengadaan_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            @if ($errors->has('jenispengadaan_id'))
                            <span class="help-block">{{$errors->first('jenispengadaan_id')}}</span>
                            @endif
                        </div>
                    </div>  

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Anggaran</label>
                        <div class="col-md-6 col-xs-12">                                              
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Sumber Dana</th>
                                        <th style="width:30%">Kode Anggaran</th>
                                        <th style="width:30%">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody id="tbDataSumberdana">
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                {{ Form::text('sumber_dana[]', old('sumber_dana'), array('class' => 'form-control', 'required')) }}
                                            </div>  
                                            @if ($errors->has('sumber_dana'))
                                            <span class="help-block">{{$errors->first('sumber_dana')}}</span>
                                            @endif
                                        </td>
                                        <td>                                           
                                            {{ Form::number('kode_anggaran[]', old('kode_anggaran'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40, 'required')) }}
                                                @if ($errors->has('kode_anggaran'))
                                                <span class="help-block">{{$errors->first('kode_anggaran')}}</span>
                                                @endif
                                        </td>
                                        <td>                                           
                                            {{ Form::number('nilai[]', old('nilai'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40, 'required')) }}
                                                @if ($errors->has('nilai'))
                                                <span class="help-block">{{$errors->first('nilai')}}</span>
                                                @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> 

                    <div class="form-group @if ($errors->has('kualifikasi_id')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Kualifikasi Usaha</label>
                        <div class="col-md-6 col-xs-12">                                              
                            {{ Form::select('kualifikasi_id', $data['kualifikasi_id'], old('kualifikasi_id'), ['class' => 'form-control kualifikasi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'kualifikasi_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            @if ($errors->has('kualifikasi_id'))
                            <span class="help-block">{{$errors->first('kualifikasi_id')}}</span>
                            @endif
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Dokumen Pengadaan</label>
                        <div class="col-md-6 col-xs-12">  
                            {{ Form::file('link_file_dok_pengadaan[]', array('class'=>'fileinput btn-primary', 'id'=>'link_file_dok_pengadaan', 'data-filename-placement'=>'inside', 'title'=>'Browse file', 'required', 'multiple')) }}                                   

                            @if ($errors->has('link_file_dok_pengadaan'))
                            <span class="help-block">{{$errors->first('link_file_dok_pengadaan')}}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->has('jeniskontrak_id')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Jenis Kontrak</label>
                        <div class="col-md-6 col-xs-12">                                              
                            {{ Form::select('jeniskontrak_id', $data['jeniskontrak_id'], old('jeniskontrak_id'), ['class' => 'form-control jeniskontrak_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'jeniskontrak_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            @if ($errors->has('jeniskontrak_id'))
                                <span class="help-block">{{$errors->first('jeniskontrak_id')}}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->has('link')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Link Rapat Penjelasan</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('link', old('link'), array('class' => 'form-control', 'id'=>'link', 'required')) }}
                            </div> 
                                @if ($errors->has('link'))
                                <span class="help-block">{{$errors->first('link')}}</span>
                                @endif                                           
                        </div>
                    </div>
                    
                    <div class="form-group @if ($errors->has('nilai_hps')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Nilai HPS</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::number('nilai_hps', old('nilai_hps'), array('class' => 'form-control', 'id'=>'nilai_hps', 'required')) }}
                                <input type="hidden" name="valid_hps" id="valid_hps" value="" disabled>
                            </div> 
                                @if ($errors->has('nilai_hps'))
                                <span class="help-block">{{$errors->first('nilai_hps')}}</span>
                                @endif                                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Rincian HPS</label>
                        <div class="col-md-6 col-xs-12">                                              
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Jenis Barang/Jasa</th>
                                        <th style="width:30%">Satuan</th>
                                        <th style="width:30%">Vol</th>
                                        <th style="width:30%">Harga</th>
                                        <th style="width:30%">Pajak(%)</th>
                                        <th style="width:30%">Keterangan</th>
                                        <th style="width:30%"></th>
                                    </tr>
                                </thead>
                                <tbody id="hps">
                                    <tr>
                                        <td>
                                            <input type="text" name="jenis_barang_jasa[]" id="jenis_barang_jasa_0">
                                        </td>
                                        <td>
                                            <input type="text" name="satuan[]" id="satuan_0">
                                        </td>
                                        <td>
                                            {{ Form::number('qty[]', old('qty'), array('id' => 'qty_0')) }}
                                        </td>
                                        <td>
                                            {{ Form::number('harga[]', old('harga'), array('id' => 'harga_0')) }}
                                        </td>
                                        <td>
                                            {{ Form::number('pajak[]', old('pajak'), array('id' => 'pajak_0')) }}
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan[]" id="keterangan_0">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" id="add_hps">
                                            <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Pemilih penyedia</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <select name="is_pic" id="is_pic" class="form-control">
                                    <option value=""> -- Pilih --</option>
                                    <option value="10"> Pokja</option>
                                    <option value="20" selected> Pejabat Pengadaan</option>
                                </select>
                            </div>                                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Pejabat Pengadaan</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                {{ Form::select('pejabat_id',$data['pejabat_id'], old('pejabat_id'), ['class' => 'form-control pejabat_id', 'style' => 'width: 100%;', 'id' => 'pejabat_id', 'placeholder' => 'Pilih Data']) }}
                            </div>                                      
                        </div>
                    </div>
                </div>
                <hr>
                <div class="panel-footer">     
                    <a href="{{URL::to('/procurement/pakets')}}" class="btn btn-default pull-left">Batal</a>                               
                    <button class="submit btn btn-primary pull-right">Submit</button>
                </div>
            </div>
        {!! Form::close() !!}
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
    $('#npwp').mask("00.000.000.0-000.000", {placeholder: "__.___.___._-___.___"});
    $('#telepon').mask("#");
    $('#fax').mask("#");
    $('#hp').mask("#");


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
        $('.rekanan_id').select2();
    });
</script>

<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    function createRowSumberdana()
    {
        $(function () {
            $.get("{{URL::to('procurement/sumberdana')}}", function (data) {
                $("#tbDataSumberdana").append(data);
            });
        });
    }
    function createRowLokasi()
    {
        $(function () {
            $.get("{{URL::to('procurement/lokasi')}}", function (data) {
                $("#tbDataLokasi").append(data);
            });
        });
    }

    $("#jenispengadaan_id").change(function() {
        let jenis_pengadaan = $("#jenispengadaan_id").val();
        let category_id = $("#category_id").val();
        var base_url = window.location.origin;
        $.ajax({
            url: base_url + '/procurement/validasi-paket',
            type: 'get',
            data : {
                jenis_pengadaan : jenis_pengadaan,
                category_id : category_id,
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                let nilaiHPS = Math.round(response.nilai_hps);
                $("#valid_hps").val(nilaiHPS);
            }
        });
    });

    $(document).on('click', '.submit', function(e) {
        let nilaiHPS = $("#valid_hps").val();
        let hps = $("#nilai_hps").val();
        var base_url = window.location.origin;
        
        if(parseInt(hps) < parseInt(nilaiHPS)) {
            e.preventDefault();
            alert('nilai HPS tidak boleh < Rp. '+keyupFormatUang(nilaiHPS));
        }
    });

        //def
    let indexHps = 1
    let indexKak = 1
    let indexRancangan = 1
    let indexDataDukung = 1

    $(document).ready(function() {

        // === draw izin usaha == //
        $("#add_hps").click(function() {
            let htmlHps = `
                    <tr data-id="${indexHps}">
                        <td>
                            <input type="text" name="jenis_barang_jasa[]" id="jenis_barang_jasa_${indexHps}">
                        </td>
                        <td>
                            <input type="text" name="satuan[]" id="satuan_${indexHps}">
                        </td>
                        <td>
                            {{ Form::number('qty[]', old('qty'), array('id' => 'qty_${indexHps}')) }}
                        </td>
                        <td>
                            {{ Form::number('harga[]', old('harga'), array('id' => 'harga_${indexHps}')) }}
                        </td>
                        <td>
                            {{ Form::number('pajak[]', old('pajak'), array('id' => 'pajak_${indexHps}')) }}
                        </td>
                        <td>
                            <input type="text" name="keterangan[]" id="keterangan_${indexHps}">
                        </td>
                        <td>
                            <a href="javascript:;" class="remove-item btn btn-danger btn-sm" onclick="this.parentNode.parentNode.remove()">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
            `
            $("#hps").append(htmlHps)

            indexHps++
        })

        $("#add_kak").click(function() {
            let htmlKak = `
                <tr data-id="${indexKak}">
                    <td>
                        <input type="file" name="files_kak[]" id="files_${indexKak}">
                    </td>
                    <td>
                        <input type="date" name="tanggal_upload_kak[]" id="tanggal_upload_${indexKak}">
                    </td>
                    <td>
                        <a href="javascript:;" class="remove-item btn btn-danger btn-sm" onclick="this.parentNode.parentNode.remove()">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
            `
            $("#kak").append(htmlKak)

            indexKak++
        })

        $("#add_rancangan_kontrak").click(function() {
            let htmlRancangan = `
                <tr data-id="${indexRancangan}">
                    <td>
                        <input type="file" name="files_rancangan_kontrak[]" id="files_${indexRancangan}">
                    </td>
                    <td>
                        <input type="date" name="tanggal_upload_rancangan[]" id="tanggal_upload_${indexRancangan}">
                    </td>
                    <td>
                        <a href="javascript:;" class="remove-item btn btn-danger btn-sm" onclick="this.parentNode.parentNode.remove()">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
            `
            $("#rancangan_kontrak").append(htmlRancangan)

            indexRancangan++
        })

        $("#add_data_dukung").click(function() {
            let htmlDataDukuung = `
                <tr data-id="${indexDataDukung}">
                    <td>
                        <input type="file" name="files_data_dukung[]" id="files_${indexDataDukung}">
                    </td>
                    <td>
                        <input type="date" name="tanggal_upload_data_dukung[]" id="tanggal_upload_${indexDataDukung}">
                    </td>
                    <td>
                        <a href="javascript:;" class="remove-item btn btn-danger btn-sm" onclick="this.parentNode.parentNode.remove()">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
            `
            $("#data_dukung").append(htmlDataDukuung)

            indexDataDukung++
        })
        // end
    })

    window.leadingZero = function(value, element, decimal = false) {
        var convert_number = removeChar(value);
        if (convert_number) {
            element.val(parseInt(convert_number).toLocaleString('id-ID'))
            return
        }
        if (decimal) {
            if (value != '') {
                element.val(keyupFormatUangWithDecimal(value));
            } else {
                element.val(0);
            }
        } else {
            if (value != '') {
                element.val(keyupFormatUang(parseInt(convert_number)));
            } else {
                element.val(0);
            }
        }
    }

    function removeChar(value) {
        return value.toString().replace(/[.*+?^${}()|[\]\\]/g, '');
    }

    window.keyupFormatUang = function(value) {
        var number = '';
        var value_rev = value.toString().split('').reverse().join('');

        for (var i = 0; i < value_rev.length; i++) {
            if (i % 3 == 0) number += value_rev.substr(i, 3) + '.';
        }

        return number.split('', number.length - 1).reverse().join('');
    }



    window.keyupFormatUangWithDecimal = function(value) {
        return value.replace(/^0+/, '').replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g,
            "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
</script>
{{Html::script('js/kota.js')}}
@stop