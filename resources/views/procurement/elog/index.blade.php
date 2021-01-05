@extends('procurement.layouts.tender.app')

@section('title')
Dashboard
@endsection

@section('breadcrumbs')
<li class="active">Log Akses</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> Log Akses</h2>
@stop

@section('content')
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		</div>
		<div class="panel with-nav-tabs panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"></h3>
			</div>
			<div class="panel-body">
				<table class="table datatable table-hover" id="berita">
					<thead>
						<tr>
							<th width="12%">No</th>
							<th>Tanggal dan Waktu Login</th>
							<th>Aplikasi Login</th>
							<th>Sistem Login</th>
						</tr>
					</thead>
					<tbody>
						@php $no = 1;@endphp
						@foreach($log as $value)
						<tr style="cursor:pointer">
							<td style="vertical-align: middle;">{{ $no }}</td>
							<td style="vertical-align: middle;">{{date('d-m-Y H:i',strtotime($value->last_login))}}</td>
							<td style="vertical-align: middle;">{{$value->browser_login}}</td>
							<td style="vertical-align: middle;">{{$value->device_login}}</td>
							<?php $no++;?>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>   
	</div> 

</div>

@endsection
@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
@endsection
