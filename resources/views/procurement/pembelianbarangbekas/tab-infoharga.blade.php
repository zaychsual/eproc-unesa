<table class="table table-hover" id="berita">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Penyedia Barang/Jasa</th>
            <th>Total Penawaran</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($penawaran as $key => $rows)
        <tr>
            <td>{{ ($key + 1) }}</td>
            <td>{{ $rows->getRekanan['nama'] }}</td>
            <td>@currency($rows->total_harga_penawaran) </td>
            @if($rows->is_negoisasi == \App\Models\Procurement\RekananSubmitPenawaran::BelumDiNego)
            <td>
            <a class="btn btn-danger" href="{{ route('pembelian-barang-bekas.create-negoisasi', [
                    'paket_id' => Crypt::encrypt($rows->paket_id),
                    'rekanan_id' => $rows->mt_rekanan_id]) 
                    }}
                ">
                    Negoisasi
                </a>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>