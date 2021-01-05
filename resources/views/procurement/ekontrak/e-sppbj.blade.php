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
				@if(\App\Models\Procurement\EkontrakSppbj::where('paket_id',Crypt::decrypt($paket_id))->first() == null )
				<a class="btn btn-info" href="{{ route('e-kontrak.sppbj-create',$paket_id)}}" style="margin: 0cm 0px 0cm 10px;">Tambah</a>
				@endif
				<ul class="panel-controls">
					<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
				</ul>
			</div>
			<div class="panel-body">
				<table class="table datatable table-hover" id="berita">
					<thead>
						<tr>
							<th>Nomor</th>
							<th>Tanggal</th>
							<th>Penyedia</th>
							<th>Harga Final</th>
							<th>Kontrak</th>
							<th>SSKK</th>
							<th>SPK</th>
							<th>Pembayaran</th>
							<th>Dokumen Lain</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
					@foreach($eSppbj as $value)
						<tr style="cursor:pointer">
							<td>{{ $value->sppbj_no }}</td>
							<td>{{ $value->sppbj_tanggal }}</td>
							<td>{{ $value->getRk['nama'] ?? "" }}</td>
							<td>@currency($value->sppbj_harga_final)</td>
							<td>
								@if(\App\Models\Procurement\Ekontrak::where('paket_id',Crypt::decrypt($paket_id))->first() == null )
								<a class="btn btn-default" href="{{ route('e-kontrak.create-kontrak', $paket_id) }}">
									Kontrak
								</a>
								@else 
								<i class="fa fa-check"></i>
								@endif
							</td>
							<td>
							  @if(\App\Models\Procurement\EkontrakSskk::where('paket_id',Crypt::decrypt($paket_id))->first() == null )
								<a class="btn btn-default" href="{{ route('e-kontrak.create-sskk', $paket_id) }}">
									SSKK
								</a>
								@else 
								<i class="fa fa-check"></i>
								@endif
							</td>
							<td>@if(\App\Models\Procurement\EkontrakSpk::where('paket_id',Crypt::decrypt($paket_id))->first() == null )
								<a class="btn btn-default" href="{{ route('e-kontrak.create-spk', $paket_id) }}">
									SPK
								</a>
								@else 
								<i class="fa fa-check"></i>
								@endif</td>
							<td>
								@if(\App\Models\Procurement\EkontrakBap::where('paket_id',Crypt::decrypt($paket_id))->first() == null )
								<a class="btn btn-default" href="{{ route('e-kontrak.pembayaran', $paket_id) }}">
									Pembayaran
								</a>
								@else 
								<i class="fa fa-check"></i>
								@endif
							</td>
							<td></td>
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
