@extends('webprofile.layouts.backend.app')

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
    $data = $row['data'];
    $pengalaman = $row['pengalaman'];
    $pendidikan = $row['pendidikan'];
    $sertifikat = $row['sertifikat'];
    $bahasa = $row['bahasa'];
@endphp
<!-- page start-->
<div class="row">
    <div class="col-md-12">

      {!! Form::model($data, ['route' => ['tenagaahlis.update', $data->id], 'method'=>'patch', 'class'=>'form-horizontal']) !!}
      {!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('nama')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Nama *</label>
                            <div class="col-md-9 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {{ Form::text('nama', old('nama'), array('class' => 'form-control')) }}
                                </div>  
                                    @if ($errors->has('nama'))
                                    <span class="help-block">{{$errors->first('nama')}}</span>
                                    @endif                                          
                            </div>
                        </div>
                        <div class="form-group">                                        
                            <label class="col-md-3 col-xs-12 control-label">Tanggal Lahir *</label>
                            <div class="col-md-9 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    {{ Form::text('tanggal_lahir', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                                </div>
                                @if ($errors->has('tanggal_lahir'))
                                    <span class="help-block">{{$errors->first('tanggal_lahir')}}</span>
                                    @endif 
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('alamat')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Alamat *</label>
                            <div class="col-md-9 col-xs-12">                                            
                                {{ Form::textarea('alamat', old('alamat'), array('class' => 'form-control')) }}
                                    @if ($errors->has('alamat'))
                                    <span class="help-block">{{$errors->first('alamat')}}</span>
                                    @endif
                            </div>
                        </div>    
                        <div class="form-group @if ($errors->has('pendidikan_terakhir')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Pendidikan Terakhir *</label>
                            <div class="col-md-9 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {{ Form::text('pendidikan_terakhir', old('pendidikan_terakhir'), array('class' => 'form-control')) }}
                                </div> 
                                    @if ($errors->has('pendidikan_terakhir'))
                                    <span class="help-block">{{$errors->first('pendidikan_terakhir')}}</span>
                                    @endif                                           
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Email</label>
                            <div class="col-md-9 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {{ Form::text('email', old('email'), array('class' => 'form-control')) }}
                                </div> 
                                    @if ($errors->has('email'))
                                    <span class="help-block">{{$errors->first('email')}}</span>
                                    @endif                                           
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('keahlian')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Profesi/Keahlian *</label>
                            <div class="col-md-9 col-xs-12">                                            
                                {{ Form::textarea('keahlian', old('keahlian'), array('class' => 'form-control')) }}
                                    @if ($errors->has('keahlian'))
                                    <span class="help-block">{{$errors->first('keahlian')}}</span>
                                    @endif
                            </div>
                        </div>                     
                    </div>
                
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('jenis_kelamin')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Jenis Kelamin *</label>
                            <div class="col-md-9 col-xs-12">                                              
                                {{ Form::select('jenis_kelamin', array('Pria' => 'Pria', 'Wanita' => 'Wanita'), old('jenis_kelamin'), ['class' => 'form-control jenis_kelamin', 'style' => 'width: 100%;', 'id' => 'jenis_kelamin', 'placeholder' => 'Pilih', 'required']) }}
                                    @if ($errors->has('jenis_kelamin'))
                                    <span class="help-block">{{$errors->first('jenis_kelamin')}}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('kewarganegaraan')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Kewarganegaraan</label>
                            <div class="col-md-9 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {{ Form::text('kewarganegaraan', old('kewarganegaraan'), array('class' => 'form-control')) }}
                                </div> 
                                    @if ($errors->has('kewarganegaraan'))
                                    <span class="help-block">{{$errors->first('kewarganegaraan')}}</span>
                                    @endif                                           
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('pengalaman_kerja')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Pengalaman Kerja (Tahun) *</label>
                            <div class="col-md-9 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {{ Form::text('pengalaman_kerja', old('pengalaman_kerja'), array('class' => 'form-control')) }}
                                </div> 
                                    @if ($errors->has('pengalaman_kerja'))
                                    <span class="help-block">{{$errors->first('pengalaman_kerja')}}</span>
                                    @endif                                           
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('status_kepegawaian')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Status Kepegawaian *</label>
                            <div class="col-md-9 col-xs-12">                                              
                                {{ Form::select('status_kepegawaian', array('Tetap' => 'Tetap', 'Tidak Tetap' => 'Tidak Tetap'), old('status_kepegawaian'), ['class' => 'form-control status_kepegawaian', 'style' => 'width: 100%;', 'id' => 'status_kepegawaian', 'placeholder' => 'Pilih', 'required']) }}
                                    @if ($errors->has('status_kepegawaian'))
                                    <span class="help-block">{{$errors->first('status_kepegawaian')}}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('jabatan')) has-error @endif">
                            <label class="col-md-3 col-xs-12 control-label">Jabatan</label>
                            <div class="col-md-9 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {{ Form::text('jabatan', old('jabatan'), array('class' => 'form-control')) }}
                                </div> 
                                    @if ($errors->has('jabatan'))
                                    <span class="help-block">{{$errors->first('jabatan')}}</span>
                                    @endif                                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title"><strong>Pengalaman</strong> </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:20%">Tahun</th>
                                    <th style="width:75%">Uraian</th>
                                    <th style="width:5%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="tbDataPengalaman">
                                @forelse ($pengalaman as $item)
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                {{ Form::text('pengalaman_tahun[]', $item->tahun, array('class' => 'form-control')) }}
                                            </div>  
                                            @if ($errors->has('pengalaman_tahun'))
                                            <span class="help-block">{{$errors->first('pengalaman_tahun')}}</span>
                                            @endif
                                        </td>
                                        <td>                                           
                                            {{ Form::textarea('pengalaman_uraian[]', $item->uraian, array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                                @if ($errors->has('pengalaman_uraian'))
                                                <span class="help-block">{{$errors->first('pengalaman_uraian')}}</span>
                                                @endif
                                        </td>
                                        <td>
                                            <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                {{ Form::text('pengalaman_tahun[]', old('pengalaman_tahun'), array('class' => 'form-control')) }}
                                            </div>  
                                            @if ($errors->has('pengalaman_tahun'))
                                            <span class="help-block">{{$errors->first('pengalaman_tahun')}}</span>
                                            @endif
                                        </td>
                                        <td>                                           
                                            {{ Form::textarea('pengalaman_uraian[]', old('pengalaman_uraian'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                                @if ($errors->has('pengalaman_uraian'))
                                                <span class="help-block">{{$errors->first('pengalaman_uraian')}}</span>
                                                @endif
                                        </td>
                                        <td>
                                            <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <a id="btnAddPengalaman" class="btn btn-default btn-rounded" onclick="createRowPengalaman()">Tambah</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title"><strong>Pendidikan</strong> </h3>
            </div>
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:20%">Tahun</th>
                                    <th style="width:75%">Uraian</th>
                                    <th style="width:5%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="tbDataPendidikan">
                                @forelse ($pendidikan as $item)
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                {{ Form::text('pendidikan_tahun[]', $item->tahun, array('class' => 'form-control')) }}
                                            </div>  
                                            @if ($errors->has('pendidikan_tahun'))
                                            <span class="help-block">{{$errors->first('pendidikan_tahun')}}</span>
                                            @endif
                                        </td>
                                        <td>                                           
                                            {{ Form::textarea('pendidikan_uraian[]', $item->uraian, array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                                @if ($errors->has('pendidikan_uraian'))
                                                <span class="help-block">{{$errors->first('pendidikan_uraian')}}</span>
                                                @endif
                                        </td>
                                        <td>
                                            <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                {{ Form::text('pendidikan_tahun[]', old('pendidikan_tahun'), array('class' => 'form-control')) }}
                                            </div>  
                                            @if ($errors->has('pendidikan_tahun'))
                                            <span class="help-block">{{$errors->first('pendidikan_tahun')}}</span>
                                            @endif
                                        </td>
                                        <td>                                           
                                            {{ Form::textarea('pendidikan_uraian[]', old('pendidikan_uraian'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                                @if ($errors->has('pendidikan_uraian'))
                                                <span class="help-block">{{$errors->first('pendidikan_uraian')}}</span>
                                                @endif
                                        </td>
                                        <td>
                                            <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <a id="btnAddPendidikan" class="btn btn-default btn-rounded" onclick="createRowPendidikan()">Tambah</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title"><strong>Sertifikat</strong> </h3>
            </div>
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:20%">Tahun</th>
                                    <th style="width:75%">Uraian</th>
                                    <th style="width:5%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="tbDataSertifikat">
                                @forelse ($sertifikat as $item)
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                {{ Form::text('sertifikat_tahun[]', $item->tahun, array('class' => 'form-control')) }}
                                            </div>  
                                            @if ($errors->has('sertifikat_tahun'))
                                            <span class="help-block">{{$errors->first('sertifikat_tahun')}}</span>
                                            @endif
                                        </td>
                                        <td>                                           
                                            {{ Form::textarea('sertifikat_uraian[]', $item->uraian, array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                                @if ($errors->has('sertifikat_uraian'))
                                                <span class="help-block">{{$errors->first('sertifikat_uraian')}}</span>
                                                @endif
                                        </td>
                                        <td>
                                            <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                {{ Form::text('sertifikat_tahun[]', old('sertifikat_tahun'), array('class' => 'form-control')) }}
                                            </div>  
                                            @if ($errors->has('sertifikat_tahun'))
                                            <span class="help-block">{{$errors->first('sertifikat_tahun')}}</span>
                                            @endif
                                        </td>
                                        <td>                                           
                                            {{ Form::textarea('sertifikat_uraian[]', old('sertifikat_uraian'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                                @if ($errors->has('sertifikat_uraian'))
                                                <span class="help-block">{{$errors->first('sertifikat_uraian')}}</span>
                                                @endif
                                        </td>
                                        <td>
                                            <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <a id="btnAddSertifikat" class="btn btn-default btn-rounded" onclick="createRowSertifikat()">Tambah</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title"><strong>Bahasa</strong> </h3>
            </div>
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:95%">Uraian</th>
                                    <th style="width:5%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="tbDataBahasa">
                                @forelse ($bahasa as $item)
                                    <tr>
                                        <td>
                                            {{ Form::textarea('bahasa_uraian[]', $bahasa->uraian, array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                                @if ($errors->has('bahasa_uraian'))
                                                <span class="help-block">{{$errors->first('bahasa_uraian')}}</span>
                                                @endif
                                        </td>
                                        <td>
                                            <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            {{ Form::textarea('bahasa_uraian[]', old('bahasa_uraian'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
                                                @if ($errors->has('bahasa_uraian'))
                                                <span class="help-block">{{$errors->first('bahasa_uraian')}}</span>
                                                @endif
                                        </td>
                                        <td>
                                            <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <a id="btnAddBahasa" class="btn btn-default btn-rounded" onclick="createRowBahasa()">Tambah</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <p>
                  * Data ini harus diisi.<br>
                  -Format penulisan untuk Tahun ditulis 4 digit (misal: 2010) dan Uraian minimal 4 karakter.
                </p>
            </div>
            <div class="panel-footer">     
                <a href="{{URL::to('webprofile/tenagaahlis')}}" class="btn btn-default pull-left">Batal</a>                               
                <button class="btn btn-primary pull-right">Submit</button>
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
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.jenis_kelamin').select2();
        $('.status_kepegawaian').select2();
    });
</script>
@stop
