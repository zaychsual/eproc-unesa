@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Tambah Kategori Dokumen</li>
@stop

@section('content')
{!! Form::open(array('url' => route('categories_file.store'), 'method' => 'POST', 'id' => 'categories', 'class' => 'form-horizontal')) !!}
{!! csrf_field() !!}
<!-- page start-->
<div class="row">
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> Kategori Dokumen</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('name')) has-error @endif">
	                        <label class="col-md-2 control-label">Kategori Dokumen</label>
	                        <div class="col-md-10">
	                          {{ Form::text('name', old('name'), array('class' => 'form-control')) }}
	                          @if ($errors->has('name'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('name')}}</label>
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
              <a href="{{URL::to('webprofile/categories_file')}}" class="btn btn-default pull-right">Batal</a>
	            <button class="btn btn-info pull-right">Simpan</button>
	        </div>
	    </div>
	</div>
</div>
{!! Form::close() !!}
<!-- page end-->
@stop

@section('script')
{!! Html::script('https://statik.unesa.ac.id/perpus_konten_statik/admin/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('https://statik.unesa.ac.id/perpus_konten_statik/admin/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('https://statik.unesa.ac.id/perpus_konten_statik/admin/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('https://statik.unesa.ac.id/perpus_konten_statik/admin/js/plugins/summernote/summernote.js') !!}
@stop
