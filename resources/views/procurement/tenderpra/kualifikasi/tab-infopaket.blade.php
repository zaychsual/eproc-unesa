<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Detail</strong> Paket</h3>
        </div>
        <div class="panel-body">
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
                        <td>
                            {{$paket['nama']}} &nbsp;&nbsp;&nbsp;
                            @if($paket->is_tender_ulang == \App\Models\Procurement\Pakets::TenderUlang)
                            <button class="btn btn-warning btn-sm btn-rounded">
                                Tender Ulang
                            </button>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Status Tahapan</td>
                        <td>:</td>
                        <td> 
                            @php
                                $getTahapan = \App\Models\Procurement\PaketTahapans::getTahapans($paket['id']);
                            @endphp
                            {{ $getTahapan->nama ?? "" }}
                        </td>
                    </tr>
                    <tr>
                        <td>Metode Pengadaan</td>
                        <td>:</td>
                        <td>
                            <a class="btn btn-primary btn-rounded" href="{{ route('tender.edit-pengadaan',Crypt::encrypt($paket->id)) }}">
                                {{ $paket->rJenisPengadaan['jenispengadaan'] }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Jadwal Tender</td>
                        <td>:</td>
                        <td>
                            @if(empty($jadwal))
                            <a class="btn btn-default" href="{{ route('tender.create-jadwal',Crypt::encrypt($paket->id)) }}">
                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;
                                Jadwal belum diisi
                            </a>
                            @else 
                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;Semua jadwal sudah tersimpan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Daftar Penyedia</td>
                        <td>:</td>
                        <td>
                            @if(empty($rekanan))
                            <a class="btn btn-success" href="{{ route('tender.pra-pilih-rekanan', Crypt::encrypt($paket['id'])) }}">
                                <i class="fa fa-arrow-down"></i>
                                Pilih penyedia
                            </a>
                            @endif
                            <br>
                            <br>
                            @if(!empty($rekanan))
                            <table class="table table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Penyedia</th>
                                    <th>Lulus Kualifikasi</th>
                                </tr>
                                @foreach($rekanan as $i => $rows)
                                <tr>
                                    <td>{{ ($i + 1) }}</td>
                                    <td>{{ $rows->getMtRekanan['nama'] }}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </table>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Dokumen Pemilihan &nbsp;
                        </td>
                        <td>:</td>
                        <td style="background-color:#1caf9a;color:white;">
                            <tr>
                                <td></td>
                                <td>:</td>
                                <td>
                                    <a class="" href="{{ route('tender.pra-create-kualifikasi', Crypt::encrypt($paket['id'])) }}">
                                        Persyaratan Kualifikasi
                                    </a>
                                </td>
                                <td>
                                    @if(null == $lembarKualifikasi)
                                    <i class="fa fa-times"></i>
                                    @else 
                                    <i class="fa fa-check"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>:</td>
                                <td>
                                    <a class="" href="{{ asset('uploads/file/'.$getFileKak->files) }}" target="_blank">
                                        Kerangka acuan kerja (KAK) Spesifikasi teknis dan gambar
                                    </a>
                                </td>
                                <td>
                                    @if(null == $getFileKak)
                                    <i class="fa fa-times"></i>
                                    @else 
                                    <i class="fa fa-check"></i>
                                    @endif
                                </td>
                            </tr>
                        </td>
                    </tr>

                    @if($paket->is_pic == \App\Models\Procurement\Pakets::picPokja)
                    <tr>
                        <td>Status Persetujuan</td>
                        <td>:</td>
                        <td>
                            <table class="table table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>Pokja</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Alasan Tidak Setuju</th>
                                </tr>
                                @foreach($getApproval as $key => $value)
                                <tr>
                                    <td>{{ ($key + 1) }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>
                                        @if(\App\Models\Procurement\Pakets::Approve == $value->status)
                                        <i class="fa fa-check"></i>
                                        @elseif(\App\Models\Procurement\Pakets::Waiting == $value->status)
                                        -
                                        @else
                                        <i class="fa fa-times"></i>
                                        @endif
                                    </td>
                                    {{-- <td>{{ \App\Models\Procurement\Pakets::StatusApproval[$value->status] }}</td> --}}
                                    <td>{{ $value->approval_date }}</td>
                                    <td>{{ $value->reason }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    @else

                    <div class="from-group">
                        <buton type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Publish
                        </buton>
                    </div>
                    @endif
                </table>
                @php
                $WaitingApprovePokja = 0;
                $check = \checkApprovePokja(Auth::user()->id, $paket->id);
                @endphp

                @if(!empty($check))
                    @if( $check->status == $WaitingApprovePokja)
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Persetujuan
                        </div>
                        <div class="panel-body">
                            <form>
                                <center>PAKTA INTEGRITAS</center>
                                <p>
                                    Saya menyetujui bahwa: <br>
                                    1. Tidak akan melakukan korupsi, kolusi,dan nepotisme <br>
                                    2. akan melaporkan kepada PA/KPA jika mengetahui  terjadinya praktik korupsi
                                </p>
                                <p><b>Alasan tidak setuju</b></p>
                                <p>
                                    <textarea name="reason" id="reason" rows=10 cols=120></textarea>
                                </p>
                                <p>
                                    {{-- <input type="text" name="paket_ids" value="{{ $paket->id }}"> --}}
                                    <button type="submit" class="btn btn-success" id="setuju" data-paket_id="{{ $paket->id }}"><i class="fa fa-check"></i> Setuju</button>
                                    <button type="submit" class="btn btn-danger" id="tidaksetuju" data-pakets_id="{{ $paket->id }}"><i class="fa fa-times"></i> Tidak Setuju</button>
                                </p>
                            </form>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>