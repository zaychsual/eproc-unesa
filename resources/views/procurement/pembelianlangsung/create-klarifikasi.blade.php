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
                    <b> 
                        Input Klarifikasi
                    </b>
                </p>
	        </div>
	        <div class="panel-body">
                <form action="{{ route('pembelian-barang-bekas.store-klarifikasi') }}" method="post">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{$paket->id}}">
                    <table>
                        @foreach($klarifikasi as $i => $val )
                        <tr>
                            <td>{{ $val->klarifikasi }}</td>
                            <td> &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <input type="hidden" name="mt_klarifikasi_id[]" value="{{$val->id}}">
                                <input type="text" name="hasil_klarifikasi[]" class="form-control">
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary"> submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop