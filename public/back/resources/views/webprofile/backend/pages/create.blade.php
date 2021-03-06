@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('assets')
{{-- {!! Html::style("template/sweet/sweetalert.css") !!} --}}
{{-- <link rel="stylesheet" href="https://statik.unesa.ac.id/profileunesa_konten_statik/admin/assets/select2/select2.min.css"> --}}
<style media="screen">
  .tkh{
    color: black;
  }
</style>
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Tambah Halaman</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
  {!! Form::open(array('url' => route('pages.store'), 'method' => 'POST', 'id' => 'pages', 'files' => true)) !!}
  {!! csrf_field() !!}
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> Halaman</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('title')) has-error @endif">
	                        <div class="col-md-12">
	                          {{ Form::text('title', old('title'), array('class' => 'form-control', 'placeholder'=>'Judul', 'style'=>'font-size: 14pt;')) }}
	                          @if ($errors->has('title'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('title')}}</label>
	                          @endif
	                        </div>
	                    </div>
                  </div>
                  <div class="col-md-12">
	                    <div class="block">
	                      {{ Form::textarea('content', null, array('class'=>'summernote')) }}
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
                    <div class="form-group" style="padding-top: 10px;">
                          <label class="col-md-2 control-label">Status</label>
                          <div class="col-md-6">
                              <center><label class="switch">
                              	{{ Form::checkbox('posts_status', 1, true) }}
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
	<div class="col-md-3">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Gambar Cover</strong></h3>
	            <ul class="panel-controls">
	                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
	            </ul>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label class="col-md-2 control-label"></label>
	                        <div class="col-md-12">
	                          <center>
	                          	  <div class="form-group">
                  	            	<img id="uploadPreview" style="width: 200px; height: 100%;" src="https://statik.unesa.ac.id/profileunesa_konten_statik/images/preview.png"/><br>
                  	            </div>
                  	            <div class="form-group">
                  	            	{{ Form::file('thumbnail', array('class'=>'fileinput btn-danger', 'id'=>'uploadImage', 'data-filename-placement'=>'inside', 'title'=>'Gambar cover', 'onchange'=>'PreviewImage();')) }}
                  	            </div>
	                          </center>
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
  {!! Form::close() !!}
</div>
<!-- page end-->
@stop

@section('script')
{{-- <script src="https://statik.unesa.ac.id/spn_konten_statik/plugins/select2/select2.full.min.js"></script> --}}
{!! Html::script('https://statik.unesa.ac.id/profileunesa_konten_statik/admin/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('https://statik.unesa.ac.id/profileunesa_konten_statik/admin/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('https://statik.unesa.ac.id/profileunesa_konten_statik/admin/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('https://statik.unesa.ac.id/profileunesa_konten_statik/admin/js/plugins/summernote/summernote.js') !!}
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
