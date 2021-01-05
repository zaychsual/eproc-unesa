@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Tambah {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')

<!-- page start-->
<div class="row">
	<div class="col-md-12">
		{!! Form::open(array('url' => route('e-kontrak.store-sppbj'), 'method' => 'POST', 'id' => 'tahaps', 'class' => 'form-horizontal')) !!}
		{!! csrf_field() !!}
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">
        <input type="hidden" name="ppk_id" value="{{ $ppk->id }}">
        <div class="panel panel-default">
            <div class="panel-heading">
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
            </div>
            <div class="panel-body">
               <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">NO SPPBJ </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            {{ Form::text('sppbj_no', old('sppbj_no',isset($eSppbj->sppbj_no)), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Lampiran SPPBJ </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-file"></span></span>
                            {{ Form::text('sppbj_lampiran', old('sppbj_lampiran',isset($eSppbj->sppbj_lampiran)), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Kota SPPBJ </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-building"></span></span>
                            {{ Form::text('sppbj_kota', old('sppbj_kota',isset($eSppbj->sppbj_kota)), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Tanggal SPPBJ </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{ Form::date('sppbj_tanggal', old('sppbj_tanggal',isset($eSppbj->sppbj_tanggal)), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                    </div>
                    <div class="form-group col-md-6 col-xs-12">
                        Penyedia
                        <br>
                        <table class="table table-bordered">
                            <tr>
                                <th></th>
                                <th>Pemenang</th>
                                <th>Email</th>
                                <th>Harga</th>
                                <th>Undangan Kontrak</th>
                            </tr>
                            @foreach($rekanan as $rows)
                            <tr>
                                @if($rows->is_winner == \App\Models\Procurement\PaketRekanan::Pemenang)
                                    <input type="hidden" name="mt_rekanan_id" value="{{ $rows->rekanan_id }}">
                                @endif
                                <td>
                                    <input type="radio" name="pemenang_id" value="" @if($rows->is_winner == \App\Models\Procurement\PaketRekanan::Pemenang) checked @endif>
                                </td>
                                <td>{{ $rows->nama }}</td>
                                <td>{{ $rows->email }}</td>
                                <td>{{ $rows->harga_penawaran }}</td>
                                <td>
                                    @if(\App\Models\Procurement\EkontrakSppbj::where('paket_id', $paket->id)->first() != null)
                                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Kirim Undangan</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Harga Final </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-money"></span></span>
                            {{ Form::text('sppbj_harga_final', old('sppbj_harga_final',isset($eSppbj->sppbj_harga_final)), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Satuan Kerja </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            {{-- {{ Form::text('evaluasi', old('evaluasi',isset($satuanKerja->satuankerja)), array('class' => 'form-control', 'required')) }} --}}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Nama PPK </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::text('ppk_name', old('ppk_name',isset($ppk->name)), array('class' => 'form-control', 'required')) }}
                        </div>  
                    </div>
                </div>
                <div class="form-group @if ($errors->has('evaluasi')) has-error @endif">
                    <label class="col-md-3 col-xs-12 control-label">Tembusan </label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {{ Form::text('sppbj_tembusan', old('sppbj_tembusan')), array('class' => 'form-control', 'required') }}
                        </div>  
                    </div>
                </div>
            </div>
            <div class="panel-footer">     
                <a href="{{ URL::to('/home') }}" class="btn btn-default pull-left">Batal</a>                               
                <button class="btn btn-success"><i class="fa fa-save"></i>Submit</button>
            </div>
        </div>
        {!! Form::close() !!}

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
            <form action="{{ route('store-undangan-kontrak') }}" method="post">
                @csrf
                <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                <input type="hidden" name="mt_rekanan_id" value="{{ $rekananWin->id }}">
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
@stop

@section('script')
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('ress/js/plugins/summernote/summernote.js') !!}


{{Html::script('js/jquery.mask.min.js')}}
<script>
	$('#saham').mask('#.##0', {reverse: true});
</script>
<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.satuan').select2();
        $('.status_kepegawaian').select2();
    });
</script>
@stop
