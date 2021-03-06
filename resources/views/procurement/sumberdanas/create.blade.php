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

		{!! Form::open(array('url' => route('sumberdanas.store'), 'method' => 'POST', 'id' => 'tahaps', 'class' => 'form-horizontal')) !!}
		{!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong> </h3>
            </div>
            <div class="panel-body">

            <div class="form-group @if ($errors->has('sumber_dana')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Sumber Dana *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('sumber_dana', old('sumber_dana'), array('class' => 'form-control', 'required')) }}
                        </div>  
                            @if ($errors->has('sumber_dana'))
                            <span class="help-block">{{$errors->first('sumber_dana')}}</span>
                            @endif  
                    </div>
                </div>


                <div class="form-group @if ($errors->has('kode_anggaran')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Kode Anggaran *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('kode_anggaran', old('kode_anggaran'), array('class' => 'form-control', 'required')) }}
                        </div>  
                            @if ($errors->has('kode_anggaran'))
                            <span class="help-block">{{$errors->first('kode_anggaran')}}</span>
                            @endif  
                    </div>
                </div>


                <div class="form-group @if ($errors->has('nilai')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nilai *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('nilai', old('nilai'), array('class' => 'form-control', 'required')) }}
                        </div>  
                            @if ($errors->has('nilai'))
                            <span class="help-block">{{$errors->first('nilai')}}</span>
                            @endif  
                    </div>
                </div>
                

              

                
                
            </div>
            
            <div class="panel-footer">     
                <a href="{{URL::to('sumberdanas/tahuns')}}" class="btn btn-default pull-left">Batal</a>                               
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
