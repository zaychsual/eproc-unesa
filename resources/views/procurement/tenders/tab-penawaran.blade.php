<table class="table table-hover" id="berita">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Penyedia Barang/Jasa</th>
            <th>Tanggal Mendaftar</th>
            <th>Dokumen Kualifikasi</th>
            <th colspan="8" style="text-align:center;">Dokumen Penawaran</th>
        </tr>
        <tr>
            <th colspan="4"></th>
            <th colspan="">Surat Penawaran</th>
            <th colspan="">Administrasi dan Teknis</th>
            <th colspan="">Harga</th>
            <th colspan="">Masa Berlaku</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penawaran as $key => $rows)
        @php
            $rekananHarga = \App\Models\Procurement\RekananSubmitHargaPenawaran::where('paket_id', $rows->paket_id)
                ->where('mt_rekanan_id',$rows->mt_rekanan_id)
                ->first();
        @endphp
        <tr>
            <td>{{ ($key + 1) }}</td>
            <td>{{ $rows->getRekanan['nama'] }}</td>
            <td>{{ $rows->getRekanan['created_at'] }}</td>
            <td><a class="btn btn-primary" href="{{ route('detail-kualifikasi',['paket_id' => $rows->paket_id,'rekanan_id' => $rows->mt_rekanan_id]) }}" target="_blank">Kualifikasi</a></td>
            <td><a class="btn btn-primary" href="{{ route('detail-surat-penawaran',['paket_id' => $rows->paket_id,'rekanan_id' => $rows->mt_rekanan_id]) }}" target="_blank">Cetak</a></td>
            <td><a class="btn btn-primary" href="" onclick="basicPopup(this.href);return false">Cetak</a></td>
            <td><a class="btn btn-primary" href="{{ route('detail-penawaran-harga',['paket_id' => $rows->paket_id,'rekanan_id' => $rows->mt_rekanan_id]) }}" onclick="basicPopup(this.href);return false">Cetak</a></td>
            <td>{{ $rows->masa_berlaku. " Hari" }}</td>
        </tr>
        @endforeach
    </tbody>
</table>