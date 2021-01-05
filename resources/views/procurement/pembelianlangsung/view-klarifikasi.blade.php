@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">{!! $title !!}</li>
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
                <table class="table table-bordered">
                    <tr>
                        <th>Klarifikasi</th>
                        <th>Hasil</th>
                    </tr>
                    @foreach($klarifikasi as $rows)
                    <tr> 
                        <td>{{ $rows->getKlarifikasi['klarifikasi']}}</td>
                        <td>{{$rows->hasil_klarifikasi}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@stop