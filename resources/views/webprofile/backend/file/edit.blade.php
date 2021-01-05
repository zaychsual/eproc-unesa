@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('assets')

<style media="screen">
  .tkh{
    color: black;
  }
</style>
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Ubah File</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
  {!! Form::model($file, ['route' => ['file.update', $file->id], 'method'=>'patch', 'files' => true, 'class' => 'form-horizontal']) !!}
  {!! csrf_field() !!}
  <!-- page start-->
  <div class="row">
  	<div class="col-md-9">
  	    <div class="panel panel-default">
  	        <div class="panel-heading">
  	            <h3 class="panel-title"><strong>Ubah</strong> Slider</h3>
  	        </div>
  	        <div class="panel-body">
  	            <div class="row">
  	                <div class="col-md-12">
						<div class="form-group @if ($errors->has('categories_file')) has-error @endif" style="margin-top: 5px;">
						 	<label class="col-md-2 control-label">Kategori Dokumen</label>
							<div class="col-md-10">
								{{ Form::select('categories_file', $categoriesFile, old('categories_file'), ['class' => 'form-control categories_file', 'style' => 'width: 100%; font-size: 16px; height: 40px;', 'id' => 'categories_file', 'placeholder' => 'Kategori', 'required']) }}
								@if ($errors->has('categories_file'))
								<label id="login-error" class="error" for="login">{{$errors->first('categories_file')}}</label>
								@endif
							</div>
	                    </div>
  	                    <div class="form-group @if ($errors->has('title')) has-error @endif">
  	                        <label class="col-md-2 control-label">Nama Dokumen</label>
  	                        <div class="col-md-10">
  	                          {{ Form::text('title', old('title'), array('class' => 'form-control')) }}
  		                        @if ($errors->has('title'))
  		                        <label id="login-error" class="error" for="login">{{$errors->first('title')}}</label>
  		                        @endif
  	                        </div>
  	                    </div>
  	                    <div class="form-group">
							<label class="col-md-2 control-label">File</label>
							<div class="col-md-10">
								{{ Form::file('file', array('class'=>'fileinput btn-danger', 'id'=>'uploadImage', 'data-filename-placement'=>'inside', 'title'=>'Upload', 'onchange'=>'ValidateFile(this); checkFileSizeFile(this);')) }}
								<label for="information" class="error">Ekstensi File yang diperbolehkan : ".jpg", ".jpeg", ".png", ".doc", ".docx", ".pdf", ".xls", ".xlsx", ".mp3", ".mp4", ".mkv", "mpeg"</label>
							</div>
						</div>
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

<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.categories_file').select2();
    });
</script>
@stop
