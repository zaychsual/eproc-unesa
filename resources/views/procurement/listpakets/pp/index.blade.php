@extends('procurement.layouts.tender.app')

@section('title')
  Dashboard
@endsection

@section('breadcrumbs')
<li class="active">{{ $title }}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {{ $title }}</h2>
@stop

@section('content')
<div class="page-content-wrap">
    <!-- START WIDGETS -->  
    <div class="row">
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1;@endphp
                            @if(!empty($tender))
                            @foreach($tender as $value)
                                @php
                                    //dd($value->get_paket);
                                @endphp
                                <tr style="cursor:pointer">
                                    <td style="vertical-align: middle;">{!! $value->kode !!}</td>
                                    <td style="vertical-align: middle;">
                                        <a class="" href="{{ route('tender.create-tender',\Crypt::encrypt($value->id)) }}">
                                        {!! ucfirst($value->nama) !!}
                                        </a>
                                        &nbsp;&nbsp;&nbsp;
                                        <button class="btn btn-info btn-sm btn-rounded">
                                            {{ $value->metode_pemilihan }}
                                        </button>
                                    </td>
                                    <td style="vertical-align: middle;">@currency($value->nilai_hps)</td>
                                    <td style="vertical-align: middle;">
                                        <a class="btn btn-info" href="{{ route('tender.create-tender',\Crypt::encrypt($value->id)) }}">
                                            <i class="fa fa-edit"></i> Buat Tender
                                        </a>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1;@endphp
                            @if(!empty($nontender))
                            @foreach($nontender as $value)
                                @php
                                    $url = "";
                                    if( $value->kode_metode == 'PLA' ) {
                                        $url = route('penunjukan-langsung.create-penunjukan',['paket_id' => Crypt::encrypt($value->id)]);
                                    } else if( $value->kode_metode == 'PL' ) {
                                        $url = route('pembelian-langsung.create',Crypt::encrypt($value->id));
                                    } else if( $value->kode_metode == 'PBB' ) {
                                        $url = route('pembelian-barang-bekas.create',Crypt::encrypt($value->id));
                                    } else if( $value->kode_metode== 'EP' ) {
                                        $url = route('epurchasing.create', Crypt::encrypt($value->id));
                                    }
                                @endphp
                                @endphp
                                <tr style="cursor:pointer">
                                    <td style="vertical-align: middle;">{!! $value->kode !!}</td>
                                    <td style="vertical-align: middle;">
                                        <a class="" href="">
                                        {!! $value->nama !!}
                                        </a> &nbsp;&nbsp;&nbsp;
                                        <button class="btn btn-info btn-sm btn-rounded">
                                            {{ $value->metode_pemilihan }}
                                        </button>
                                    </td>
                                    <td style="vertical-align: middle;">@currency($value->nilai_hps)</td>
                                    <td style="vertical-align: middle;">
                                        @if($value->status_paket != \App\Models\Procurement\Pakets::PaketSelesai)
                                        <a class="btn btn-info" href="{{ $url }}">
                                            <i class="fa fa-edit"></i> Buat NonTender
                                        </a>
                                        @endif
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
    </div>
</div>
 {{-- ini kenapa cok --}}
@endsection
@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
@endsection
