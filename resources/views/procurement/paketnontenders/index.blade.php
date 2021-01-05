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
				<ul class="panel-controls">
					<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
				</ul>
			</div>
			<div class="panel-body">
				<table class="table datatable table-hover" id="berita">
					<thead>
						<tr>
							<th width="12%">ID Paket</th>
							<th>Nama Paket Tender</th>
							<th>HPS</th>
							<th>Tahap</th>
							<th width="10%"></th>
						</tr>
					</thead>
					<tbody>
					@php $no = 1;@endphp
					@foreach($data as $value)
                        @php
                            //dd($value->get_paket);
                        @endphp
						<tr style="cursor:pointer">
							<td style="vertical-align: middle;">{!! $value->get_paket['kode'] !!}</td>
							<td style="vertical-align: middle;">{!! $value->get_paket['nama'] !!}</td>
							<td style="vertical-align: middle;">@currency($value->get_paket['nilai_hps'])</td>
							<td style="vertical-align: middle;">-</td>
							<td style="text-align:center;">

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
<script>
  $('button#btn_delete').on('click', function(e){
	e.preventDefault();
	var data = $(this).attr('data-file');

	swal({
	  title             : "Apakah Anda Yakin?",
	  text              : "Anda akan menghapus data ini!",
	  type              : "warning",
	  showCancelButton  : true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText : "Yes",
	  cancelButtonText  : "No",
	  closeOnConfirm    : false,
	  closeOnCancel     : false
	},
	function(isConfirm){
	  if(isConfirm){
		swal("Terhapus","Data berhasil dihapus", "success");
		setTimeout(function() {
		  $("#"+data).submit();
		}, 1000); // 1 second delay
	  }
	  else{
		swal("Dibatalkan","Data batal dihapus", "error");
	  }
	}
  );});

  $('button#btn_aktif').on('click', function(e){
	  e.preventDefault();
	  var data = $(this).attr('data-file');

	  swal({
		title             : "Apakah Anda yakin?",
		text              : "Data ini dipakai!",
		type              : "warning",
		showCancelButton  : true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText : "Yes",
		cancelButtonText  : "No",
		closeOnConfirm    : false,
		closeOnCancel     : false
	  },
	  function(isConfirm){
		if(isConfirm){
		  swal("Dipakai","Data dipakai", "success");
		  setTimeout(function() {
			$("#aktif_"+data).submit();
		  }, 1000); // 1 second delay
		}
		else{
		  swal("cancelled","Dibatalkan", "error");
		}
	  }
  );});

  $('button#btn_naktif').on('click', function(e){
	  e.preventDefault();
	  var data = $(this).attr('data-file');

	  swal({
		title             : "Apakah Anda yakin?",
		text              : "Data ini tidak dipakai!",
		type              : "warning",
		showCancelButton  : true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText : "Yes",
		cancelButtonText  : "No",
		closeOnConfirm    : false,
		closeOnCancel     : false
	  },
	  function(isConfirm){
		if(isConfirm){
		  swal("Tidak dipakai","Data tidak dipakai", "success");
		  setTimeout(function() {
			$("#non_aktif_"+data).submit();
		  }, 1000); // 1 second delay
		}
		else{
		  swal("cancelled","Dibatalkan", "error");
		}
	  }
  );});
</script>
@stop
