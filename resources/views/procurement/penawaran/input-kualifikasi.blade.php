@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop
@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Edit {!! $title !!}</li>
@stop
@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop
@section('content')
<!-- page start-->
<div class="row">
	<div class="col-md-12">
       {!! Form::open(array('url' => route('penawaran.store-data-kualifikasi'), 'method' => 'POST', 'id' => 'file', 'class' => 'form-horizontal', 'files' => true)) !!}
            @csrf
            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
            <div class="panel panel-default">
                <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tabizin" data-toggle="tab">Ijin usaha</a></li>
                            <li><a href="#tabpajak" data-toggle="tab">Pajak</a></li>
                            <li><a href="#tabdukungan" data-toggle="tab">Dukungan Bank</a></li>
                            <li><a href="#tabakta" data-toggle="tab">Akta</a></li>
                            <li><a href="#tabta" data-toggle="tab">Tenaga Ahli</a></li>
                            <li><a href="#tabpengalaman" data-toggle="tab">Pengalaman</a></li>
                            <li><a href="#tabpekerjaan" data-toggle="tab">Pekerjaan Sedang Berjalan</a></li>
                            <li><a href="#tabperalatan" data-toggle="tab">Peralatan</a></li>
                            <li><a href="#tabsyaratlain" data-toggle="tab">Persyaratan Lainnya</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tabizin">
                            <table class="table table-responsive">
                                <thead>
                                    <th></th>
                                    <th>Ijin Usaha</th>
                                    <th>Nomor Surat</th>
                                    <th>Instansi Pemberi</th>
                                </thead>
                                <tbody>
                                    @foreach($ijinUsaha as $key => $value)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="ijin_usaha_id[]" value="{{ $value->id }}">
                                        </td>
                                        <td>{{ $value->jenis_ijin }}</td>
                                        <td>{{ $value->nomor_surat }}</td>
                                        <td>{{ $value->instansi }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabpajak">
                            <table class="table table-responsive">
                                <thead>
                                    <th></th>
                                    <th>Pajak</th>
                                    <th>Tanggal</th>
                                    <th>No. Bukti</th>
                                </thead>
                                <tbody>
                                    @foreach($pajak as $key => $pjk)
                                    <tr>
                                        <td><input type="checkbox" name="pajak_id[]" value="{{ $pjk->id }}"></td>
                                        <td>{{ $pjk->jenis }}</td>
                                        <td>{{ $pjk->tanggal_bukti }}</td>
                                        <td>{{ $pjk->nomor_bukti }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabdukungan">
                            <table class="table table-responsive">
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>:</td>
                                    <td><input type="text" name="nama_bank" placeholder="Nama BANK"></td>
                                </tr>
                                <tr>
                                    <td>Nomor Surat</td>
                                    <td>:</td>
                                    <td><input type="text" name="nomor_surat" placeholder="Nomor Surat"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td><input type="date" name="tanggal" placeholder="Tanggal"></td>
                                </tr>
                                <tr>
                                    <td>Nilai</td>
                                    <td>:</td>
                                    <td><input type="number" name="nilai" placeholder="Nilai"></td>
                                </tr>
                                <tr>
                                    <td>Bukti Dukungan Bank</td>
                                    <td>:</td>
                                    <td><input type="file" name="file_bukti_dukungan_bank" placeholder="Nomor Surat"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabakta">
                            <input type="hidden" name="akta_id" value="{{ $akta->id }}">
                            <table class="table table-responsive">
                                <h3>Akta Pendirian</h3>
                                <tr>
                                    <td>Nomor</td>
                                    <td>:</td>
                                    <td>{{ $akta->pendirian_nomor }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Surat</td>
                                    <td>:</td>
                                    <td>{{ $akta->pendirian_tanggal }}</td>
                                </tr>
                                <tr>
                                    <td>Notaris</td>
                                    <td>:</td>
                                    <td>{{ $akta->pendirian_notaris }}</td>
                                </tr>
                                <td><h3>Akta Perubahan terakhir</h3></td>
                                <tr>
                                    <td>Nomor</td>
                                    <td>:</td>
                                    <td>{{ $akta->perubahan_nomor }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Surat</td>
                                    <td>:</td>
                                    <td>{{ $akta->perubahan_tanggal }}</td>
                                </tr>
                                <tr>
                                    <td>Notaris</td>
                                    <td>:</td>
                                    <td>{{ $akta->perubahan_notaris }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabta">
                            <table class="table datatable table-responsive">
                                <thead>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Pengalaman Kerja</th>
                                    <th>Keahlian</th>
                                    <th>Sertifikat</th>
                                    <th>Pendidikan</th>
                                </thead>
                                <tbody>
                                    @foreach( $tenagaahli as $row )
                                    <tr>
                                        <td><input type="checkbox" name="mt_tenaga_ahli_id[]" value="{{  $row->id }}"></td>
                                        <td>{{ $row->nama }}</td>
                                        <td>{{ $row->pengalaman }}</td>
                                        <td>{{ $row->keahlian }}</td>
                                        <td>{{ $row->sertifikat }}</td>
                                        <td>{{ $row->pendidikan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabpengalaman">
                            <table class="table datatable table-responsive">
                                <thead>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th>Instansi</th>
                                    <th>Alamat</th>
                                    <th>No Kontrak</th>
                                </thead>
                                <tbody>
                                    @foreach($pengalaman as $key => $p)
                                    <tr>
                                        <td><input type="checkbox" name="mt_pengalaman_id[]" value="{{ $p->id }}"></td>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->lokasi }}</td>
                                        <td>{{ $p->instansi }}</td>
                                        <td>{{ $p->alamat }}</td>
                                        <td>{{ $p->no_kontrak }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabpekerjaan">
                            <table class="table table-responsive">
                                <thead>
                                    <th>Pajak</th>
                                    <th>Tanggal</th>
                                    <th>No. Buti</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabperalatan">
                            <table class="table datatable table-responsive">
                                <thead>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Kapasitas</th>
                                    <th>Merk</th>
                                    <th>Kondisi</th>
                                </thead>
                                <tbody>
                                    @foreach($peralatans as $key => $pr)
                                    <tr>
                                        <td><input type="checkbox" name="mt_peralatan_id[]" value="{{ $pr->id }}"></td>
                                        <td>{{ $pr->nama }}</td>
                                        <td>{{ $pr->jumlah }}</td>
                                        <td>{{ $pr->kapasitas }}</td>
                                        <td>{{ $pr->merk }}</td>
                                        <td>{{ $pr->kondisi }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabsyaratlain">
                            <lable>Upload File</lable>
                            <input type="file" name="file_syarat_lain" class="form-control">
                        </div>
                    </div>
                </div>
           

                <div class="pull-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                        Kirim Data Kualifikasi
                    </button>
                </div>
             </div>
        </form>
    </div>
</div>
@stop
@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
@stop