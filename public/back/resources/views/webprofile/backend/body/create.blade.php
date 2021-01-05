@extends('webprofile.layouts.backend.master')

@section('title')
{{ $title }}
@stop

@section('assets')
<link rel="stylesheet" href="https://statik.unesa.ac.id/profileunesa_konten_statik/admin/assets/select2/select2.min.css">
<style media="screen">
  .tkh{
    color: black;
  }
</style>
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Tambah Body</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
  {!! Form::open(array('url' => route('body.store'), 'method' => 'POST')) !!}
  {!! csrf_field() !!}
  <div class="col-md-12">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> Body</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('title_design')) has-error @endif">
	                        <div class="col-md-12">
	                          {{ Form::text('title_design', old('title_design'), array('class' => 'form-control', 'placeholder'=>'Judul', 'style'=>'font-size: 14pt;')) }}
	                          @if ($errors->has('title_design'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('title_design')}}</label>
	                          @endif
	                        </div>
	                    </div>
                  </div>
                  <div class="col-md-12">
	                    <div class="block">
	                      {{ Form::textarea('value_design', null, array('class'=>'summernote')) }}
	                    </div>
	                </div>
	            </div>
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
@stop