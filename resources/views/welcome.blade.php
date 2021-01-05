@extends('procurement.layouts.tender.app')

@section('title')
  Dashboard
@endsection

@section('breadcrumbs')
<li class="active">Dashboard</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> Dashboard</h2>
@stop

@section('content')
<div class="page-content-wrap">
                    
    <!-- START WIDGETS -->  
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info push-down-20">
                <span style="color: #FFF500;">ATENTION!!!</span> You are logged in as <code>Penyedia</code>-<code>{{Auth::user()->name}}</code>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
        @if(Auth::user()->role == 'laman')
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
									<th>Tahap</th>
								</tr>
							</thead>
							<tbody>
							@php $no = 1;@endphp
                            @if(!empty($tender))
							@foreach($tender as $value)
								@php
									//dd($value);
								@endphp
								<tr style="cursor:pointer">
									<td style="vertical-align: middle;">{!! $value->kode ?? '' !!}</td>
									<td style="vertical-align: middle;">
										 <a class="" href="{{ route('laman-tender.show',\Crypt::encrypt($value->paket_id)) }}">
                                        {!! ucfirst($value->paket) ?? "" !!}
                                        </a>
										<button class="btn btn-info btn-sm btn-rounded">
											{{ $value->metode_pemilihan }}
										</button>
									</td>
									<td style="vertical-align: middle;">@currency($value->nilai_hps)</td>
									<td style="vertical-align: middle;">
										@php
											$getTahapan = \App\Models\Procurement\PaketTahapans::getTahapans($value->paket_id);
										@endphp
										{{ $getTahapan->nama ?? ''}}
									</td>
								<?php $no++;?>
								</tr>
							@endforeach
                            @endif
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
									<th>Tahap</th>
								</tr>
							</thead>
							<tbody>
							@php $no = 1;@endphp
                            @if(!empty($nontender))
							@foreach($nontender as $value)
								@php
									$url = route('laman-nontender.show',\Crypt::encrypt($value->paket_id));
									if( $value->code == 'PL') {
										$url = route('laman-nontender.kirim-penawaran',\Crypt::encrypt($value->paket_id));
									} else if( $value->code == 'PBB' ) {
										$url = route('laman-nontender.kirim-penawaran-pbb',\Crypt::encrypt($value->paket_id));
									}
								@endphp
								<tr style="cursor:pointer">
									<td style="vertical-align: middle;">{!! $value->kode ?? 0 !!}</td>
									<td style="vertical-align: middle;">
                                        <a class="" href="{{ $url }}">
                                        {!! ucfirst($value->paket) ?? "" !!}
                                        </a>
										<button class="btn btn-info btn-sm btn-rounded">
											{{ $value->metode_pemilihan }}
										</button>
                                    </td>
									<td style="vertical-align: middle;">@currency($value->nilai_hps ?? 0)</td>
									<td style="vertical-align: middle;">
										 @php
											$getTahapan = \App\Models\Procurement\PaketTahapans::getTahapanNontender($value->paket_id);
										@endphp
										{{ $getTahapan->nama ?? '-'}}
									</td>
								<?php $no++;?>
								</tr>
							@endforeach
                            @endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>   
        @endif
    </div>
    
    <!-- START DASHBOARD CHART -->
	<div class="chart-holder" id="dashboard-area-1" style="height: 700px;"></div>
	<div class="block-full-width">
                                           
    </div>                    
    <!-- END DASHBOARD CHART -->
    
</div>

@endsection
@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
@endsection
