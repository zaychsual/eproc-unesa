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
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            Pembukaan
            @if($pembukaan == null)
            <p class="pull-right">
                <button class="btn btn-info" data-toggle="modal" data-target="#myModal" type="button">Ubah</button>
            </p>
            @endif
        </div>
        <div class="panel-body">
            <textarea class="form-control">{{ $pembukaan->pembukaan ?? "" }}</textarea>
        </div>
    </div>
</div>
@php
    $pertanyaan = \App\Models\Procurement\PemberianPenjelasanPertanyaan::where('paket_id', $paket['id'])
        ->where('is_jawaban','NO')
        ->get();
@endphp
@foreach($pertanyaan as $key => $value)
<div class="panel panel-info">
    <div class="panel-heading">
        {{ $value->dokumen }} - {{ $value->bab }} ( {{ $value->getRekanan['nama'] }} )
        <p class="pull-right">
            {{ $value->created_at }}
        </p>
    </div>
    <div class="panel-body">
        @php
            $pertanyaans = \App\Models\Procurement\PemberianPenjelasanPertanyaan::where('paket_id', $paket['id'])
                ->where('author', 'pokja')
                ->whereOr('to_rekanan_id', $value->mt_rekanan_id)
                ->orderBy('created_at','asc')
                ->get();
                //dd($pertanyaans);
        @endphp
        @foreach($pertanyaans as $key => $r)
            <div class="form-group">
                <label class="pull-right">
                    @if($r->is_jawaban == 'NO')
                    <span class="badge badge-primary">Rekanan</span>
                    @else 
                    <span class="badge badge-warning">Pokja</span>
                    @endif
                </label>
                <textarea class="form-control">{!! $r->uraian !!}</textarea>
            </div>

            <hr>
        @endforeach
        <button type="button" id="btns" class="btn btn-primary" data-rekanan="{{ $r->mt_rekanan_id }}"
        data-toggle="modal" data-target="#myModalChat"
    >Jawab</button>
    </div>
</div>
@endforeach