@extends('webprofile.layouts.backend.master')

{{-- @section('assets')
<link rel='stylesheet' type='text/css' href='https://statik.unesa.ac.id/profileunesa_konten_statik/front/css/{!! Session::get('ss_setting')['style'] !!}' />
@endsection --}}

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Footer</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{!! $title !!}</h3>
                <a class="btn btn-info" href="{{URL::to('webprofile/admin/info/create')}}" style="margin: 0cm 0px 0cm 10px;">Tambah</a>
                <ul class="panel-controls">
                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <table class="table datatable table-hover" id="post">
                    <thead>
                        <tr>
                            <th width="7%" style="text-align: center;">No</th>
                            <th width="68%" style="text-align: center;">Judul</th>
                            <th align="center" width="10%" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="cursor:pointer">
                            <td style="text-align: center; vertical-align: middle;">1</td>
                            <td style="vertical-align: middle; font-size: 12pt;">                                
                                Footer Row 1
                            </td>
                            <td style="text-align:center; vertical-align: middle;">
                              <a href="{{ route('info.edit', ['data'=>Crypt::encrypt($data[0])]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        <tr style="cursor:pointer">
                            <td style="text-align: center; vertical-align: middle;">2</td>
                            <td style="vertical-align: middle; font-size: 12pt;">                                
                                Footer Row 2
                            </td>
                            <td style="text-align:center; vertical-align: middle;">
                              <a href="{{ route('info.edit', ['data'=>Crypt::encrypt($data[0])]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        <tr style="cursor:pointer">
                            <td style="text-align: center; vertical-align: middle;">3</td>
                            <td style="vertical-align: middle; font-size: 12pt;">                                
                                Footer Row 3
                            </td>
                            <td style="text-align:center; vertical-align: middle;">
                              <a href="{{ route('info.edit', ['data'=>Crypt::encrypt($data[0])]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        <tr style="cursor:pointer">
                            <td style="text-align: center; vertical-align: middle;">4</td>
                            <td style="vertical-align: middle; font-size: 12pt;">                                
                                Footer Row 4
                            </td>
                            <td style="text-align:center; vertical-align: middle;">
                              <a href="{{ route('info.edit', ['data'=>Crypt::encrypt($data[0])]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->
    </div>
</div>
<!-- page end-->
{{-- @include('webprofile.front.footer') --}}
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
