<?php

namespace App\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Procurement\JenisPengadaans;

class Pakets extends Model
{
    public $incrementing    = false; 
    protected $table        = 'e_paket';
    protected $keyType      = 'string';

    //ini flag field status_paket
    public const PaketSend              = 1;
    public const PaketWaitingSend       = 0;
    public const PaketDiteruskan        = 5;
    public const PaketBelumSelesai      = 7;
    public const PaketSelesai           = 8;
    public const PaketApproveRekanan    = 2; 

    // ini flag field status_tahap_paket
    //tender 
    public const TenderTahapPengumuman = 1;
    public const TenderTahapPengambilanDokumenPengadaan = 2;
    public const TenderTahapPemberianPenjelasan = 3;
    public const TenderTahapPemasukanDokumenPenawaran = 4;
    public const TenderTahapPembukaanDokumenPenawaran = 5;
    public const TenderTahapEvaluasiDokumenPenawaran = 6;
    public const TenderTahapKlarifikasiDanNegoisasi = 7;
    public const TenderTahapPenetapanPemenang = 8;
    public const TenderTahapPembuatanBeritaAcara = 9;
    public const TenderTahapDebriefing = 10;
    public const TenderPenerbitanSppbj = 11;
    public const TenderTtdKontrak = 12;

    //nontender
    public const NonTenderTahapUploadDokPenawaran = 1;
    public const NonTenderTahapPembukaanDokPenawaran = 2;
    public const NonTenderTahapEvaluasiPenawaran = 3;
    public const NonTenderTahapKlarifikasiTeknis = 4;
    public const NonTenderTahapTtdKontrak = 5;
    //end flag

    //nontender pl
    // public const DirectKirimUndang


    public const picPokja = 10;
    public const picPejabat = 20;

    public const Approve = 1;
    public const Reject  = 3;
    public const Waiting = 0;
    public const PublishPaket = 1;
    public const TenderUlang  = 1;
    
    //status paket
    public const StatusPaketWaiting = 0; 
    public const StatusPaketPublish = 1; 
    public const StatusPaketPenetapanPemenang = 2; 
    public const StatusPaketTandaTanganKontrak = 3; 
    public const StatusPaketSudahDiTeruskan = 5; 
    public const StatusPaketDiTeruskankePPK = 7;

    //status tahapan
    public const TahapanPengumuman = 2;
    public const StatusTahapan = [
        2 => 'Pengumuman'
    ];

    public const StatusApproval = [
        1 => 'Setuju',
        3 => 'Tidak Setuju',
        0 => 'Menunggu Persetujuan'
    ];

    public const TypeStatusPaket = [
        0 => 'Belum ditunjuk Penanggung jawab',
        1 => 'Sudah ditunjuk Penanggung Jawab',
        2 => 'Pokja Lengkapi Paket'
    ];

    public static $rules = [
        'kode_rup' => 'required',
        'nama' => 'required',
    ];

    public static $errormessage = [
        'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

   protected $fillable = [
    'id', 'kode', 'nama', 'tanggal', 'pagu', 'nilai_hps', 'link_file_dok_pengadaan', 'link_file_syarat_pengadaan', 'link_file_lainnya', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'status_id', 'klpd_id', 'satuankerja_id', 'tahun_id', 'jenispengadaan_id', 'kualifikasi_id', 'pemenang_id', 'jeniskontrak_id', 'tipe_file_dok', 'ukuran_file_dok', 'tipe_file_syarat', 'ukuran_file_syarat', 'kode_rup','mtd_kualifikasi_id', 'link','setting_unduh_buka','setting_unduh_tutup', 'is_public',
    'is_pic','pokja_id','pejabat_id','status_paket','category_id','evaluasi_kriteria_id','is_metode_dokumen','is_dpt',
    'link_pembelian','is_tender_ulang'
  ];

    public function rJenisPengadaan()
    {
        return $this->belongsTo(JenisPengadaans::class, 'jenispengadaan_id');
        
    }

    public function getSatuanKerja()
    {
        return $this->belongsTo(\App\Models\Procurement\SatuanKerjas::class,'satuan_kerja_id');
    }

    public function getCategory()
    {
        return $this->belongsTo(\App\Models\Procurement\EPaketCategory::class, 'category_id');
    }

    public function getDokPenawaran()
    {
        return $this->hasMany(\App\Models\Procurement\PaketDokumenPenawarans::class,'id');
    }
}
