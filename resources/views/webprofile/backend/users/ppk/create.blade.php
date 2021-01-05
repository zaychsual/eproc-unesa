@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Tambah Admin</li>
@stop

@section('content')
{!! Form::open(array('url' => route('ppk.store'), 'method' => 'POST', 'id' => 'user', 'class' => 'form-horizontal','files' => true)) !!}
{!! csrf_field() !!}
<!-- page start-->
<div class="row">
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> PPK</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('name')) has-error @endif">
	                        <label class="col-md-2 control-label">Nama Lengkap</label>
	                        <div class="col-md-10">
	                          {{ Form::text('name', old('name'), array('class' => 'form-control')) }}
	                          @if ($errors->has('name'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('name')}}</label>
	                          @endif
	                        </div>
	                    </div>
	                    <div class="form-group @if ($errors->has('email')) has-error @endif">
	                        <label class="col-md-2 control-label">Email</label>
	                        <div class="col-md-10">
	                          {{ Form::email('email', old('email'), array('class' => 'form-control')) }}
	                          @if ($errors->has('email'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('email')}}</label>
	                          @endif
	                        </div>
	                    </div>
						<div class="form-group @if ($errors->has('nomor_sertifikat')) has-error @endif">
	                        <label class="col-md-2 control-label">Nomor Sertifikat</label>
	                        <div class="col-md-10">
	                          {{ Form::text('nomor_sertifikat', old('nomor_sertifikat'), array('class' => 'form-control')) }}
	                          @if ($errors->has('nomor_sertifikat'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('nomor_sertifikat')}}</label>
	                          @endif
	                        </div>
	                    </div>
						<div class="form-group @if ($errors->has('file_sertifikat')) has-error @endif">
	                        <label class="col-md-2 control-label">File Sertifikat</label>
	                        <div class="col-md-10">
	                          {{ Form::file('file_sertifikat', old('file_sertifikat'), array('class' => 'form-control')) }}
	                          @if ($errors->has('file_sertifikat'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('file_sertifikat')}}</label>
	                          @endif
	                        </div>
	                    </div>
	                    <div class="form-group @if ($errors->has('password')) has-error @endif">
	                        <label class="col-md-2 control-label">Password</label>
	                        <div class="col-md-10">
                            {{ Form::password('password', array('class' => 'form-control')) }}
	                          {{-- {{ Form::password('password', old('password'), array('class' => 'form-control')) }} --}}
	                          @if ($errors->has('password'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('password')}}</label>
	                          @endif
	                        </div>
	                    </div>
	                    <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
	                        <label class="col-md-2 control-label">Ulangi Password</label>
	                        <div class="col-md-10">
                            {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
	                          {{-- {{ Form::password('password_confirmation', old('password_confirmation'), array('class' => 'form-control')) }} --}}
	                          @if ($errors->has('password_confirmation'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('password_confirmation')}}</label>
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
              <a href="{{URL::to('webprofile/user')}}" class="btn btn-default pull-right">Batal</a>
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
