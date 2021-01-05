<table class="table table-hover" id="berita">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Peserta</th>
            <th>Harga Penawaran</th>
            <th>Harga Terkoreksi</th>
            <th>Harga Negosiasi</th>
            <th>Undangan Verifikasi</th>
            <th><span class="badge badge-primary">H</span></th>
            <th><span class="badge badge-warning">P</span></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody> 
        @foreach($rekananPenawaran as $key => $values)

        @php
            $getEvaluasiH = \App\Models\Procurement\EvaluasiPenilaian::where('paket_id', $values->paket_id)
                    ->where('mt_rekanan_id',$values->rekanan_id)
                    ->where('is_doc_type',\App\Models\Procurement\EvaluasiPenilaian::Harga)
                    ->first();
            $getPemenang = \App\Models\Procurement\PaketRekanan::getPemenang($values->paket_id, $values->rekanan_id);
        @endphp
        <tr>
            <td>{{ ($key + 1) }}</td>
            <td>
                <a class="" href="
                    {{ route('pembelian-barang-bekas.create-evaluasi',[
                        'paket_id' => $values->paket_id,
                        'rekanan_id' => $values->rekanan_id,
                    ]) }}">
                    {{ $values->nama ?? '' }}
                </a>
            </td>
            <td>@currency($values->total_harga_penawaran)</td>
            <td>@currency($values->harga_terkoreksi)</td>
            <td>@currency($values->harga_negoisasi)</td>
            <td>
            </td>
            <td>
                @if($getEvaluasiH != null)
                    @if($getEvaluasiH->is_lulus == \App\Models\Procurement\EvaluasiPenilaian::Lulus)
                        <i class="fa fa-check"></i>
                    @else 
                        <i class="fa fa-times"></i>
                    @endif
                @endif
            </td>
            <td>
                @if($getPemenang != null)
                    <i class="fa fa-check" style="color:blue;"></i>
                @else 
                    <i class="fa fa-times" style="color:blue;"></i>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="form-group">
    <span class="badge badge-primary">H</span>
    <p>Evaluasi Harga</p>
    <span class="badge badge-warning">P</span>
    <p>Pemenang</p>
</div>