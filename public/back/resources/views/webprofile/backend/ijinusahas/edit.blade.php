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

      {!! Form::model($data, ['route' => ['ijinusahas.update', $data->id], 'method'=>'patch', 'files' => true, 'class'=>'form-horizontal']) !!}
      {!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong></h3>
            </div>
            <div class="panel-body">
                
                <div class="form-group @if ($errors->has('jenis_ijin')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jenis Izin *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('jenis_ijin', old('jenis_ijin'), array('class' => 'form-control')) }}
                        </div>  
                            @if ($errors->has('jenis_ijin'))
                            <span class="help-block">{{$errors->first('jenis_ijin')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('nomor_surat')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nomor Surat *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('nomor_surat', old('nomor_surat'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('nomor_surat'))
                            <span class="help-block">{{$errors->first('nomor_surat')}}</span>
                            @endif                                           
                    </div>
                </div>  

                <div class="form-group @if ($errors->has('berlaku_sampai')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Berlaku Sampai *</label>
                    <div class="col-md-6 col-xs-12">                                              
                        {{ Form::select('berlaku_sampai', array('Tanggal' => 'Tanggal', 'Seumur Hidup' => 'Seumur Hidup'), old('berlaku_sampai'), ['class' => 'form-control select', 'style' => 'width: 100%;', 'id' => 'berlaku_sampai', 'placeholder' => 'Pilih Satuan', 'required']) }}
                            @if ($errors->has('berlaku_sampai'))
                            <span class="help-block">{{$errors->first('berlaku_sampai')}}</span>
                            @endif
                    </div>
                </div>     

                <div class="form-group @if ($errors->has('instansi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Instansi Pemberi *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('instansi', old('instansi'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('instansi'))
                            <span class="help-block">{{$errors->first('instansi')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('klasifikasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Klasifikasi</label>
                    <div class="col-md-6 col-xs-12">                                            
                        {{ Form::textarea('klasifikasi', old('klasifikasi'), array('class' => 'form-control')) }}
                            @if ($errors->has('klasifikasi'))
                            <span class="help-block">{{$errors->first('klasifikasi')}}</span>
                            @endif
                    </div>
                </div>  

                <div class="form-group @if ($errors->has('kualifikasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Kualifikasi *</label>
                    <div class="col-md-6 col-xs-12">                                              
                        {{ Form::select('kualifikasi', array('Perusahaan Kecil' => 'Perusahaan Kecil', 'Perusahaan Non Kecil' => 'Perusahaan Non Kecil'), old('kualifikasi'), ['class' => 'form-control select', 'style' => 'width: 100%;', 'id' => 'kualifikasi', 'placeholder' => 'Pilih Kualifikasi', 'required']) }}
                            @if ($errors->has('kualifikasi'))
                            <span class="help-block">{{$errors->first('kualifikasi')}}</span>
                            @endif
                    </div>
                </div> 

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Dokumen</label>
                    <div class="col-md-6 col-xs-12">  
                        
                        {{ Form::file('link_file', array('class'=>'fileinput btn-primary', 'id'=>'uploadImage', 'data-filename-placement'=>'inside', 'title'=>'Browse file', 'onchange'=>'PreviewImage();')) }}

                        @if ($errors->has('link_file'))
                        <span class="help-block">{{$errors->first('link_file')}}</span>
                        @endif 
                        <hr>
                        <div class="form-group">
                              @if($data->link_file)
                              <a href="{{URL::to('https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/ijinusahas/'.$data->link_file)}}" target="_blank">Lihat file yang sudah tersimpan</a><br>
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
                <a href="{{URL::to('webprofile/ijinusahas')}}" class="btn btn-default pull-left">Batal</a>                               
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
