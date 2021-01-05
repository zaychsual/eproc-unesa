@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">User</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<!-- START DEFAULT DATATABLE -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{!! $title !!}</h3>
				{{-- <a class="btn btn-info" href="{{URL::to('webprofile/ppk/create')}}" style="margin: 0cm 0px 0cm 10px;">Tambah</a> --}}
				<ul class="panel-controls">
					<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
				</ul>
			</div>
			<div class="panel-body">
				<table class="table datatable table-hover" id="berita">
					<thead>
						<tr>
							<th width="7%">No</th>
							<th width="20%">Nama</th>
							<th width="30%">Email</th>
							<th width="10%">Status</th>
							<th align="center" width="15%">Aksi</th>
						</tr>
					</thead>
					<tbody>
					<?php $no = 1;?>
					@foreach($users as $value)
						<tr style="cursor:pointer">
							<td align="center"><?php echo $no; ?></td>
							<td>{!! $value->name !!}</td>
							<td>{!! $value->email !!}</td>
							<td style="text-align: center;">
								@if($value->is_active == \App\User::Active)
								  <i class="fa fa-check" style="color: green"></i>
								@endif
								@if($value->is_active == \App\User::NotActive)
								  <i class="fa fa-times" style="color: red"></i>
								@endif
							  </td>
							  <td style="text-align:center;">

								  <a href="{{ route('pokja.show', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a>
								</td>
						   <?php $no++;?>
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
 