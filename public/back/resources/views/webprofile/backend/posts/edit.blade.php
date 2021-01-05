@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('assets')
{{-- {!! Html::style("template/sweet/sweetalert.css") !!} --}}
<link rel="stylesheet" href="https://statik.unesa.ac.id/profileunesa_konten_statik/admin/assets/select2/select2.min.css">
<style media="screen">
  .tkh{
    color: black;
  }
</style>
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Ubah Data Repository</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
  {!! Form::model($data, ['route' => ['posts.update', $data->id], 'method'=>'patch', 'files' => true]) !!}
  {!! csrf_field() !!}
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> Data Repository</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('title')) has-error @endif">
	                        <div class="col-md-12">
	                          <label>Title</label>
	                          {{ Form::text('title', old('title'), array('class' => 'form-control', 'placeholder'=>'Judul')) }}
	                          @if ($errors->has('title'))
	                          <span id="login-error" class="error" for="login">{{$errors->first('title')}}</span>
	                          @endif
	                        </div>
	                    </div>
                  	</div>
                  	<div class="col-md-12">
	                    <div class="form-group @if ($errors->has('categories')) has-error @endif" style="margin-top: 5px;">
                          <div class="col-md-12">
                          	<label>Kategori</label>
                            {{ Form::select('categories', $categories, old('categories'), ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'categories', 'placeholder' => 'Type Data', 'required']) }}
                            @if ($errors->has('categories'))
                            <span id="login-error" class="error" for="login">{{$errors->first('categories')}}</span>
                            @endif
                          </div>
	                    </div>
                  	</div>
                  	
                    <div class="col-md-12">
	                    <div class="block">
	                    	<label>Content</label>
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
	                    <div class="form-group">
	                        <label class="col-md-3 col-xs-12 control-label">Tanggal</label>
	                        <div class="col-md-12">
	                            <div class="input-group">
	                                {{ Form::text('post_date', date('Y-m-d'), array('class' => 'form-control datepicker')) }}
	                            </div>
	                        </div>
	                    </div>
                    </div>
                    @if(Auth::user()->role == 'admin')
                      <div class="col-md-12">
	                    <div class="form-group" style="padding-top: 10px;">
                            <label class="col-md-2 control-label">Status</label>
                            <div class="col-md-6">
                                <center><label class="switch">
                                	{{ Form::checkbox('posts_status', 1, false) }}
                                    <span></span>
                                </label></center>
                            </div>
                        </div>
	                </div>
                    @endif
                    
	            </div>
	        </div>
	        <div class="panel-footer">
	        </div>
	    </div>
	</div>
	<div class="col-md-3">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>File</strong></h3>
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
                                  @if($data->thumbnail)
                                  <a href="{{URL::to('https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/'. Session::get('ss_setting')['statik_konten'] .'/posts/'.$data->thumbnail)}}" target="_blank">Lihat File</a><br>
                                  @else
                  	              <img id="uploadPreview" style="width: 200px; height: 100%;" src="http://www.nachc.org/wp-content/uploads/2019/02/pdf-icon-230x300.png"/><br>
                                  @endif
                  	            </div>
                  	            <div class="form-group">
                  	            	{{ Form::file('thumbnail', array('class'=>'fileinput btn-danger', 'id'=>'uploadImage', 'data-filename-placement'=>'inside', 'title'=>'Upload File', 'onchange'=>'PreviewImage();')) }}
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
<script src="https://statik.unesa.ac.id/spn_konten_statik/plugins/select2/select2.full.min.js"></script>
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
  $('#categories').select2();
</script>
@stop
