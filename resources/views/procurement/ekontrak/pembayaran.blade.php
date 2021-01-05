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
		<!-- START DEFAULT DATATABLE -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"></h3>
				<a class="btn btn-info" href="{{ route('e-kontrak.create-pembayaran',$paket_id)}}" style="margin: 0cm 0px 0cm 10px;">Tambah</a>
				<ul class="panel-controls">
					<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
				</ul>
			</div>
			<div class="panel-body">
				<table class="table datatable table-hover" id="berita">
					<thead>
						<tr>
							<th>Termijn</th>
							<th>Berita Acara</th>
							<th>Progress Fisik</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; ?>
						@foreach($pembayaran as $value)
							<tr style="cursor:pointer">
								<td>Termin Ke-{{$no++}}</td>
								<td><a class="btn btn-default" href="{{ route('e-kontrak.create-bap', Crypt::encrypt($value->id)) }}">BAP</a>
								<td>{{$value->bap_progress_fisik}}</td>
								<td></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<!-- END DEFAULT DATATABLE -->
	</div>
</div>
<!-- page end-->
@stop

@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
@stop
