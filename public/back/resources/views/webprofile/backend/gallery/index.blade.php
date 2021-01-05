@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Gallery</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{!! $title !!}</h3>
                <a class="btn btn-info" href="{{URL::to('webprofile/gallery/create')}}" style="margin: 0cm 0px 0cm 10px;">Tambah</a>
                <ul class="panel-controls">
                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <table class="table datatable table-hover" id="post">
                    <thead>
                        <tr>
                            <th width="7%" style="text-align: center;">No</th>
                            <th width="35%" style="text-align: center;">Judul</th>
                            <th width="38%" style="text-align: center;">Gallery</th>
                            <th width="10%" style="text-align: center;">Status</th>
                            <th align="center" width="10%" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;?>
                    @foreach($data as $value)
                        <tr style="cursor:pointer">
                            <td style="text-align: center; vertical-align: middle;"><?php echo $no; ?></td>
                            <td style="vertical-align: middle; font-size: 12pt;">
                              {!! $value->title !!}
                            </td>
                            <td style="vertical-align: middle;">
                              <img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!!$value->images!!}" alt="" height="100" width="auto">
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                              @if($value->is_active == 1)
                                <i class="fa fa-check" style="color: green"></i>
                              @endif
                              @if($value->is_active == 0)
                                <i class="fa fa-times" style="color: red"></i>
                              @endif
                            </td>
                            <td style="text-align:center; vertical-align: middle;">
                              @if($value->is_active == 0)
                                <button class="btn btn-success btn-xs" id="btn_aktif" data-file="{{$value->id}}"><i class="fa fa-check"></i></button>
                                {{ Form::open(['url'=>route('gallery_aktif', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'get', 'id' => 'aktif_'.$value->id, 'style' => 'display: none;']) }}
                                {{ csrf_field() }}
                                {{ Form::close() }}
                              @endif
                              @if($value->is_active == 1)
                                <button class="btn btn-danger btn-xs" id="btn_naktif" data-file="{{$value->id}}"><i class="fa fa-times"></i></button>
                                {{ Form::open(['url'=>route('gallery_naktif', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'get', 'id' => 'non_aktif_'.$value->id, 'style' => 'display: none;']) }}
                                {{ csrf_field() }}
                                {{ Form::close() }}
                              @endif

                              <a href="{{ route('gallery.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>

                              <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                              {{ Form::open(['url'=>route('gallery.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                              {{ csrf_field() }}
                              {{ Form::close() }}
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
{!! Html::script('https://statik.unesa.ac.id/profileunesa_konten_statik/admin/js/plugins/datatables/jquery.dataTables.min.js') !!}
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
