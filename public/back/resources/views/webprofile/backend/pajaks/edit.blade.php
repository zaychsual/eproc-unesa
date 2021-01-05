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

      {!! Form::model($data, ['route' => ['pajaks.update', $data->id], 'method'=>'patch', 'class'=>'form-horizontal']) !!}
      {!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong></h3>
            </div>
            <div class="panel-body">
                
                <div class="form-group @if ($errors->has('jenis')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jenis Pajak *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('jenis', old('jenis'), array('class' => 'form-control')) }}
                        </div>  
                            @if ($errors->has('jenis'))
                            <span class="help-block">{{$errors->first('jenis')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('masa_pajak_tahun')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Masa Pajak Tahunan *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('masa_pajak_tahun', old('masa_pajak_tahun'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('masa_pajak_tahun'))
                            <span class="help-block">{{$errors->first('masa_pajak_tahun')}}</span>
                            @endif                                           
                    </div>
                </div>   

                <div class="form-group @if ($errors->has('nomor_bukti')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nomor Bukti Penerimaan Surat *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('nomor_bukti', old('nomor_bukti'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('nomor_bukti'))
                            <span class="help-block">{{$errors->first('nomor_bukti')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group">                                        
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Bukti Penerimaan Surat *</label>
                    <div class="col-md-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('tanggal_bukti', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                        </div>
                        @if ($errors->has('tanggal_bukti'))
                            <span class="help-block">{{$errors->first('tanggal_bukti')}}</span>
                            @endif 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Dokumen</label>
                    <div class="col-md-6 col-xs-12">  
                        
                        {{ Form::file('thumbnail', array('class'=>'fileinput btn-primary', 'id'=>'uploadImage', 'data-filename-placement'=>'inside', 'title'=>'Browse file', 'onchange'=>'PreviewImage();')) }}

                        @if ($errors->has('thumbnail'))
                        <span class="help-block">{{$errors->first('thumbnail')}}</span>
                        @endif 
                        <hr>
                        <div class="form-group">
                              @if($data->thumbnail)
                              <a href="{{URL::to('https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/pajaks/'.$data->thumbnail)}}" target="_blank">Lihat file yang sudah tersimpan</a><br>
                              @else
                              <img id="uploadPreview" style="width: 200px; height: 100%;" src="http://www.nachc.org/wp-content/uploads/2019/02/pdf-icon-230x300.png"/><br>
                              @endif
                        </div> 
                    </div>
                </div>

                

                  
                
            </div>
            <div class="panel-body">
                <p>
                  * Data ini harus diisi.<br>
                  - Tipe file dokumen hanya .txt, .doc, .docx, .xls, .xlsx, .pdf, .jpg, .zip, .rar yang bisa diupload.
                </p>
            </div>
            <div class="panel-footer">     
                <a href="{{URL::to('webprofile/pajaks')}}" class="btn btn-default pull-left">Batal</a>                               
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
    function PreviewImage() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

    oFReader.onload = function (oFREvent) {
    document.getElementById("uploadPreview").src = oFREvent.target.result;
    };
    };
  $('#categories').select2();
</script>

@stop
