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
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                You are logged in as <code>{{Auth::user()->role}}</code>-<code>{{Auth::user()->name}}</code>
            </div>
        </div>
    </div>
    @if(Auth::user()->role == 'ppk')
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
                                <th>Dokumen</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1;@endphp
                        @if(!empty($tender))
                        @foreach($tender as $value)
                            @php
                                $getTahapan = \App\Models\Procurement\PaketTahapans::getTahapans($value->id);
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
                                    {{ $getTahapan->nama ?? "Paket sudah selesai" }}
                                </td>
                                <td style="vertical-align: middle;">
                                    @if($getTahapan->nama == 'Penerbitan SPPBJ')
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                        E-kontrak <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ route('e-kontrak.sppbj', Crypt::encrypt($value->id)) }}">SPPBJ</a></li>
                                        </ul>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    @if(\App\Models\Procurement\Pakets::StatusPaketSudahDiTeruskan != $value->status_paket)
                                    <a class="btn btn-info" href="{{ route('e-kontrak.diteruskan', Crypt::encrypt($value->id)) }}">
                                        Diteruskan Ke pengendali Kualitas
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
                <div class="tab-pane fade" id="tab2nontender">
                    <table class="table datatable table-hover" id="berita">
                        <thead>
                            <tr>
                                <th width="12%">ID Paket</th>
                                <th>Nama Paket Tender</th>
                                <th>HPS</th>
                                <th>Tahap</th>
                                <th>Dokumen</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($nontender))
                        @foreach($nontender as $value)
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
                                    @php
                                        $getTahapan = \App\Models\Procurement\PaketTahapans::getTahapans($value->id);
                                    @endphp
                                    {{ $getTahapan->nama ?? ""}}
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                        E-kontrak <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ route('e-kontrak.sppbj', Crypt::encrypt($value->id)) }}">SPPBJ</a></li>
                                            <li><a href="{{ route('e-kontrak.ringkasan-kontrak', Crypt::encrypt($value->id)) }}">Ringkasan Kontrak</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    @if(\App\Models\Procurement\Pakets::StatusPaketSudahDiTeruskan != $value->status_paket)
                                    <a class="btn btn-info" href="{{ route('e-kontrak.diteruskan', Crypt::encrypt($value->id)) }}">
                                        Diteruskan Ke pengendali Kualitas
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
    @endif
    @if(Auth::user()->role == 'pengendalikualitas')
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1;@endphp
                            @if(!empty($paket))
                                @foreach($paket as $value)
                                    @php
                                        //dd($value->get_paket);
                                    @endphp
                                    <tr style="cursor:pointer">
                                        <td style="vertical-align: middle;">{!! $value->kode !!}</td>
                                        <td style="vertical-align: middle;">
                                                <a class="" href="{{ route('penawaran.show',\Crypt::encrypt($value->paket_id)) }}">
                                            {!! $value->nama !!}
                                            </a>
                                        </td>
                                        <td style="vertical-align: middle;">@currency($value->nilai_hps)</td>
                                        <td style="vertical-align: middle;">-</td>
                                        <td>
                                            {{-- @if(\App\Models\Procurement\Pakets::StatusPaketDiTeruskankePPK != $value->status_paket) --}}
                                                <a class="btn btn-warning" href="{{route('checklist.pengendalikualitas',\Crypt::encrypt($value->paket_id))}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            {{-- @endif --}}
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
                                    <th>Nama Paket Non Tender</th>
                                    <th>HPS</th>
                                    <th>Tahap</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1;@endphp
                            @if(!empty($data))
                                @foreach($data as $value)
                                    @php
                                        //dd($value->get_paket);
                                    @endphp
                                    <tr style="cursor:pointer">
                                        <td style="vertical-align: middle;">{!! $value->kode !!}</td>
                                        <td style="vertical-align: middle;">
                                            <a class="" href="{{ route('penawaran.show',\Crypt::encrypt($value->paket_id)) }}">
                                            {!! $value->nama !!}
                                            </a>
                                        </td>
                                        <td style="vertical-align: middle;">@currency($value->nilai_hps)</td>
                                        <td style="vertical-align: middle;">-</td>
                                        <td>
                                            <a class="btn btn-warning" href="">
                                                <i class="fa fa-eye"></i>
                                            </a>
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
    @if(Auth::user()->role == 'pokja')
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
                                <th>Peserta</th>
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
                                    @if($value->is_tender_ulang == \App\Models\Procurement\Pakets::TenderUlang)
                                    <button class="btn btn-warning btn-sm btn-rounded">
                                       Tender Ulang
                                    </button>
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">@currency($value->nilai_hps)</td>
                                <td style="vertical-align: middle;">
                                    @php
                                        $getTahapan = \App\Models\Procurement\PaketTahapans::getTahapans($value->id);
                                    @endphp
                                    {{ $getTahapan->nama ?? " "}}
                                </td>
                                <td style="vertical-align: middle;">
                                    @php
                                        $rekananCount = \App\Models\Procurement\PaketRekanan::where('paket_id', $value->id)->count();
                                    @endphp
                                    {{ $rekananCount ?? '-' }}
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
                                $url = "";
                                if( $value->kode_metode == 'PLA' ) {
                                    $url = route('penunjukan-langsung.create-penunjukan',['paket_id' => Crypt::encrypt($value->id)]);
                                } else if( $value->kode_metode == 'PBB') {
                                    $url = route('pembelian-barang-bekas.create',['paket_id' => Crypt::encrypt($value->id)]);
                                }  else if( $value->kode_metode == 'QU') {
                                    $url = route('quotation.create',['paket_id' => Crypt::encrypt($value->id)]);
                                }
                            @endphp
                            <tr style="cursor:pointer">
                                <td style="vertical-align: middle;">{!! $value->kode !!}</td>
                                <td style="vertical-align: middle;">
                                    <a class="" href="{{ $url }}">
                                    {!! $value->nama !!}
                                    </a> &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-info btn-sm btn-rounded">
                                        {{ $value->metode_pemilihan }}
                                    </button>
                                </td>
                                <td style="vertical-align: middle;">@currency($value->nilai_hps)</td>
                                <td style="vertical-align: middle;">
                                    @php
                                        $getTahapan = \App\Models\Procurement\PaketTahapans::getTahapanNontender($value->id);
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
            </div>
        </div>
    </div>   
    @endif
</div>
@endsection
@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
@endsection