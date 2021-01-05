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
<li class="active">Ubah Informasi</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
  {!! Form::model($data, ['route' => ['info.update', $data->id], 'method'=>'patch']) !!}
  {!! csrf_field() !!}
  <div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Ubah</strong> Informasi</h3>
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
	                    <div class="form-group">
	                        <label class="col-md-3 col-xs-12 control-label">Tanggal</label>
	                        <div class="col-md-12">
	                            <div class="input-group">
	                                {{ Form::text('event_date', date('Y-m-d'), array('class' => 'form-control datepicker')) }}
	                            </div>
	                        </div>
	                    </div>
                    </div>
                    <div class="col-md-12">
	                    <div class="form-group" style="padding-top: 10px;">
                            <label class="col-md-2 control-label">Status</label>
                            <div class="col-md-6">
                                <center><label class="switch">
                                	{{ Form::checkbox('info_status', 1, true) }}
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
@stop
