@extends('webprofile.layouts.backend.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Create {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')

<!-- page start-->
<div class="row">
	<div class="col-md-12">

		{!! Form::open(array('url' => route('aktas.store'), 'method' => 'POST', 'id' => 'aktas', 'files' => true, 'class' => 'form-horizontal')) !!}
		{!! csrf_field() !!}

	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Form</strong> </h3>
	        </div>
	        <div class="panel-body">
                <label>Akta Pendirian</label>
	            <div class="form-group @if ($errors->has('pendirian_nomor')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nomor *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('pendirian_nomor', old('pendirian_nomor'), array('class' => 'form-control')) }}
                        </div>  
                            @if ($errors->has('pendirian_nomor'))
                            <span class="help-block">{{$errors->first('pendirian_nomor')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group">                                        
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Surat *</label>
                    <div class="col-md-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('pendirian_tanggal', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                        </div>
                        @if ($errors->has('pendirian_tanggal'))
                            <span class="help-block">{{$errors->first('pendirian_tanggal')}}</span>
                            @endif 
                    </div>
                </div>

                <div class="form-group @if ($errors->has('pendirian_notaris')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Notaris *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('pendirian_notaris', old('pendirian_notaris'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('pendirian_notaris'))
                            <span class="help-block">{{$errors->first('pendirian_notaris')}}</span>
                            @endif                                           
                    </div>
                </div>  

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Dokumen</label>
                    <div class="col-md-6 col-xs-12">  
                        {{ Form::file('pendirian_link_file', array('class'=>'fileinput btn-primary', 'id'=>'file-simple', 'data-filename-placement'=>'inside', 'title'=>'Browse file')) }}                                   

                        @if ($errors->has('pendirian_link_file'))
                        <span class="help-block">{{$errors->first('pendirian_link_file')}}</span>
                        @endif
                    </div>
                </div> 

                <hr>
                <label>Akta Perubahan</label>
                <div class="form-group @if ($errors->has('perubahan_nomor')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nomor</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('perubahan_nomor', old('perubahan_nomor'), array('class' => 'form-control')) }}
                        </div>  
                            @if ($errors->has('perubahan_nomor'))
                            <span class="help-block">{{$errors->first('perubahan_nomor')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group">                                        
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Surat</label>
                    <div class="col-md-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('perubahan_tanggal', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                        </div>
                        @if ($errors->has('perubahan_tanggal'))
                            <span class="help-block">{{$errors->first('perubahan_tanggal')}}</span>
                            @endif 
                    </div>
                </div>

                <div class="form-group @if ($errors->has('perubahan_notaris')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Notaris</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('perubahan_notaris', old('perubahan_notaris'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('perubahan_notaris'))
                            <span class="help-block">{{$errors->first('perubahan_notaris')}}</span>
                            @endif                                           
                    </div>
                </div>  

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Dokumen</label>
                    <div class="col-md-6 col-xs-12">  
                        {{ Form::file('perubahan_link_file', array('class'=>'fileinput btn-primary', 'id'=>'file-simple', 'data-filename-placement'=>'inside', 'title'=>'Browse file')) }}                                   

                        @if ($errors->has('perubahan_link_file'))
                        <span class="help-block">{{$errors->first('perubahan_link_file')}}</span>
                        @endif
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
                <a href="{{URL::to('webprofile/aktas')}}" class="btn btn-default pull-left">Batal</a>                               
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
</script>
@stop
