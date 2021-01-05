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
        <form method="post" action="{{ route('penunjukan-langsung.store-pemilihan-rekanan') }}">
            @csrf
            <input type="hidden" name="paket_id" value="{{ $paket['id'] }}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-heading">
                        <p>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table datatable table-hover" id="berita">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Kode</th>
                                <th>Nama Perusahaan</th>
                                <th>Tanggal Daftar</th>
                                <th>Bentuk Usaha</th>
                                <th>Jenis Pengadaan</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($rekanan as $value)
                            <tr style="cursor:pointer">
                                <td align="center">
                                    <input type="checkbox" name="rekanan_id[]" value="{{ $value->id }}">
                                </td>
                                <td>{!! $value->kode !!}</td>
                                <td>{!! $value->nama !!}</td>
                                <td>{!! $value->created_at !!}</td>
                                <td>{{$value->rBentukUsahas->name}}</td> 
                                <td>{!! $value->rJenisPengadaans->name !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <!-- END DEFAULT DATATABLE -->
    </div>
</div>
<!-- page end-->
@stop

@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
@stop
