<div id="myModals" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form class="form-inline" action="{{ route('store-masa-berlaku') }}" method="post">
            <input type="hidden" name="paket_id" value="{{ $paket->id }}" id="paket_id">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Isi masa berlaku penawaran</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="sr-only" for="exampleInputAmount"></label>
                        <div class="input-group">
                            <div class="input-group-addon">Masa berlaku penawaran</div>
                            <input type="text" name="masa_berlaku" id="masa_berlaku" class="form-control" id="exampleInputAmount" placeholder="">
                            <div class="input-group-addon">
                                hari sejak batas akhir pemasukan dokumen penawaran
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form action="{{ route('penunjukan-langsung.store-pembukaan') }}" method="post">
            <input type="hidden" name="paket_id" value="{{ $paket->id }}" id="paket_id">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pembukaan</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <textarea class="form-control" name="pembukaan"></textarea>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="myModalChat" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form action="{{ route('penunjukan-langsung.store-jawaban') }}" method="post">
            <input type="hidden" name="paket_id" value="{{ $paket->id }}" id="paket_id">
            <input type="hidden" name="rekanan_id" value="" id="rekanan_ids">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Jawaban</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <textarea class="form-control" name="uraian"></textarea>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>