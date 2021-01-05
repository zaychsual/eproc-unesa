@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop

@section('assets')
<style>
    .tkh{
        color: black;
    }
</style>
@endsection

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">{!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')

<!-- page start-->
<div class="row">
    <div class="col-md-12">
        <!-- START DEFAULT DATATABLE -->
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info push-down-20">
                    <span style="color: #FFF500;">ATENTION!</span>
                   <!--  <div class="profile-image" style="text-align: center">
                                        <img src="{{ asset('ress/img/ket.jpg') }}" class="img-rounded" alt="vms" width="25%">
                                    </div> -->
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            </div>
        </div>

      {!! Form::model($data, ['route' => ['paket.register', $data->id], 'method'=>'patch', 'files' => true, 'class'=>'form-horizontal']) !!}
      {!! csrf_field() !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form</strong></h3>
            </div>
            <div class="panel-body">
                <label>Pendaftaran Tender</label>
                <div class="form-group @if ($errors->has('kode')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Kode Tender</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('kode', old('kode'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                        </div>  
                            @if ($errors->has('kode'))
                            <span class="help-block">{{$errors->first('kode')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('kode_rup')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Kode REGINA/RUP</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('kode_rup', old('kode_rup'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                        </div>  
                            @if ($errors->has('kode_rup'))
                            <span class="help-block">{{$errors->first('kode_rup')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('pendirian_nomor')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama Tender</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('nama_paket', old('nama_paket'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                        </div>  
                            @if ($errors->has('nama_paket'))
                            <span class="help-block">{{$errors->first('nama_paket')}}</span>
                            @endif                                          
                    </div>
                </div>   

                <div class="form-group @if ($errors->has('pendirian_nomor')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Satuan Kerja</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('satuankerja', old('satuankerja'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                        </div>  
                            @if ($errors->has('satuankerja'))
                            <span class="help-block">{{$errors->first('satuankerja')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('pendirian_nomor')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jenis Pengadaan</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('jenispengadaan', old('jenispengadaan'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                        </div>  
                            @if ($errors->has('jenispengadaan'))
                            <span class="help-block">{{$errors->first('jenispengadaan')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('pendirian_nomor')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tahun</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('tahun', old('tahun'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                        </div>  
                            @if ($errors->has('tahun'))
                            <span class="help-block">{{$errors->first('tahun')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Nilai Pagu Paket</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            <input type="text" class="form-control" value="@currency($data->pagu)" readonly="" style="color: black" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Nilai HPS</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            <input type="text" class="form-control" value="@currency($data->nilai_hps)" readonly="" style="color: black" />
                        </div>
                    </div>
                </div>

                <div class="form-group @if ($errors->has('pendirian_nomor')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Jenis Kontrak</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('jeniskontrak', old('jeniskontrak'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                        </div>  
                            @if ($errors->has('jeniskontrak'))
                            <span class="help-block">{{$errors->first('jeniskontrak')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group @if ($errors->has('kualifikasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Kualifikasi Usaha</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('kualifikasi', old('kualifikasi'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                        </div>  
                            @if ($errors->has('kualifikasi'))
                            <span class="help-block">{{$errors->first('kualifikasi')}}</span>
                            @endif                                          
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Lokasi Pekerjaan</label>
                    <div class="col-md-6 col-xs-12">                                              
                       <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:20%">Provinsi*</th>
                                    <th style="width:45%">Kabupaten/Kota*</th>
                                    <th style="width:35%">Detail Lokasi*</th>
                                </tr>
                            </thead>
                            <tbody id="tbDataLokasi">
                                <tr>
                                    <td>
                                        {{ Form::textarea('prop', old('prop'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                                        @if ($errors->has('prop'))
                                        <span class="help-block">{{$errors->first('prop')}}</span>
                                        @endif              
                                    </td>
                                    <td>                                           
                                        {{ Form::textarea('kota', old('kota'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                                        @if ($errors->has('kota'))
                                        <span class="help-block">{{$errors->first('kota')}}</span>
                                        @endif  
                                    </td>
                                    <td>                                           
                                        {{ Form::textarea('alamat', old('alamat'), array('class' => 'form-control', 'disabled', 'style'=>'color: black;')) }}
                                        @if ($errors->has('alamat'))
                                        <span class="help-block">{{$errors->first('alamat')}}</span>
                                        @endif  
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="panel-body">
                <p>
                 
                </p>
            </div>
            <div class="panel-footer">     
                <a href="{{URL::to('procurement/listpakets')}}" class="btn btn-default pull-left">Batal</a>
                @if(!$data->rRekanan)
                <button type="button" class="btn btn-primary pull-right" onclick='register("{{$data->id}}")'>Mendaftar</button>
                @endif
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
    var urlRegister = "{{ route('paket.register') }}";
    var urlListPaket = "{{ route('listpakets.index') }}";

    function PreviewImage() {
    var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

            oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function register(id) {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: urlRegister,
            data: { paket_id: id }
        }).done(function (data) {
            if(data.status == 'success') {
                swal("Berhasil", "Registrasi Berhasil", "success");
                window.location.href = urlListPaket;
            } else {
                swal("Gagal", "Registrasi Gagal", "error");
                window.location.href = urlListPaket;
            }
        });
    }
</script>

@stop
