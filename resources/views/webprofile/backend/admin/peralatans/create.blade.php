@extends('webprofile.layouts.backend.child')

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

		{!! Form::open(array('url' => route('peralatans.store'), 'method' => 'POST', 'id' => 'ffperalatans', 'class' => 'form-horizontal')) !!}
		{!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong> </h3>
            </div>
            <div class="panel-body">

                <div class="form-group @if ($errors->has('nama')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama Alat *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('nama', old('nama'), array('class' => 'form-control')) }}
                        </div>  
                            @if ($errors->has('nama'))
                            <span class="help-block">{{$errors->first('nama')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('jumlah')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jumlah *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('jumlah', old('jumlah'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('jumlah'))
                            <span class="help-block">{{$errors->first('jumlah')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('kapasitas')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Kapasitas</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('kapasitas', old('kapasitas'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('kapasitas'))
                            <span class="help-block">{{$errors->first('kapasitas')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('merk')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Merk/Tipe</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('merk', old('merk'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('merk'))
                            <span class="help-block">{{$errors->first('merk')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('tahun_pembuatan')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tahun Pembuatan *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('tahun_pembuatan', old('tahun_pembuatan'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('tahun_pembuatan'))
                            <span class="help-block">{{$errors->first('tahun_pembuatan')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('kondisi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Kondisi</label>
                    <div class="col-md-6 col-xs-12">                                              
                        {{ Form::select('kondisi', array('Baik' => 'Baik', 'Rusak' => 'Rusak'), old('kondisi'), ['class' => 'form-control select', 'style' => 'width: 100%;', 'id' => 'kondisi', 'placeholder' => 'Pilih Satuan', 'required']) }}
                            @if ($errors->has('kondisi'))
                            <span class="help-block">{{$errors->first('kondisi')}}</span>
                            @endif
                    </div>
                </div>    

                <div class="form-group @if ($errors->has('lokasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Lokasi Sekarang</label>
                    <div class="col-md-6 col-xs-12">                                            
                        {{ Form::textarea('lokasi', old('lokasi'), array('class' => 'form-control')) }}
                            @if ($errors->has('lokasi'))
                            <span class="help-block">{{$errors->first('lokasi')}}</span>
                            @endif
                    </div>
                </div>  

                <div class="form-group @if ($errors->has('status_kepemilikan')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Status Kepemilikan</label>
                    <div class="col-md-6 col-xs-12">                                              
                        {{ Form::select('status_kepemilikan', $status_miliks, old('status_kepemilikan'), ['class' => 'form-control select', 'style' => 'width: 100%;', 'id' => 'status_kepemilikan', 'placeholder' => 'Pilih Satuan', 'required']) }}
                            @if ($errors->has('status_kepemilikan'))
                            <span class="help-block">{{$errors->first('status_kepemilikan')}}</span>
                            @endif
                    </div>
                </div> 

                <div class="form-group @if ($errors->has('bukti')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Bukti Kepemilikan</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('bukti', old('bukti'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('bukti'))
                            <span class="help-block">{{$errors->first('bukti')}}</span>
                            @endif                                           
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <p>
                  * Data ini harus diisi.<br>
                </p>
            </div>
            <div class="panel-footer">     
                <a href="{{URL::to('webprofile/peralatans')}}" class="btn btn-default pull-left">Batal</a>                               
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
<script type="text/javascript">
    
//   $('#status_miliks').select2();

    $('#ffperalatans').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:"{{ route('peralatans.store') }}",
            method:"POST",
            data: new FormData(this),
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(data)
            {
                if(data.errors)
                {
                    swal({ 
                        title: "Warning",
                        text: data.errors,
                        type: "Warning" 
                        });
                }
                if(data.success)
                {
                    swal({ 
                        title: "Success",
                        text: data.success,
                        type: "success" 
                        },
                        function(){
                            window.parent.loadFramePeralatan();
                            window.parent.closePopup();
                    });
                }
            }
        });
    });
</script>
@stop
