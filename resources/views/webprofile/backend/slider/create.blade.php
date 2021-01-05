@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Tambah Slider</li>
@stop

@section('content')
{!! Form::open(array('url' => route('slider.store'), 'method' => 'POST', 'id' => 'slider', 'class' => 'form-horizontal', 'files' => true)) !!}
{!! csrf_field() !!}
<!-- page start-->
<div class="row">
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> Slider</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('title')) has-error @endif">
	                        <label class="col-md-2 control-label">Nama Slider</label>
	                        <div class="col-md-10">
	                          {{ Form::text('title', old('title'), array('class' => 'form-control')) }}
		                        @if ($errors->has('title'))
		                        <label id="login-error" class="error" for="login">{{$errors->first('title')}}</label>
		                        @endif
	                        </div>
	                    </div>
	                    <center>
	                      	<div class="form-group">
	          	            	<img id="uploadPreview" style="width: 500px; height: 100%;" src="{{URL::to('https://statik.unesa.ac.id/perpus_konten_statik/uploads/slider/slider.png')}}"/><br>
	          	            </div>
	          	            <div class="form-group">
	          	            	{{ Form::file('images', array('class'=>'fileinput btn-danger', 'id'=>'uploadImage', 'data-filename-placement'=>'inside', 'title'=>'Upload', 'onchange'=>'PreviewImage();')) }}
	          	            </div>
	                    </center>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-3">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Terbitkan</strong></h3>
	            <ul class="panel-controls">
	                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
	            </ul>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group">
                            <label class="col-md-2 control-label">Status</label>
                            <div class="col-md-6">
                                <center><label class="switch">
                                	{{ Form::checkbox('is_active', 1, true) }}
                                    <span></span>
                                </label></center>
                            </div>
                        </div>
	                </div>
	            </div>
	        </div>
	        <div class="panel-footer">
	        </div>
	    </div>
	</div>
	<div class="col-md-12">
	    <div class="panel panel-default">
	        <div class="panel-footer">
	            <button class="btn btn-info pull-right">Simpan</button>
	        </div>
	    </div>
	</div>
</div>
{!! Form::close() !!}
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
