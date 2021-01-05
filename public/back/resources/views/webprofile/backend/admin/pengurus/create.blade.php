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

		{!! Form::open(array('url' => route('pengurus.store'), 'method' => 'POST', 'id' => 'ffpengurus', 'class' => 'form-horizontal')) !!}
		{!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong> </h3>
            </div>
            <div class="panel-body">

                <div class="form-group @if ($errors->has('nama')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama *</label>
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

                <div class="form-group @if ($errors->has('ktp')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nomor KTP *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('ktp', old('ktp'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('ktp'))
                            <span class="help-block">{{$errors->first('ktp')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group @if ($errors->has('alamat')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Alamat</label>
                    <div class="col-md-6 col-xs-12">                                            
                        {{ Form::textarea('alamat', old('alamat'), array('class' => 'form-control')) }}
                            @if ($errors->has('alamat'))
                            <span class="help-block">{{$errors->first('alamat')}}</span>
                            @endif
                    </div>
                </div>    

                <div class="form-group @if ($errors->has('jabatan')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jabatan *</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('jabatan', old('jabatan'), array('class' => 'form-control')) }}
                        </div> 
                            @if ($errors->has('jabatan'))
                            <span class="help-block">{{$errors->first('jabatan')}}</span>
                            @endif                                           
                    </div>
                </div>

                <div class="form-group">                                        
                    <label class="col-md-3 col-xs-12 control-label">Menjabat Sejak *</label>
                    <div class="col-md-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('tanggal_awal', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                        </div>
                        @if ($errors->has('tanggal_awal'))
                            <span class="help-block">{{$errors->first('tanggal_awal')}}</span>
                            @endif 
                    </div>
                </div>

                <div class="form-group">                                        
                    <label class="col-md-3 col-xs-12 control-label">Sampai **</label>
                    <div class="col-md-6 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::text('tanggal_akhir', date('Y-m-d'), array('class' => 'form-control datepicker')) }}                                            
                        </div>
                        @if ($errors->has('tanggal_akhir'))
                            <span class="help-block">{{$errors->first('tanggal_akhir')}}</span>
                            @endif 
                    </div>
                </div>       

            </div>
            <div class="panel-body">
                <p>
                    * Data ini harus diisi.<br>
                    ** Isi dengan tanggal terakhir pengurus perusahaan. Kosongkan jika masih menjabat.
                </p>
            </div>
            <div class="panel-footer">     
                <a href="{{URL::to('webprofile/pengurus')}}" class="btn btn-default pull-left">Batal</a>                               
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
    $('#ffpengurus').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:"{{ route('pengurus.store') }}",
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
                            window.parent.loadFramePengurus();
                            window.parent.closePopup();
                    });
                }
            }
        });
    });
</script>
@stop
