<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEPaketKontrakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_kontrak', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->string('kontrak_no')->nullable();
            $table->date('kontrak_tanggal')->nullable();
            $table->string('kontrak_kota')->nullable();
            $table->string('kontrak_unit_kerja')->nullable();
            $table->string('kontrak_alamat_satker')->nullable();
            $table->string('kontrak_jabatan_satker')->nullable();
            $table->string('kontrak_no_sk_ppk')->nullable();
            $table->string('kontrak_wakil_sah_penyedia')->nullable();
            $table->string('kontrak_jabatan_wakil_penyedia')->nullable();
            $table->string('kontrak_nama_bank')->nullable();
            $table->string('kontrak_no_rekening_bank')->nullable();
            $table->string('kontrak_nilai_kotrak')->nullable();
            $table->string('kontrak_informasi_lainnya')->nullable();
            $table->string('kontrak_dokumen')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_kontrak_sppbj', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('kotrak_id')->nullable();
            $table->uuid('ppk_id')->nullable();
            $table->string('sppbj_no')->nullable();
            $table->string('sppbj_lampiran')->nullable();
            $table->string('sppbj_kota')->nullable();
            $table->date('sppbj_tanggal')->nullable();
            $table->bigInteger('sppbj_harga_final')->nullable();
            $table->bigInteger('sppbj_nilai_jaminan')->nullable();
            $table->string('sppbj_tembusan')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_kontrak_undangan', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('kotrak_id')->nullable();
            $table->dateTime('undangan_waktu_mulai')->nullable();
            $table->dateTime('undangan_waktu_selesai')->nullable();
            $table->string('undangan_tempat')->nullable();
            $table->string('undangan_yg_dibawa')->nullable();
            $table->string('undangan_yg_harus_hadir')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_kontrak_spk', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('kotrak_id')->nullable();
            $table->string('spk_no')->nullable();
            $table->string('spk_kota')->nullable();
            $table->date('spk_tanggal')->nullable();
            $table->string('spk_wakil_sah_penyedia')->nullable();
            $table->string('spk_jabatan_wakil_penyedia')->nullable();
            $table->string('spk_nilai_kotrak')->nullable();
            $table->date('spk_tanggal_mulai_kerja')->nullable();
            $table->string('spk_wkt_penyelesaian')->nullable();
            $table->string('spk_file')->nullable();

            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_kontrak_spp', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('kotrak_id')->nullable();
            $table->string('spp_no')->nullable();
            $table->date('spp_tanggal')->nullable();
            $table->string('spp_wakil_sah_penyedia')->nullable();
            $table->string('spp_jabatan_wakil_penyedia')->nullable();
            $table->date('spp_tgl_brg_diterima')->nullable();
            $table->string('spp_waktu_penyelesaian')->nullable();
            $table->date('spp_tgl_pekerjaan_selesai')->nullable();
            $table->string('spp_alamat_pengiriman')->nullable();
            $table->string('spp_file')->nullable();
            $table->string('spp_kota')->nullable();
            $table->string('spp_jaminan_cacat')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();

        });

        Schema::create('e_kontrak_spmk', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('kotrak_id')->nullable();
            $table->string('spmk_no')->nullable();
            $table->date('spmk_tanggal')->nullable();
            $table->string('spmk_wakil_sah_penyedia')->nullable();
            $table->date('spmk_tanggal_barang_diterima')->nullable();
            $table->string('spmk_tgl_mulai_kerja')->nullable();
            $table->string('spmk_wkt_penyelesaian')->nullable();
            $table->string('spmk_tgl_pekerjaan_selesai')->nullable();
            $table->string('spmk_alamat_pengiriman')->nullable();
            $table->string('spmk_kota')->nullable();
            $table->string('spmk_lingkup_kerja')->nullable();
            $table->string('spmk_file')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_termin_rekanan', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('kotrak_id')->nullable();
            $table->string('bast_no')->nullable();
            $table->date('bast_tanggal')->nullable();
            $table->string('bast_file')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_dokumen_lainnya', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('kotrak_id')->nullable();
            $table->string('nama_dokumen')->nullable();
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->string('keterangan_dokumen')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_bap', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('kotrak_id')->nullable();
            $table->string('bap_no')->nullable();
            $table->string('bap_tanggal')->nullable();
            $table->string('bap_besar_pembayaran')->nullable();
            $table->string('bap_progress_fisik')->nullable();
            $table->string('bap_file_upload')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_paket_kontrak');
    }
}
