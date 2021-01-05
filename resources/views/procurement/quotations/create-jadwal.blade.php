@extends('procurement.layouts.tender.app')

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
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <p>
                    Input Jadwal Tender 
                </p>
	        </div>
	        <div class="panel-body">
	            <div class="row">
                    {!! Form::open(array('url' => route('quotation.store-jadwal'), 'method' => 'POST', 'id' => 'file', 'class' => 'form-horizontal', 'files' => true)) !!}
                        @csrf
                        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                        <table class="table table-bordered">
                            <tr>
                                <th>No.</th>
                                <th>Tahap</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                            @foreach($paketTahaps as $k => $val)
                            <input type="hidden" name="tahapan_id[]" value="{{ $val->id }}">
                            <tr>
                                <td>{{ $k + 1 }}</td>
                                <td>{{ $val->nama }}</td>
                                <td>
                                    <input type="text" name="waktu_mulai[]" class="form-control datetime" id="datetimepicker2">
                                </td>
                                <td>
                                    <input type="text" name="waktu_selesai[]" class="form-control datetime" id="datetimepicker2">
                                </td>
                            </tr>
                            @endforeach;
                        </table>
                            
                        <br>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop