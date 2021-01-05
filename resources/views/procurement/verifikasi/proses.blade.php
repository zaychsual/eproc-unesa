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

		{!! Form::open(array('url' => route('verifikasi.store'), 'method' => 'POST', 'id' => 'tahaps', 'class' => 'form-horizontal')) !!}
		{!! csrf_field() !!}
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
        <input type="hidden" name="mt_rekanan_id" value="{{ $rekanan->id }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Verifikasi</strong> </h3>
            </div>
            <div class="panel-body">

               <div class="form-group @if ($errors->has('satuankerja')) has-error @endif">
                    <div class="row">
                        <div class="col-md-4">
                            <lable class="col-md-3 col-xs-12 control-label">Mulai : </lable>
                            <div class="col-md-6 col-xs-12">                                            
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input type="date" name="mulai" placeholder="Waktu mulai" required>
                                </div>                                      
                            </div>
                            <center>S.d</center>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-6 col-xs-12">     
                                <lable class="col-md-3 col-xs-12 control-label">Selesai : </lable>                                       
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input type="date" name="selesai" placeholder="Waktu selesai" required>
                                </div>                                       
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">   
                            <lable class="col-md-3 col-xs-12 control-label">Tempat : </lable>                                         
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-home"></span></span>
                                <textarea name="tempat" class="form-control" required></textarea>
                            </div>                                       
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">   
                            <lable class="col-md-3 col-xs-12 control-label">Yang Harus Dibawa : </lable>                                         
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-file"></span></span>
                                <textarea name="yang_harus_dibawa" class="form-control" required></textarea>
                            </div>                                       
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">   
                            <lable class="col-md-3 col-xs-12 control-label">Yang Harus Hadir : </lable>                                         
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-users"></span></span>
                                <textarea name="yang_harus_hadir" class="form-control" required></textarea>
                            </div>                                       
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel-footer">     
                <a href="{{URL::to('tenders/satuankerjas')}}" class="btn btn-default pull-left">Batal</a>  &nbsp;&nbsp;                             
                <button class="btn btn-success"><i class="fa fa-save"></i>Submit</button>
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
