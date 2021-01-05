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
                Paket Diteruskan ke pengendali kualitas
            </div>
            <div class="panel-body">
                <form action="{{ route('store-diteruskan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                    <table class="table table-hover" id="berita">
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>
                                <input type="date" name="tanggal" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Pilih Pegendali Kualitas </td>
                            <td>:</td>
                            <td>
                                <select name="pilihpp" id="pilihpp" class="form-control">
                                    <option value=""> -- Pilih --</option>
                                    <option value="10"> Pengendali Kualitas</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="data-anggota">
                            
                        </tr>
                    </table>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $("#pilihpp").change(function(e) {
        e.preventDefault()

        const url = '{{ route('get-anggota-pp') }}'

        $.getJSON(url, function (data) {
            let htmltable = ''

            $.each(data, function(k,v) {
                htmltable += `
                        <td><td>
                        <td><input type="checkbox" name="pengendali_kualitas_id[]" value="${v.id}"> ${v.name}</td>
                `
            })

            $("#data-anggota").html(htmltable)

        });
    })
</script>

@stop