@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Tambah Admin</li>
@stop

@section('content')
{!! Form::open(array('url' => route('user.store'), 'method' => 'POST', 'id' => 'user', 'class' => 'form-horizontal')) !!}
{!! csrf_field() !!}
<!-- page start-->
<div class="row">
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Tambah</strong> User</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
                      <div class="form-group @if ($errors->has('role')) has-error @endif">
                          <label class="col-md-2 control-label">Sebagai</label>
                          <div class="col-md-10">
                            {{ Form::select('role', ['admin'=>'Administrator', 'laman'=>'Penyedia', 'verifikator'=>'Verifikator','ka_ukpbj' => 'KA UKPBJ'], old('role'), array('class' => 'form-control')) }}
                            @if ($errors->has('role'))
                            <label id="login-error" class="error" for="login">{{$errors->first('role')}}</label>
                            @endif
                          </div>
                      </div>
                      <div class="form-group @if ($errors->has('mt_unit_kerja_id')) has-error @endif">
                          <label class="col-md-2 control-label">Unit Kerja</label>
                          <div class="col-md-10">
                            {{ Form::select('mt_unit_kerja_id',$data['unit_kerja'] , old('mt_unit_kerja_id'), array('class' => 'form-control')) }}
                            @if ($errors->has('mt_unit_kerja_id'))
                            <label id="login-error" class="error" for="login">{{$errors->first('mt_unit_kerja_id')}}</label>
                            @endif
                          </div>
                      </div>
                      <div class="form-group @if ($errors->has('nip')) has-error @endif">
	                        <label class="col-md-2 control-label">NIP</label>
	                        <div class="col-md-10">
	                          {{ Form::text('nip', old('nip'), array('class' => 'form-control')) }}
	                          @if ($errors->has('nip'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('nip')}}</label>
	                          @endif
	                        </div>
	                    </div>
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
