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
		<div class="panel with-nav-tabs panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"></h3>
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1tender" data-toggle="tab">Tender</a></li>
					<li><a href="#tab2nontender" data-toggle="tab">Non Tender</a></li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane fade in active" id="tab1tender">
						<table class="table datatable table-hover" id="berita">
							<thead>
								<tr>
									<th width="12%">ID Paket</th>
									<th>Nama Paket Tender</th>
									<th>HPS</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
							@php $no = 1;@endphp
							@foreach($tender as $value)
								@php
                                    $isIkut = \App\Models\Procurement\PaketRekanan::where('paket_id', $value->id)->first();
									//dd($value->get_paket);
								@endphp
                                @if($isIkut == null)
								<tr style="cursor:pointer">
									<td style="vertical-align: middle;">{!! $value->kode ?? "" !!}</td>
									<td style="vertical-align: middle;">
                                        {!! ucfirst($value->nama) ?? "" !!}
                                         <button class="btn btn-info btn-sm btn-rounded">
                                            {{ $value->name }}
										</button>
										@if($value->is_tender_ulang == \App\Models\Procurement\Pakets::TenderUlang)
											<button class="btn btn-warning btn-sm btn-rounded">
											Tender Ulang
											</button>
										@endif
                                    </td>
									<td style="vertical-align: middle;">@currency($value->nilai_hps ?? "")</td>
									<td style="text-align:center;">
										<a class="btn btn-warning btn-sm" href="{{ route('paket-baru.show-paket', ['id' => Crypt::encrypt($value->id),'is_tender' => 'tender']) }}">
											<i class="fa fa-eye"></i> Detail
										</a>
									</td>
								<?php $no++;?>
								</tr>
                                @endif
							@endforeach
							</tbody>
						</table>
					</div>
					<div class="tab-pane fade" id="tab2nontender">
						<table class="table datatable table-hover" id="berita">
							<thead>
								<tr>
									<th width="12%">ID Paket</th>
									<th>Nama Paket Tender</th>
									<th>HPS</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
							@php $no = 1;@endphp
							@foreach($nontender as $value)
								@php
                                    $isIkut = \App\Models\Procurement\PaketRekanan::where('paket_id', $value->paket_id)
										->where('status',\App\Models\Procurement\PaketRekanan::Approved)
										->where('mt_rekanan_id', \Auth::user()->mt_rekanan_id)
										->first();
								//dd($isIkut);
								@endphp
                                @if($isIkut == null)
								<tr style="cursor:pointer">
									<td style="vertical-align: middle;">{!! $value->kode ?? "" !!}</td>
									<td style="vertical-align: middle;">
                                        {!! ucfirst($value->paket) ?? "" !!}
                                        <button class="btn btn-info btn-sm btn-rounded">
                                            {{ $value->metode_pemilihan }}
                                        </button>
                                    </td>
									<td style="vertical-align: middle;">@currency($value->nilai_hps ?? 0)</td>
									<td style="text-align:center;">
										<a class="btn btn-warning btn-sm" href="{{ route('paket-baru.show-paket',['id' => Crypt::encrypt($value->paket_id),'is_tender' => 'nontender']) }}">
											<i class="fa fa-eye"></i> Detail
										</a>
									</td>
								<?php $no++;?>
								</tr>
                                @endif
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
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
