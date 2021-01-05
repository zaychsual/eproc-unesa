@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Tambah Admin</li>
@stop

@section('content')
{!! Form::open(array('url' => route('setting.store'), 'method' => 'POST', 'id' => 'setting', 'class' => 'form-horizontal')) !!}
{!! csrf_field() !!}
<!-- page start-->
<div class="row">
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> Setting</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('name_setting')) has-error @endif">
	                        <label class="col-md-2 control-label">Nama Setting</label>
	                        <div class="col-md-10">
	                          {{ Form::text('name_setting', old('name_setting'), array('class' => 'form-control')) }}
	                          @if ($errors->has('name_setting'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('name_setting')}}</label>
	                          @endif
	                        </div>
	                    </div>
                      <div class="form-group @if ($errors->has('value_setting')) has-error @endif">
	                        <label class="col-md-2 control-label">Value Setting</label>
	                        <div class="col-md-10">
	                          {{ Form::text('value_setting', old('value_setting'), array('class' => 'form-control')) }}
	                          @if ($errors->has('value_setting'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('value_setting')}}</label>
	                          @endif
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-footer">
              <a href="{{URL::to('setting')}}" class="btn btn-default pull-right">Batal</a>
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
@stop
