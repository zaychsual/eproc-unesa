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
                        <td>{{ Form::text('nama', $paket['nama'], array('class' => 'form-control', 'id'=>'nama', '')) }}</td>
                    </tr>
                    <tr>
                        <td>Daftar Penyedia</td>
                        <td>:</td>
                        <td>
                            {{-- cek udah ada rekananny blom klo blm input lah atau pilih --}}
                            @if($rekanan == null)
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="is_dpt" value="88">Dari DPT
                                </label>
                              </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="is_dpt" value="77">Tidak Ada Di DPT
                                </label>
                            </div>
                            <a id="pilih" style="display:none" class="btn btn-success" href="{{ route('pembelian-langsung.create-rekanan', Crypt::encrypt($paket['id'])) }}">
                                <i class="fa fa-arrow-down"></i>
                                Pilih penyedia
                            </a>
                            <a id="input" style="display:none" class="btn btn-success" href="{{ route('pembelian-langsung.create-rekanan-input', Crypt::encrypt($paket['id'])) }}">
                                <i class="fa fa-arrow-down"></i>
                                Input penyedia
                            </a>
                            @endif
                            <br>
                            <br>
                            @if(null != $rekanan)
                            <table class="table table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Penyedia</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $rekanan->getMtRekanan['nama'] }}</td>
                                </tr>
                            </table>
                            @endif
                        </td>
                    </tr>
                    @if(null != $rekanan)
                        @if($rekanan->is_kirim_undangan != \App\Models\Procurement\PaketRekanan::SudahKirim)
                        <tr>
                            <td>Kirim Undangan</td>
                            <td>:</td>
                            <td>
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Kirim Undangan</button>
                            </td>
                        </tr>
                        @endif
                    @endif
                    <tr>
                        <td>Pembuatan BA Negoisasi</td>
                        <td>:</td>
                        <td>
                            <a href="{{ route('pembelian-langsung.create-ba-negoisasi', Crypt::encrypt($paket['id'])) }}" class="btn btn-warning">
                                Buat BA Negoisasi
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Surat Pesanan</td>
                        <td>:</td>
                        <td>
                            <a href="{{ route('pembelian-langsung.create-surat-pesanan', Crypt::encrypt($paket['id'])) }}" class="btn btn-info">
                                Buat Surat Pesanan
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Informasi</h4>
            </div>
            <form action="{{ route('pembelian-langsung.store-undangan') }}" method="post">
                @csrf
                <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                <input type="hidden" name="mt_rekanan_id" value="{{ $rekanan->mt_rekanan_id ?? ''}}">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Waktu Mulai</td>
                            <td>:</td>
                            <td>{{ Form::date('undangan_waktu_mulai', old('undangan_waktu_mulai')), array('class' => 'form-control', 'required') }}</td>
                        </tr>
                        <tr>
                            <td>Waktu Selesai</td>
                            <td>:</td>
                            <td>{{ Form::date('undangan_waktu_selesai', old('undangan_waktu_selesai')), array('class' => 'form-control', 'required') }}</td>
                        </tr>
                        <tr>
                            <td>Tempat</td>
                            <td>:</td>
                            <td><input type="text" class="form-control" name="undangan_tempat"></td>
                        </tr>
                        <tr>
                            <td>Yang Harus dibawa</td>
                            <td>:</td>
                            <td><input type="text" class="form-control" name="undangan_yg_dibawa"></td>
                        </tr>
                        <tr>
                            <td>Yang Harus Hadir</td>
                            <td>:</td>
                            <td><input type="text" class="form-control" name="undangan_yg_harus_hadir"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- page end-->