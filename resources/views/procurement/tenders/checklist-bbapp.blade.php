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
        {!! Form::open(array('url' => route('checklist.store-pengendalikualitas'), 'method' => 'POST', 'id' => 'pakets', 'class' => 'form-horizontal', 'files' => true)) !!}
        {!! csrf_field() !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Form</strong> </h3>
                </div>
                <div class="panel-body">
                    <div class="form-group @if ($errors->has('no_bap')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Nomor Berita Acara Pemeriksa</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::text('no_bap', old('no_bap'), array('class' => 'form-control', 'required')) }}
                            </div>  
                                @if ($errors->has('no_bap'))
                                <span class="help-block">{{$errors->first('no_bap')}}</span>
                                @endif                                          
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('tgl_bap')) has-error @endif">
                        <label class="col-md-3 col-xs-12 control-label"><b>Tanggal Berita Acara Pemeriksa</b></label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                {{ Form::date('tgl_bap', old('tgl_bap'), array('class' => 'form-control', 'id'=>'tgl_bap', 'required')) }}
                            </div> 
                                @if ($errors->has('tgl_bap'))
                                <span class="help-block">{{$errors->first('tgl_bap')}}</span>
                                @endif                                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Daftar Checklist Barang</label>
                        <div class="col-md-6 col-xs-12">                                              
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Uraian Pekerjaan</th>
                                        <th style="width:30%">Volume</th>
                                        <th style="width:30%">Satuan</th>
                                        <th style="width:30%">Checklist</th>
                                    </tr>
                                </thead>
                                <tbody id="hps">
                                	@foreach($paket as $data)
                                    <tr>
                                        <td>
                                            {{$data->pekerjaan}}
                                        </td>
                                        <td>
                                        	{{$data->qty}}
                                        </td>
                                        <td>{{$data->satuan}}
                                        </td>
                                        <td>
                                            <input type="checkbox" name="checklist[]" id="check" value="{{$data->id}}" {{($data->is_check != 0)?"checked":"ada"}}>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Status Paket</label>
                        <div class="col-md-6 col-xs-12">
                            <select name="status_paket" id="status_paket" class="form-control">
                                <option value=""> -- Pilih --</option>
                                <option value="7"> Belum Selesai</option>
                                <option value="8"> Sudah Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Catatan</label>
                        <div class="col-md-6 col-xs-12">
                            {{ Form::textarea('notes', old('notes'), array('class' => 'form-control', 'style'=>'color: black;')) }}
                            @if ($errors->has('notes'))
                            <span class="help-block">{{$errors->first('notes')}}</span>
                            @endif  
                        </div>
                    </div>
                    <hr>
                <div class="panel-footer">     
                    <a href="{{URL::to('/procurement/pakets')}}" class="btn btn-default pull-left">Batal</a>                               
                    <a href="{{ route('print.bbapp',$paket_id)}}" class="btn btn-info pull-left">Print</a>                               
                    <button class="btn btn-primary pull-right">Submit</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
<!-- page end-->
@stop

@section('script')
{{Html::script('js/jquery.mask.min.js')}}\
@stop