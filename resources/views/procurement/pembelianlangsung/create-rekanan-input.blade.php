@extends('webprofile.layouts.backend.slave')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('#')}}">Dashboard</a></li>
<li class="active"> {!! $title !!}</li>
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
                <li class="active"><a href="#tabInputRekanan" data-toggle="tab">Input Rekanan</a></li>
                <li class=""><a href="#tabInputPenawaranRekanan" data-toggle="tab">Penawaran Rekanan</a></li>
            </ul>
        </div>
        {!! Form::open(array('url' => route('pembelian-langsung.store-rekanan-input'), 'method' => 'POST', 'id' => 'rekanans', 'class' => 'form-horizontal')) !!}
        {!! csrf_field() !!}
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
        <input type="hidden" name="is_dpt" value="77">
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tabInputRekanan">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Pendaftaran</strong> Penyedia</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group @if ($errors->has('email')) has-error @endif">
                                                <label class="col-md-3 control-label">Email **</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-envelope"></span> </span>
                                                        {{ Form::text('email', old('email'), array('class' => 'form-control')) }}
                                                    </div>
                                                    @if ($errors->has('email'))
                                                    <span class="help-block">{{$errors->first('email')}}</span>
                                                    @endif                                          
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('nama')) has-error @endif">
                                                <label class="col-md-3 control-label">Nama Perusahaan *</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        {{ Form::text('nama', old('nama'), array('class' => 'form-control', 'required')) }}
                                                    </div>  
                                                        @if ($errors->has('nama'))
                                                        <span class="help-block">{{$errors->first('nama')}}</span>
                                                        @endif                                          
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('bentuk_usaha')) has-error @endif">
                                                <label class="col-md-3 col-xs-12 control-label">Bentuk Badan Usaha</label>
                                                <div class="col-md-9 col-xs-12">                                              
                                                    {{ Form::select('bentuk_usaha', $data['bentuk_usaha'], old('bentuk_usaha'), ['class' => 'form-control bentuk_usaha', 'style' => 'width: 100%;', 'id' => 'bentuk_usaha', 'placeholder' => '- Pilih Data -', 'required']) }}
                                                        @if ($errors->has('bentuk_usaha'))
                                                        <span class="help-block">{{$errors->first('bentuk_usaha')}}</span>
                                                        @endif
                                                </div>
                                            </div> 

                                            <div class="form-group @if ($errors->has('alamat')) has-error @endif">
                                                <label class="col-md-3 col-xs-12 control-label">Alamat *</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    {{ Form::textarea('alamat', old('alamat'), array('class' => 'form-control', 'required')) }}
                                                        @if ($errors->has('alamat'))
                                                        <span class="help-block">{{$errors->first('alamat')}}</span>
                                                        @endif
                                                </div>
                                            </div>  

                                            <div class="form-group @if ($errors->has('kode_pos')) has-error @endif">
                                                <label class="col-md-3 control-label">Kode Pos</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        {{ Form::number('kode_pos', old('kode_pos'), array('class' => 'form-control', 'maxlength' => '7')) }}
                                                    </div>  
                                                        @if ($errors->has('kode_pos'))
                                                        <span class="help-block">{{$errors->first('kode_pos')}}</span>
                                                        @endif                                          
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('provinsi_id')) has-error @endif">
                                                <label class="col-md-3 col-xs-12 control-label">Provinsi</label>
                                                <div class="col-md-9 col-xs-12">
                                                    {{ Form::select('provinsi_id', $data['provinsi'], old('provinsi_id'), ['class' => 'form-control provinsi_id', 'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'provinsi_id', 'placeholder' => '- Pilih Data -', 'required']) }}

                                                        @if ($errors->has('provinsi_id'))
                                                        <span class="help-block">{{$errors->first('provinsi_id')}}</span>
                                                        @endif
                                                </div>
                                            </div> 

                                            <div class="form-group @if ($errors->has('kota_id')) has-error @endif">
                                                <label class="col-md-3 col-xs-12 control-label">Kabupaten/Kota</label>
                                                <div class="col-md-9 col-xs-12">
                                                    {{ Form::select('kota_id', [], old('kota_id'), ['class' => 'form-control kota_id', 'style' => 'width: 100%;', 'id' => 'kota_id', 'placeholder' => '- Pilih Data -', 'required']) }}

                                                        @if ($errors->has('kota_id'))
                                                        <span class="help-block">{{$errors->first('kota_id')}}</span>
                                                        @endif
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group @if ($errors->has('telepon')) has-error @endif">
                                                <label class="col-md-3 control-label">Telepon *</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        {{ Form::text('telepon', old('telepon'), array('class' => 'form-control', 'required')) }}
                                                    </div>  
                                                        @if ($errors->has('telepon'))
                                                        <span class="help-block">{{$errors->first('telepon')}}</span>
                                                        @endif                                          
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('fax')) has-error @endif">
                                                <label class="col-md-3 control-label">Fax</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        {{ Form::text('fax', old('fax'), array('class' => 'form-control', 'id' => 'fax')) }}
                                                    </div>  
                                                        @if ($errors->has('fax'))
                                                        <span class="help-block">{{$errors->first('fax')}}</span>
                                                        @endif                                          
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('hp')) has-error @endif">
                                                <label class="col-md-3 control-label">Mobile Phone</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        {{ Form::number('hp', old('hp'), array('class' => 'form-control', 'id' => 'hp')) }}
                                                    </div>  
                                                        @if ($errors->has('hp'))
                                                        <span class="help-block">{{$errors->first('hp')}}</span>
                                                        @endif                                          
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('website')) has-error @endif">
                                                <label class="col-md-3 control-label">Website</label>
                                                <div class="col-md-9 col-xs-12">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        {{ Form::text('website', old('website'), array('class' => 'form-control', 'id' => 'website')) }}
                                                    </div>  
                                                        @if ($errors->has('website'))
                                                        <span class="help-block">{{$errors->first('website')}}</span>
                                                        @endif                                          
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('jenis_pengadaan')) has-error @endif">
                                                <label class="col-md-3 col-xs-12 control-label">Jenis Pengadaan *</label>
                                                <div class="col-md-9 col-xs-12">                                              
                                                    {{ Form::select('jenis_pengadaan', $data['jenis_pengadaan'], old('jenis_pengadaan'), ['class' => 'form-control jenis_pengadaan', 'style' => 'width: 100%;', 'id' => 'jenis_pengadaan', 'placeholder' => '- Pilih Data -', 'required']) }}
                                                        @if ($errors->has('jenis_pengadaan'))
                                                        <span class="help-block">{{$errors->first('jenis_pengadaan')}}</span>
                                                        @endif
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabInputPenawaranRekanan">
                    <div class="row">
                        <table class="table table-responsive">
                            <tr>
                                <th>Jenis Barang/Jasa</th>
                                <th>Satuan</th>
                                <th>Vol</th>
                                <th>Harga Penawaran</th>
                                <th>Pajak (%)</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                            </tr>
                            @foreach($paketHps as $key => $value)
                            <tr>
                                <input type="hidden" name="paket_hps_id[]" value="{{ $value->id }}">
                                <td>{{ $value->jenis_barang_jasa }}</td>
                                <td>{{ $value->satuan }}</td>
                                <td>{{ $value->qty }}</td>
                                <td><input type="number" name="harga_penawaran[]"></td>
                                <td>{{ $value->pajak }}</td>
                                <td>{{ $value->total }}</td>
                                <td>{{ $value->keterangan }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="panel-footer">     
                        <button class="btn btn-info pull-right" type="submit">Submit</button>
                    </div>
                </div>
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
        $('.bentuk_usaha').select2();
        $('.jenis_pengadaan').select2();
        $('.provinsi_id').select2();
        $('.kota_id').select2();
        $('.is_kantor_cabang').select2();
    });
</script>
{{Html::script('js/kota.js')}}
@stop
