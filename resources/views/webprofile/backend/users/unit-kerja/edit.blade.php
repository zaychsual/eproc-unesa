@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Edit Unit Kerja</li>
@stop

@section('content')
{!! Form::open(array('url' => route('user.update-unitkerja'), 'method' => 'POST', 'id' => 'user', 'class' => 'form-horizontal')) !!}
{!! csrf_field() !!}
<!-- page start-->
<input type="hidden" name="id" value="{{Crypt::encrypt($edit->id)}}">
<div class="row">
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Edit</strong> Unit Kerja</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('nama')) has-error @endif">
	                        <label class="col-md-2 control-label">Nama Fakultas</label>
	                        <div class="col-md-10">
	                          {{ Form::text('nama', $edit->nama, array('class' => 'form-control')) }}
	                          @if ($errors->has('nama'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('nama')}}</label>
	                          @endif
	                        </div>
	                    </div>
	                    <div class="form-group @if ($errors->has('email')) has-error @endif">
	                        <label class="col-md-2 control-label">Email</label>
	                        <div class="col-md-10">
	                          {{ Form::email('email', $edit->email, array('class' => 'form-control')) }}
	                          @if ($errors->has('email'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('email')}}</label>
	                          @endif
	                        </div>
	                    </div>
	                    <div class="form-group @if ($errors->has('no_telp')) has-error @endif">
	                        <label class="col-md-2 control-label">No Telepon</label>
	                        <div class="col-md-10">
	                          {{ Form::number('no_telp', $edit->no_telp, array('class' => 'form-control')) }}
	                          @if ($errors->has('no_telp'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('no_telp')}}</label>
	                          @endif
	                        </div>
	                    </div>
	                    <div class="form-group @if ($errors->has('alamat')) has-error @endif">
	                        <label class="col-md-2 control-label">Alamat</label>
	                        <div class="col-md-10">
	                          {{ Form::textarea('alamat', $edit->alamat, array('class' => 'form-control')) }}
	                          @if ($errors->has('alamat'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('alamat')}}</label>
	                          @endif
	                        </div>
	                    </div>
						<div class="form-group @if ($errors->has('laman')) has-error @endif">
	                        <label class="col-md-2 control-label">Laman</label>
	                        <div class="col-md-10">
	                          {{ Form::text('laman', $edit->laman, array('class' => 'form-control')) }}
	                          @if ($errors->has('laman'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('laman')}}</label>
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
              <a href="{{URL::to('webprofile/user/unit-kerja')}}" class="btn btn-default pull-right">Batal</a>
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
