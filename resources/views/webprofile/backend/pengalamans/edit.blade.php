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

<!-- page start-->
<div class="row">
    <div class="col-md-12">

        {!! Form::model($data, ['route' => ['pengalamans.update', $data->id], 'method'=>'patch', 'class'=>'form-horizontal']) !!}
        {!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong></h3>
            </div>
            <div class="panel-body">
                
                <div class="form-group @if ($errors->has('nama')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama Kontrak *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('nama', old('nama'), array('class' => 'form-control', 'required')) }}
                        </div>  
                            @if ($errors->has('nama'))
                            <span class="help-block">{{$errors->first('nama')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('lokasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Lokasi *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        {{ Form::textarea('lokasi', old('lokasi'), array('class' => 'form-control', 'required')) }}
                            @if ($errors->has('lokasi'))
                            <span class="help-block">{{$errors->first('lokasi')}}</span>
                            @endif
                    </div>
                </div> 

                <div class="form-group @if ($errors->has('instansi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Instansi *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('instansi', old('instansi'), array('class' => 'form-control', 'required')) }}
                        </div> 
                            @if ($errors->has('instansi'))
                            <span class="help-block">{{$errors->first('instansi')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('alamat')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Alamat</label>
                    <div class="col-md-6 col-xs-12">                                            
                        {{ Form::textarea('alamat', old('alamat'), array('class' => 'form-control')) }}
                            @if ($errors->has('alamat'))
                            <span class="help-block">{{$errors->first('alamat')}}</span>
                            @endif
                    </div>
                </div>    

                <div class="form-group @if ($errors->has('telepon')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Telepon</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('telepon', old('telepon'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('telepon'))
                            <span class="help-block">{{$errors->first('telepon')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('no_kontrak')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nomor Kontrak</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('no_kontrak', old('no_kontrak'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('no_kontrak'))
                            <span class="help-block">{{$errors->first('no_kontrak')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('nilai_kontrak')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nilai Kontrak *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('nilai_kontrak', old('nilai_kontrak'), array('class' => 'form-control', 'id' => 'nilai_kontrak', 'required')) }}
                        </div> 
                            @if ($errors->has('nilai_kontrak'))
                            <span class="help-block">{{$errors->first('nilai_kontrak')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group">                                        
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Pelaksanaan</label>
                    <div class="col-md-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('tanggal_pelaksanaan', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                        </div>
                        @if ($errors->has('tanggal_pelaksanaan'))
                            <span class="help-block">{{$errors->first('tanggal_pelaksanaan')}}</span>
                            @endif 
                    </div>
                </div>

                <div class="form-group @if ($errors->has('persen_pelaksanaan')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Persentase Pelaksanaan **</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::number('persen_pelaksanaan', old('persen_pelaksanaan'), array('class' => 'form-control', 'id' => 'persen_pelaksanaan', 'required')) }}
                        </div> 
                            @if ($errors->has('persen_pelaksanaan'))
                            <span class="help-block">{{$errors->first('persen_pelaksanaan')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group">                                        
                    <label class="col-md-3 col-xs-12 control-label">Selesai Kontrak</label>
                    <div class="col-md-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('tanggal_selesai', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                        </div>
                        @if ($errors->has('tanggal_selesai'))
                            <span class="help-block">{{$errors->first('tanggal_selesai')}}</span>
                            @endif 
                    </div>
                </div>

                <div class="form-group">                                        
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Serah Terima</label>
                    <div class="col-md-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('tanggal_serah_terima', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                        </div>
                        @if ($errors->has('tanggal_serah_terima'))
                            <span class="help-block">{{$errors->first('tanggal_serah_terima')}}</span>
                            @endif 
                    </div>
                </div>    

                <div class="form-group @if ($errors->has('keterangan')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Keterangan</label>
                    <div class="col-md-6 col-xs-12">                                            
                        {{ Form::textarea('keterangan', old('keterangan'), array('class' => 'form-control')) }}
                            @if ($errors->has('alamat'))
                            <span class="help-block">{{$errors->first('keterangan')}}</span>
                            @endif
                    </div>
                </div>       

                    
                
            </div>
            <div class="panel-body">
                <p>
                    * Data ini harus diisi.<br>
                    ** Jika persentase bernilai kurang dari 100 maka sistem akan menganggap sebagai pekerjaan sedang berjalan.
                </p>
            </div>
            <div class="panel-footer">     
                <a href="{{URL::to('webprofile/pengalamans')}}" class="btn btn-default pull-left">Batal</a>                               
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


{{Html::script('js/jquery.mask.min.js')}}
<script>
	$('#nilai_kontrak').mask('#.##0', {reverse: true});
	$('#persen_pelaksanaan').mask('000');
</script>
@stop
