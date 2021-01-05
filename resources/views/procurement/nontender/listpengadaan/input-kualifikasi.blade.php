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
	    <div class="panel panel-default">
	        <div class="panel-heading">
                <p>
                    <b>Petunjuk <br>
                    1. Pilih syarat kualifikasi dengan memberikan ceklis pada setiap yang didefinisikan <br>
                    </b>
                </p>
	        </div>
	        <div class="panel-body">
                <form action="{{ route('store-kualifikasi') }}" method="POST">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{ $paket['id'] }}">
                    <div class="row">
                        <table class="table table-bordered">
                            <tr>
                                <td>Kode REGINA/RUP</td>
                                <td>:</td>
                                <td>{{ Form::number('kode_rup', $paket['kode_rup'], array('class' => 'form-control', '')) }}</td>
                            </tr>
                            <tr>
                                <td>Nama Paket</td>
                                <td>:</td>
                                <td>{{ Form::text('nama', $paket['nama'], array('class' => 'form-control', 'id'=>'nama', '')) }}</td>
                            </tr>
                        </table>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Jenis Izin</th>
                                <th>Klasifikasi</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="izin_usaha">
                                <tr data-id="0">
                                    <td><input type="text" name="jenis_izin[]" id="jenis_izin_0" class="form-control"></td>
                                    <td><input type="text" name="klasifikasi[]" id="klasifikasi_0" class="form-control"></td>
                                    <td>
                                        <button type="button" class="btn btn-default" id="add_izin_usaha">
                                        <i class="fa fa-plus"></i>Tambah Izin Usaha
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <tr>
                                <td>
                                    <input type="checkbox" name="memiliki_npwp" value="1">
                                </td>
                                <td>
                                    &nbsp; Memiliki NPWP
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="melunasi_pajak_akhir_tahun" value="1">
                                </td>
                                <td>
                                    &nbsp; Telah melunasi kewajiban pajak tahun terakhir
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    &nbsp;&nbsp; <textarea class="form-control" name="pajak_tahun_terakhir"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="dalam_pengawasan" value="1">
                                </td>
                                <td>
                                    &nbsp; Yang bersangkutan dana menajemennya tidak dalam pengawasan pengadilan, tidak pailit, dan kegiatan usahanya tidak sedang dihentikan
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="daftar_hitam" value="1">
                                </td>
                                <td>
                                    &nbsp; Tidak masuk dalam daftar hitam
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="pengalaman_kerja" value="1">
                                </td>
                                <td>
                                    &nbsp; Pengalaman pekerjaan
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    &nbsp;&nbsp; <textarea class="form-control" name="pengalaman_kerja_detail"></textarea>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <div class="row">
                            <p>
                                <input type="checkbox" name="tenaga_ahli" value="1">
                                Tenaga Ahli
                            </p>
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Jenis Keahlian</th>
                                    <th>Keahlian/Spesifikasi</th>
                                    <th>Pengalaman</th>
                                    <th>Kemampuan Material</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="tenaga_ahli">
                                    <tr data-id="0">
                                        <td><input type="text" name="jenis_keahlian[]" id="jenis_keahlian_0" class="form-control"></td>
                                        <td><input type="text" name="keahlian[]" id="keahlian_0" class="form-control"></td>
                                        <td><input type="text" name="pengalaman[]" id="pengalaman_0" class="form-control"></td>
                                        <td><input type="text" name="kemampuan_manajerial[]" id="kemampuan_manajerial_0" class="form-control"></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" id="add_tenaga_ahli">
                                            <i class="fa fa-plus"></i>Tambah
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <p>
                                <input type="checkbox" name="tenaga_teknis" value="1">
                                Tenaga Teknis
                            </p>
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Jenis Kemampuan</th>
                                    <th>Kemampuan Teknis</th>
                                    <th>Pengalaman</th>
                                    <th>Kemampuan Material</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="tenaga_teknis">
                                    <tr data-id="0">
                                        <td><input type="text" name="jenis_kemampuan[]" id="jenis_kemampuan_0" class="form-control"></td>
                                        <td><input type="text" name="kemampuan_teknis[]" id="kemampuan_teknis_0" class="form-control"></td>
                                        <td><input type="text" name="pengalaman[]" id="pengalaman_0" class="form-control"></td>
                                        <td><input type="text" name="kemampuan_manajerial[]" id="kemampuan_manajerial_0" class="form-control"></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" id="add_tenaga_teknis">
                                            <i class="fa fa-plus"></i>Tambah
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <p>
                                <input type="checkbox" name="kemampuan" value="1">
                                Kemampuan Untuk Menyediakan Fasilitas atau Peralatan atau perlengkapan
                            </p>
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Spesifikasi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="kemampuan_fasilitas">
                                    <tr data-id="0">
                                        <td><input type="text" name="nama[]" id="nama_0" class="form-control"></td>
                                        <td><input type="text" name="spesifikasi[]" id="spesifikasi_0" class="form-control"></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" id="add_kemampuan_fasilitas">
                                            <i class="fa fa-plus"></i>Tambah
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                        {{-- <p>
                            <input type="checkbox" name="">
                        </p> --}}
                        <textarea class="form-control" name="syarat[]" id="syarat_0"></textarea>
                        <div id="syarat_lain"></div>
                        <i style="color:red">*Pastikan syarat tambahan sudah di ceklist sebelum menyimpan</i>
                        <br>
                            <button type="button" class="btn btn-warning pull-right" id="add_syarat">
                                <i class="fa fa-plus"></i>Tambah Syarat
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i>Simpan
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
    //def
    let indexUsaha = 1
    let indexTa    = 1
    let indexTk    = 1
    let indexFasilitas = 1
    let indexSyarat = 1

    $(document).ready(function() {

        // === draw izin usaha == //
        $("#add_izin_usaha").click(function() {
            let htmlUsaha = `
                <tr data-id="${indexUsaha}">
                    <td><input type="text" name="jenis_izin[]" id="jenis_izin_${indexUsaha}" class="form-control"></td>
                    <td><input type="text" name="klasifikasi[]" id="klasifikasi_${indexUsaha}" class="form-control"></td>
                    <td>
                        <a href="javascript:;" class="remove-item btn btn-danger btn-sm" onclick="this.parentNode.parentNode.remove()">
                            <i class="fa fa-times"></i> Hapus
                        </a>
                    </td>
                </tr>
            `
            $("#izin_usaha").append(htmlUsaha)

            indexUsaha++
        })
        // end

        // === draw tenaga ahli == //
        $("#add_tenaga_ahli").click(function(e) {
            e.preventDefault()
            let htmlTa = `
                <tr data-id="${indexTa}">
                    <td><input type="text" name="jenis_keahlian[]" id="jenis_keahlian_${indexTa}" class="form-control"></td>
                    <td><input type="text" name="keahlian[]" id="keahlian_${indexTa}" class="form-control"></td>
                    <td><input type="text" name="pengalaman[]" id="pengalaman_${indexTa}" class="form-control"></td>
                    <td><input type="text" name="kemampuan_manajerial[]" id="kemampuan_manajerial_${indexTa}" class="form-control"></td>
                    <td>
                        <a href="javascript:;" class="remove-item btn btn-danger btn-sm" onclick="this.parentNode.parentNode.remove()">
                            <i class="fa fa-times"></i> Hapus
                        </a>
                    </td>
                </tr>
            `
            $("#tenaga_ahli").append(htmlTa)

            indexTa++
        })

        // === draw tenaga teknis == //
        $("#add_tenaga_teknis").click(function(e) {
            e.preventDefault()
            let htmlTk = `
                <tr data-id="${indexTk}">
                    <td><input type="text" name="jenis_kemampuan[]" id="jenis_kemampuan_${indexTk}" class="form-control"></td>
                    <td><input type="text" name="kemampuan_teknis[]" id="kemampuan_teknis_${indexTk}" class="form-control"></td>
                    <td><input type="text" name="pengalaman[]" id="pengalaman_${indexTk}" class="form-control"></td>
                    <td><input type="text" name="kemampuan_manajerial[]" id="kemampuan_manajerial_${indexTk}" class="form-control"></td>
                    <td>
                        <a href="javascript:;" class="remove-item btn btn-danger btn-sm" onclick="this.parentNode.parentNode.remove()">
                            <i class="fa fa-times"></i> Hapus
                        </a>
                    </td>
                </tr>
            `
            $("#tenaga_teknis").append(htmlTk)
            indexTk++
        })

         // === draw tenaga teknis == //
        $("#add_kemampuan_fasilitas").click(function(e) {
            e.preventDefault()
            let htmlFasilitas = `
                <tr data-id="${indexFasilitas}">
                    <td><input type="text" name="nama[]" id="nama_${indexFasilitas}" class="form-control"></td>
                    <td><input type="text" name="spesifikasi[]" id="spesifikasi_${indexFasilitas}" class="form-control"></td>
                    <td>
                        <a href="javascript:;" class="remove-item btn btn-danger btn-sm" onclick="this.parentNode.parentNode.remove()">
                            <i class="fa fa-times"></i> Hapus
                        </a>
                    </td>
                </tr>
            `

            $("#kemampuan_fasilitas").append(htmlFasilitas)

            indexFasilitas++
        })

        $("#add_syarat").click(function(e) {
            e.preventDefault()

            let htmlSyarat = `
                <textarea class="form-control" name="syarat[]" id="syarat_${indexSyarat}"></textarea>
            `
            $("#syarat_lain").append(htmlSyarat)

            indexSyarat++
        })
        
    })
</script>
@endsection