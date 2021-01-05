@extends('layouts.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Usulan</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
      	<!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{!! $title !!}</h3>
                <a class="btn btn-info" href="{{URL::to('usulans/create')}}" style="margin: 0cm 0px 0cm 10px;">Tambah</a>
                {{-- {!! Form::open(array('url' => route('usulans.index'), 'method' => 'GET', 'id' => 'usulan', 'style'=>'padding-top: 20px')) !!}
            			{{ Form::select('status', ['1'=>'Disetujui', '0'=>'Belum disetujui'], Session::get('ss_statusv'), array(
            			'id'=>'status',
            			'class'=>'form-control',
                  'style'=>'width: 30%;',
            			'placeholder'=>'- Pilih Filter -',
            			"onChange"=>"this.form.submit();")) }}
            		{!! Form::close() !!} --}}
                <ul class="panel-controls">
                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <table class="table datatable table-hover" id="berita">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">Nama</th>
                            <th align="center">NIM/NIP</th>
                            <th align="center">Judul</th>
                            <th align="center">Pengarang</th>
                            <th align="center">Penerbit</th>
                            <th align="center">Status</th>
                            <th align="center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; ?>
                    @foreach($usulans as $value)
                        <tr style="cursor:pointer">
                            <td align="center"><?php echo $no; ?></td>
                            <td>{!! $value->nama !!}</td>
                            <td>{!! $value->nim !!}</td>
                            <td>{!! $value->judul !!}</td>
                            <td>{!! $value->pengarang !!}</td>
                            <td>{!! $value->penerbit !!}</td>
                            <td style="text-align:center;">
                              @if($value->status == 0)
                                <i class="fa fa-times" style="color: red;"></i>
                              @endif
                              @if($value->status == 1)
                                <i class="fa fa-check" style="color: green;"></i>
                              @endif
                            </td>
                            <td style="text-align:center;">
                              @if($value->status == 0)
                                <button class="btn btn-success btn-xs" id="btn_aktif" data-file="{{$value->id}}"><i class="fa fa-check"></i></button>
                                {{ Form::open(['url'=>route('usulans_aktif', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'get', 'id' => 'aktif_'.$value->id, 'style' => 'display: none;']) }}
                                {{ csrf_field() }}
                                {{ Form::close() }}
                              @endif
                              @if($value->status == 1)
                                <button class="btn btn-danger btn-xs" id="btn_naktif" data-file="{{$value->id}}"><i class="fa fa-times"></i></button>
                                {{ Form::open(['url'=>route('usulans_naktif', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'get', 'id' => 'non_aktif_'.$value->id, 'style' => 'display: none;']) }}
                                {{ csrf_field() }}
                                {{ Form::close() }}
                              @endif
                            </td>
                    	   <?php ++$no; ?>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->
    </div>
</div>
<!-- page end-->
@stop

@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
<script>
  $('button#btn_aktif').on('click', function(e){
      e.preventDefault();
      var data = $(this).attr('data-file');

      swal({
        title             : "Apakah Anda yakin?",
        text              : "Data ini disetujui!",
        type              : "warning",
        showCancelButton  : true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText : "Yes",
        cancelButtonText  : "No",
        closeOnConfirm    : false,
        closeOnCancel     : false
      },
      function(isConfirm){
        if(isConfirm){
          swal("Disetujui","Data disetujui", "success");
          setTimeout(function() {
            $("#aktif_"+data).submit();
          }, 1000); // 1 second delay
        }
        else{
          swal("cancelled","Dibatalkan", "error");
        }
      }
  );});

  $('button#btn_naktif').on('click', function(e){
      e.preventDefault();
      var data = $(this).attr('data-file');

      swal({
        title             : "Apakah Anda yakin?",
        text              : "Data ini tidak disetujui!",
        type              : "warning",
        showCancelButton  : true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText : "Yes",
        cancelButtonText  : "No",
        closeOnConfirm    : false,
        closeOnCancel     : false
      },
      function(isConfirm){
        if(isConfirm){
          swal("Tidak Disetujui","Data tidak disetujui", "success");
          setTimeout(function() {
            $("#non_aktif_"+data).submit();
          }, 1000); // 1 second delay
        }
        else{
          swal("cancelled","Dibatalkan", "error");
        }
      }
  );});
</script>
@stop
