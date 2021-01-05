@extends('webprofile.layouts.backend.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">{!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-md-12">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{!! $title !!}</h3>
                
                <ul class="panel-controls">
                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <table class="table datatable table-hover" id="berita">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Hp</th>
                            <th>NPWP</th>
                            <th>Tanggal Daftar</th>
                            <th>Bentuk Usaha</th>
                            <th>Email</th>

                            <th align="center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;?>
                    @foreach($data['rekanan'] as $value)
                        <tr style="cursor:pointer">
                            <td align="center"><?php echo $no; ?></td>
                            <td>{!! $value->kode !!}</td>
                            <td>{!! $value->nama !!} <b style="color: red">(Non-Aktif)</b></td>
                            <td>{!! $value->alamat !!}</td>
                            <td>{!! $value->telepon !!}</td>
                            <td>{!! $value->hp !!}</td>
                            <td>{!! $value->npwp !!}</td>
                            <td>{!! $value->created_at !!}</td>
                            <td>{!! $value->name !!}</td>
                            <td>{!! $value->email !!}</td>
                            
                            <td style="text-align:center;">
                                @if($value->is_active == 0)
                                  <button class="btn btn-success btn-xs" id="btn_aktif" data-file="{{$value->id}}"><i class="fa fa-check"></i></button>
                                  {{ Form::open(['url'=>route('rekanans_aktif', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'get', 'id' => 'aktif_'.$value->id, 'style' => 'display: none;']) }}
                                  {{ csrf_field() }}
                                  {{ Form::close() }}
                                @endif
                                @if($value->is_active == 1)
                                  <button class="btn btn-danger btn-xs" id="btn_naktif" data-file="{{$value->id}}"><i class="fa fa-times"></i></button>
                                  {{ Form::open(['url'=>route('rekanans_naktif', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'get', 'id' => 'non_aktif_'.$value->id, 'style' => 'display: none;']) }}
                                  {{ csrf_field() }}
                                  {{ Form::close() }}
                                @endif

                                <a href="{{ route('rekanans.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                {{-- 
                                <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                                {{ Form::open(['url'=>route('rekanans.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                                {{ csrf_field() }}
                                {{ Form::close() }}
                                --}}
                              </td>
                          <?php $no++;?>
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
  $('button#btn_delete').on('click', function(e){
    e.preventDefault();
    var data = $(this).attr('data-file');

    swal({
      title             : "Apakah Anda Yakin?",
      text              : "Anda akan menghapus data ini!",
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
        swal("Terhapus","Data berhasil dihapus", "success");
        setTimeout(function() {
          $("#"+data).submit();
        }, 1000); // 1 second delay
      }
      else{
        swal("Dibatalkan","Data batal dihapus", "error");
      }
    }
  );});

  $('button#btn_aktif').on('click', function(e){
      e.preventDefault();
      var data = $(this).attr('data-file');

      swal({
        title             : "Apakah Anda yakin?",
        text              : "Data ini dipakai!",
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
          swal("Dipakai","Data dipakai", "success");
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
        text              : "Data ini tidak dipakai!",
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
          swal("Tidak dipakai","Data tidak dipakai", "success");
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
