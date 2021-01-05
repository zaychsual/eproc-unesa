@extends('webprofile.layouts.backend.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Ubah Admin</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')

<!-- page start-->
<div class="row">
    <div class="col-md-12">

      {!! Form::model($user, ['route' => ['user.update', $user->id], 'method'=>'patch', 'class'=>'form-horizontal']) !!}
      {!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong></h3>
            </div>
            <div class="panel-body"> 

                

<label id="login-error" class="error" for="login">Kosongi jika tidak mengganti password</label>
                <div class="form-group @if ($errors->has('password')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Password</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::password('password', array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('password'))
                            <span class="help-block">{{$errors->first('password')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Ulangi Password</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('password_confirmation'))
                            <span class="help-block">{{$errors->first('password_confirmation')}}</span>
                            @endif                                           
                    </div>
                </div>   
                    
            </div>
            <div class="panel-footer">     
                <a href="{{URL::to('webprofile/user')}}" class="btn btn-default pull-left">Batal</a>                               
                <button class="btn btn-primary pull-right">Submit</button>
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
