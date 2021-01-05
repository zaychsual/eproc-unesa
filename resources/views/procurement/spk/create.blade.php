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
<div class="row">
    <div class="col-md-12">
        {!! Form::open(array('url' => route('spk.store'), 'method' => 'POST', 'id' => 'pakets', 'class' => 'form-horizontal', 'files' => true)) !!}
        {!! csrf_field() !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Form</strong> </h3>
                </div>
                <div class="panel-body">
                    <div class="form-group @if ($errors->has('paket_id')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label">Nama Paket *</label>
                        <div class="col-md-6 col-xs-12">                                              
                            {{ Form::select('paket_id', $data['paket_id'], old('paket_id'), ['class' => 'form-control paket_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'paket_id', 'placeholder' => '- Pilih Data -', 'required']) }}
                            @if ($errors->has('paket_id'))
                                <span class="help-block">{{$errors->first('paket_id')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('no_spk')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>No. Surat Perintah Kerja*</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('no_spk', old('no_spk'), array('class' => 'form-control', 'id'=>'no_spk', 'required')) }}
                            </div>  
                                @if ($errors->has('no_spk'))
                                    <span class="help-block">{{$errors->first('no_spk')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('kota')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Kota Surat Perintah Kerja*</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('kota', old('kota'), array('class' => 'form-control', 'id'=>'kota', 'required')) }}
                            </div>  
                                @if ($errors->has('kota'))
                                    <span class="help-block">{{$errors->first('kota')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('date_in')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Tanggal. Surat Perintah Kerja*</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <input type="date" name="date_in" id="date_in">
                            </div>  
                                @if ($errors->has('kota'))
                                    <span class="help-block">{{$errors->first('kota')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('bank')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Nama Bank*</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('bank', old('bank'), array('class' => 'form-control', 'id'=>'bank', 'required')) }}
                            </div>  
                                @if ($errors->has('bank'))
                                    <span class="help-block">{{$errors->first('bank')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('no_rek')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Nomor Rekening*</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('no_rek', old('no_rek'), array('class' => 'form-control', 'id'=>'no_rek', 'required')) }}
                            </div>  
                                @if ($errors->has('no_rek'))
                                    <span class="help-block">{{$errors->first('no_rek')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('nama_ppk')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Nama PPK *</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('nama_ppk', old('nama_ppk'), array('class' => 'form-control', 'id'=>'nama_ppk', 'required')) }}
                            </div>  
                                @if ($errors->has('nama_ppk'))
                                    <span class="help-block">{{$errors->first('nama_ppk')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('nama_satuan_kerja')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Nama Satuan Kerja *</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('nama_satuan_kerja', old('nama_satuan_kerja'), array('class' => 'form-control', 'id'=>'nama_satuan_kerja', 'required')) }}
                            </div>  
                                @if ($errors->has('nama_satuan_kerja'))
                                    <span class="help-block">{{$errors->first('nama_satuan_kerja')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('nama_penyedia')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Nama Penyedia *</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('nama_penyedia', old('nama_penyedia'), array('class' => 'form-control', 'id'=>'nama_penyedia', 'required')) }}
                            </div>  
                                @if ($errors->has('nama_penyedia'))
                                    <span class="help-block">{{$errors->first('nama_penyedia')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('alamat_penyedia')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Alamat Penyedia *</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::textarea('alamat_penyedia', old('alamat_penyedia'), array('class' => 'form-control', 'id'=>'alamat_penyedia', 'required')) }}
                            </div>  
                                @if ($errors->has('alamat_penyedia'))
                                    <span class="help-block">{{$errors->first('alamat_penyedia')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('wakil_penyedia')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Wakil Penyedia *</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('wakil_penyedia', old('wakil_penyedia'), array('class' => 'form-control', 'id'=>'wakil_penyedia', 'required')) }}
                            </div>  
                                @if ($errors->has('wakil_penyedia'))
                                    <span class="help-block">{{$errors->first('wakil_penyedia')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('jabatan_penyedia')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Jabatan Wakil Penyedia *</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('jabatan_penyedia', old('jabatan_penyedia'), array('class' => 'form-control', 'id'=>'jabatan_penyedia', 'required')) }}
                            </div>  
                                @if ($errors->has('jabatan_penyedia'))
                                    <span class="help-block">{{$errors->first('jabatan_penyedia')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('nilai_kontrak')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Nilai Kontrak *</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('nilai_kontrak', old('nilai_kontrak'), array('class' => 'form-control', 'id'=>'nilai_kontrak', 'required')) }}
                            </div>  
                                @if ($errors->has('nilai_kontrak'))
                                    <span class="help-block">{{$errors->first('nilai_kontrak')}}</span>
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
                    <div class="row">
                        <div class="col">
                            <div class="form-group @if ($errors->has('start_date')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label"><b>Tanggal Mulai *</b></label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="date" name="start_date" id="start_date">
                                    </div>  
                                        @if ($errors->has('start_date'))
                                            <span class="help-block">{{$errors->first('start_date')}}</span>
                                        @endif                                          
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group @if ($errors->has('end_date')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label"><b>Tanggal Selesai *</b></label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="date" name="end_date" id="end_date">
                                    </div>  
                                        @if ($errors->has('end_date'))
                                            <span class="help-block">{{$errors->first('end_date')}}</span>
                                        @endif                                          
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Dokumen</label>
                        <div class="col-md-6 col-xs-12">  
                            {{ Form::file('link_file_dok_pengadaan[]', array('class'=>'fileinput btn-primary', 'id'=>'link_file_dok_pengadaan', 'data-filename-placement'=>'inside', 'title'=>'Browse file', 'multiple')) }}                                   

                            @if ($errors->has('link_file_dok_pengadaan'))
                            <span class="help-block">{{$errors->first('link_file_dok_pengadaan')}}</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                <div class="panel-footer">     
                    <a href="{{URL::to('/procurement/pakets')}}" class="btn btn-default pull-left">Batal</a>                               
                    <button class="btn btn-primary pull-left">Submit</button>
                    <a href="{{route('e-kontrak.print-spk',$paket_id)}}" target="_blank" class="btn btn-primary pull-right">Print</a>
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
        $('.paket_id').select2();
        $('.jeniskontrak_id').select2();
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
                            <input type="text" name="qty[]" id="qty_${indexHps}">
                        </td>
                        <td>
                            <input type="text" name="harga[]" id="harga_${indexHps}">
                        </td>
                        <td>
                            <input type="text" name="pajak[]" id="pajak_${indexHps}">
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

    /*  */
    
</script>
{{Html::script('js/kota.js')}}
@stop
