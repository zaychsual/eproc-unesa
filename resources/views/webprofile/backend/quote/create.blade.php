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
<li class="active">Tambah Quote</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
  {!! Form::open(array('url' => route('quote.store'), 'method' => 'POST')) !!}
  {!! csrf_field() !!}
  <div class="col-md-12">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> Quote</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('title_design')) has-error @endif">
	                        <div class="col-md-12">
	                          {{ Form::text('title_design', old('title_design'), array('class' => 'form-control', 'placeholder'=>'Person', 'style'=>'font-size: 14pt;')) }}
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
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('ress/js/plugins/summernote/summernote.js') !!}
@stop