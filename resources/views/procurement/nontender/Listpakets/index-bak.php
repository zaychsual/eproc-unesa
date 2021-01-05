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
							<th width="12%">Kode Tender</th>
							<th>Nama Paket Tender</th>
							<th>HPS</th>
							<th width="10%"></th>
						</tr>
					</thead>
					<tbody>
					@php $no = 1;@endphp
					@foreach($data as $value)
						<tr style="cursor:pointer">
							<td style="vertical-align: middle;">{!! $value->kode !!}</td>
							<td style="vertical-align: middle;">
							<b>{!! $value->nama_paket !!}</b> <hr>
							@if(!$value->rRekanan)
							  -
							  @else
							  <b>Link Rapat Penjelasan:</b> <a href="{!! $value->link !!}" target="_blank">{!! $value->link !!}</a>
							@endif
							</td> 
							<td style="vertical-align: middle;">@currency($value->nilai_hps)</td>
							<td style="text-align:center;">
							  @if(!$value->rRekanan)
								<a href="{{ route('listpakets.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-search"></i> Klik Mendaftar</a>
								@else
								@php
								if ($value->link_file_kak)
								{
									$val_kak = explode("###", $value->link_file_kak);
									$no_kak = 1;
									for($i=0; $i<count($val_kak); $i++)
									{
								@endphp
								  <div>
								  <?php
									 $sekarang = date("d-m-Y");
									 $now      = new DateTime();
									 $mulai    = $value->setting_unduh_buka;
									 $selesai  = $value->setting_unduh_tutup;
									
									 $startdate = new DateTime("$mulai");
									 $enddate   = new DateTime("$selesai");
									if($startdate <= $now && $now <= $enddate) 
									{
								  ?>
									<a href="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/eproc/dok_pengadaan/{{ $val_kak[$i] }}" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-download"></i> Dokumen Pengadaan {{$no_kak}}</a>
								  </div><br>
								  <?php } ?>

								@php
									  $no_kak++;
									}
								}
								
								if ($value->link_file_kontrak)
								{
									$val_kontrak = explode("###", $value->link_file_kontrak);
									$no_kontrak = 1;
									for($i=0; $i<count($val_kontrak); $i++)
									{
								@endphp
								  <div>
									
								
									<a href="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/eproc/syarat_pengadaan/{{ $val_kontrak[$i] }}" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-download"></i> Syarat Pengadaan {{$no_kontrak}}</a>
								  </div>
								  

								@php
									  $no_kontrak++;
									}
								}
								@endphp
							  @endif
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
