@if(!empty($getTahapan))
    @if($getTahapan->nama == 'Penetapan Pemenang')
    <a class="btn btn-success pull-right" href="
        {{ 
            route('tender.create-pemenang',[
                'paket_id' => $paket->id,
            ]) 
        }}
    ">
    Penetapan Pemenang
    </a>
    <a class="btn btn-danger pull-right" href="
        {{ 
            route('tender.create-negoisasi',[
                'paket_id' => $paket->id,
            ]) 
        }}
    ">
    Input Negosiasi
    </a>
    <br><br><br>
    @endif
@endif
<table class="table table-hover" id="berita">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Peserta</th>
            <th>Harga Penawaran</th>
            <th>Harga Terkoreksi</th>
            <th>Harga Negosiasi</th>
            <th>Undangan Verifikasi</th>
            <th><span class="badge badge-success">A</span></th>
            <th><span class="badge badge-default">K</span></th>
            <th><span class="badge badge-info">T</span></th>
            <th><span class="badge badge-primary">H</span></th>
            <th><span class="badge badge-danger">B</span></th>
            <th><span class="badge badge-warning">P</span></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody> 
        @foreach($rekananPenawaran as $key => $values)

        @php
            $getEvaluasiA = \App\Models\Procurement\EvaluasiPenilaian::where('paket_id', $values->paket_id)
                    ->where('mt_rekanan_id',$values->rekanan_id)
                    ->where('is_doc_type',\App\Models\Procurement\EvaluasiPenilaian::Administrasi)
                    ->first();

            $getEvaluasiT = \App\Models\Procurement\EvaluasiPenilaian::where('paket_id', $values->paket_id)
                    ->where('mt_rekanan_id',$values->rekanan_id)
                    ->where('is_doc_type',\App\Models\Procurement\EvaluasiPenilaian::Teknis)
                    ->first();

            $getEvaluasiH = \App\Models\Procurement\EvaluasiPenilaian::where('paket_id', $values->paket_id)
                    ->where('mt_rekanan_id',$values->rekanan_id)
                    ->where('is_doc_type',\App\Models\Procurement\EvaluasiPenilaian::Harga)
                    ->first();
            $getEvaluasiK = \App\Models\Procurement\EvaluasiPenilaian::where('paket_id', $values->paket_id)
                    ->where('mt_rekanan_id',$values->rekanan_id)
                    ->where('is_doc_type',\App\Models\Procurement\EvaluasiPenilaian::Kualifikasi)
                    ->first();
            $getPemenang = \App\Models\Procurement\PaketRekanan::getPemenang($values->paket_id, $values->rekanan_id);
        @endphp
        <tr>
            <td>{{ ($key + 1) }}</td>
            <td>
                <a class="" href="
                    {{ route('tender.evaluasi',[
                        'paket_id' => $values->paket_id,
                        'rekanan_id' => $values->rekanan_id,
                    ]) }}">
                    {{ $values->nama }}
                </a>
            </td>
            <td>@currency($values->total_harga_penawaran)</td>
            <td>@currency($values->harga_terkoreksi)</td>
            <td>@currency($values->harga_negoisasi)</td>
            <td>
            </td>
            <td>
                @if(!empty($getEvaluasiA))
                    @if($getEvaluasiA->is_lulus == \App\Models\Procurement\EvaluasiPenilaian::Lulus)
                        <i class="fa fa-check"></i>
                    @else 
                        <i class="fa fa-times"></i>
                    @endif
                @endif
            </td>
            <td>
                @if(!empty($getEvaluasiK))
                    @if($getEvaluasiK->is_lulus == \App\Models\Procurement\EvaluasiPenilaian::Lulus)
                        <i class="fa fa-check"></i>
                    @else 
                        <i class="fa fa-times"></i>
                    @endif
                @endif
            </td>
            <td>
                @if(!empty($getEvaluasiT))
                    @if($getEvaluasiT->is_lulus == \App\Models\Procurement\EvaluasiPenilaian::Lulus)
                        <i class="fa fa-check"></i>
                    @else 
                        <i class="fa fa-times"></i>
                    @endif
                @endif
            </td>
            <td>
                @if(!empty($getEvaluasiH))
                    @if($getEvaluasiH->is_lulus == \App\Models\Procurement\EvaluasiPenilaian::Lulus)
                        <i class="fa fa-check"></i>
                    @else 
                        <i class="fa fa-times"></i>
                    @endif
                @endif
            </td>
            <td></td>
            <td>
                @if($getPemenang != null)
                    <i class="fa fa-check" style="color:blue;"></i>
                @else 
                    <i class="fa fa-times" style="color:blue;"></i>
                @endif
            </td>
            <td>
                {{-- <a class="btn btn-warning" href="
                    {{ 
                        route('verifikasi.proses',[
                            'paket_id' => $values->paket_id,
                            'rekanan_id' => $values->rekanan_id
                        ]) 
                    }}
                ">
                Verifikasi --}}
            </td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="form-group">
    <span class="badge badge-success">A</span>
    <p>Evaluasi Administrasi</p>
    <span class="badge badge-default">K</span>
    <p>Evaluasi Kualifikasi</p>
    <span class="badge badge-info">T</span>
    <p>Evaluasi Teknis</p>
    <span class="badge badge-primary">H</span>
    <p>Evaluasi Harga</p>
    <span class="badge badge-danger">B</span>
    <p>Pembuktian Kualifikasi</p>
    <span class="badge badge-warning">P</span>
    <p>Pemenang</p>
</div>