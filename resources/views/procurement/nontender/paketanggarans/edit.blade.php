@extends('webprofile.layouts.backend.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Edit {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')

<!-- page start-->
<div class="row">
    <div class="col-md-12">

        {!! Form::model($data, ['route' => ['pemiliks.update', $data->id], 'method'=>'patch', 'class'=>'form-horizontal']) !!}
        {!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong></h3>
            </div>
            <div class="panel-body">
                
                <div class="form-group @if ($errors->has('nama')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('nama', old('nama'), array('class' => 'form-control', 'required')) }}
                        </div>  
                            @if ($errors->has('nama'))
                            <span class="help-block">{{$errors->first('nama')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('ktp')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nomor KTP *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::number('ktp', old('ktp'), array('class' => 'form-control', 'required')) }}
                        </div> 
                            @if ($errors->has('ktp'))
                            <span class="help-block">{{$errors->first('ktp')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('alamat')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Alamat *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        {{ Form::textarea('alamat', old('alamat'), array('class' => 'form-control', 'required')) }}
                            @if ($errors->has('alamat'))
                            <span class="help-block">{{$errors->first('alamat')}}</span>
                            @endif
                    </div>
                </div>    

                <div class="form-group @if ($errors->has('saham')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Saham **</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('saham', old('saham'), array('class' => 'form-control', 'id'=>'saham', 'required')) }}
                        </div> 
                            @if ($errors->has('saham'))
                            <span class="help-block">{{$errors->first('saham')}}</span>
                            @endif                                           
                    </div>
                </div>    

                <div class="form-group @if ($errors->has('satuan')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Satuan *</label>
                    <div class="col-md-6 col-xs-12">                                              
                        {{ Form::select('satuan', array('Lembar' => 'Lembar', 'Persen' => 'Persen'), old('satuan'), ['class' => 'form-control satuan', 'style' => 'width: 100%;', 'id' => 'satuan', 'placeholder' => 'Pilih Satuan', 'required']) }}
                            @if ($errors->has('satuan'))
                            <span class="help-block">{{$errors->first('satuan')}}</span>
                            @endif
                    </div>
                </div>    
                
            </div>
            <div class="panel-body">
                <p>
                    * Data ini harus diisi.<br>
                    ** Masukkan 0 (nol) jika tidak memiliki saham.
                </p>
            </div>
            <div class="panel-footer">     
                <a href="{{URL::to('webprofile/pemiliks')}}" class="btn btn-default pull-left">Batal</a>                               
                <button class="btn btn-primary pull-right">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    
</div>

<!-- page end-->
@stop

@section('script')
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('ress/js/plugins/summernote/summernote.js') !!}


{{Html::script('js/jquery.mask.min.js')}}
<script>
	$('#saham').mask('#.##0', {reverse: true});
</script>
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.satuan').select2();
        $('.status_kepegawaian').select2();
    });
</script>
@stop
