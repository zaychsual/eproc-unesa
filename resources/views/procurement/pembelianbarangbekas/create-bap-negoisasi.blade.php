@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Tambah {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop
@section('content')
<!-- page start-->
<div class="row">
	<div class="col-md-12">
		{!! Form::open(array('url' => route('pembelian-barang-bekas.store-ba-negoisasi'), 'method' => 'POST', 'id' => 'tahaps', 'class' => 'form-horizontal')) !!}
        {!! csrf_field() !!}
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
        <input type="hidden" name="rekanan_id" value="{{ $paketRekanan->mt_rekanan_id }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong> </h3>
            </div>
            <div class="panel-body">
               <div class="form-group @if ($errors->has('pemilihan')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">No</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('bap_no', old('bap_no'), array('class' => 'form-control', 'required')) }}
                        </div>  
                        @if ($errors->has('pemilihan'))
                        <span class="help-block">{{$errors->first('pemilihan')}}</span>
                        @endif                                          
                    </div>
                </div>
                <div class="form-group @if ($errors->has('bap_tanggal')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::date('bap_tanggal', old('bap_tanggal',date('Y-m-d')), array('class' => 'form-control', 'required')) }}
                        </div>  
                        @if ($errors->has('bap_tanggal'))
                        <span class="help-block">{{$errors->first('bap_tanggal')}}</span>
                        @endif                                          
                    </div>
                </div>
                <div class="form-group @if ($errors->has('bap_mulai')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Mulai</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('bap_mulai', old('bap_mulai'), array('class' => 'form-control datetime', 'required')) }}
                        </div>  
                        @if ($errors->has('bap_mulai'))
                        <span class="help-block">{{$errors->first('bap_mulai')}}</span>
                        @endif                                          
                    </div>
                </div>
                <div class="form-group @if ($errors->has('bap_selesai')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal Selesai</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('bap_selesai', old('bap_selesai'), array('class' => 'form-control datetime', 'required')) }}
                        </div>  
                        @if ($errors->has('bap_selesai'))
                        <span class="help-block">{{$errors->first('bap_selesai')}}</span>
                        @endif                                          
                    </div>
                </div>
                <div class="form-group @if ($errors->has('bap_tempat')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tempat</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-building"></span></span>
                            {{ Form::text('bap_tempat', old('bap_tempat'), array('class' => 'form-control', 'required')) }}
                        </div>  
                        @if ($errors->has('bap_tempat'))
                        <span class="help-block">{{$errors->first('bap_tempat')}}</span>
                        @endif                                          
                    </div>
                </div>
            </div>
            
            <div class="panel-footer">     
                <button class="btn btn-primary pull-right" type="submit">Submit</button>
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

    $('#datetimepicker1').datetimepicker();
</script>
@stop
