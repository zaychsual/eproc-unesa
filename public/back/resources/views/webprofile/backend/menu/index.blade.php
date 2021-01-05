@extends('layouts.master')

@section('title')
  {{ $title }}
@stop

@section('assets')
{{-- {!! Html::style("template/sweet/sweetalert.css") !!} --}}
<link rel="stylesheet" href="https://statik.unesa.ac.id/profileunesa_konten_statik/admin/assets/select2/select2.min.css">
<style media="screen">
  .tkh{
    color: black;
  }
</style>
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Menu</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-default">
        {!! Form::open(array('url' => route('menu.store'), 'method' => 'POST', 'id' => 'menu')) !!}
        {!! csrf_field() !!}
	        <div class="panel-heading">
	            <h3 class="panel-title">Tambah Menu Baru</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('title')) has-error @endif">
                          <div class="col-md-12">
                            <label for="parent">Parent</label>
                            {{ Form::select('parent', $parent, old('parent'), ['class' => 'form-control select2', 'style' => 'width: 100%; font-size: 14pt;', 'id' => 'parent', 'placeholder' => 'Parent']) }}
                            @if ($errors->has('parent'))
                            <label id="login-error" class="error" for="login">{{$errors->first('parent')}}</label>
                            @endif
                          </div>
                          <div class="col-md-12">
                            <label for="name">Judul</label>
	                          {{ Form::text('name', old('name'), array('class' => 'form-control', 'placeholder'=>'Judul')) }}
	                          @if ($errors->has('name'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('name')}}</label>
	                          @endif
	                        </div>
                          <div class="col-md-12">
                            <label for="url">URL</label>
	                          {{ Form::text('url', old('url'), array('class' => 'form-control', 'placeholder'=>'URL')) }}
	                          @if ($errors->has('url'))
	                          <label id="login-error" class="error" for="login">{{$errors->first('url')}}</label>
	                          @endif
	                        </div>
                          <div class="col-md-12" style="padding-top: 10px;">
                            <button class="btn btn-info pull-right">Simpan</button>
                          </div>
	                    </div>
                  </div>
	            </div>
	        </div>
        {!! Form::close() !!}
	    </div>
      <div class="panel panel-default">
        {!! Form::open(array('url' => route('menu.storepage'), 'method' => 'POST', 'id' => 'menu')) !!}
        {!! csrf_field() !!}
	        <div class="panel-heading">
	            <h3 class="panel-title">Tambah Menu Dari Page</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group @if ($errors->has('title')) has-error @endif">
                          <div class="col-md-12">
                            <label for="parentpage">Parent</label>
                            {{ Form::select('parentpage', $parent, old('parentpage'), ['class' => 'form-control select2', 'style' => 'width: 100%; font-size: 14pt;', 'id' => 'parentpage', 'placeholder' => 'Parent']) }}
                            @if ($errors->has('parentpage'))
                            <label id="login-error" class="error" for="login">{{$errors->first('parentpage')}}</label>
                            @endif
                          </div>
                          <div class="col-md-12">
                            <label for="page">Page</label>
                            {{ Form::select('page', $page, old('page'), ['class' => 'form-control select2', 'style' => 'width: 100%; font-size: 14pt;', 'id' => 'page', 'placeholder' => 'Page', 'required']) }}
                            @if ($errors->has('page'))
                            <label id="login-error" class="error" for="login">{{$errors->first('page')}}</label>
                            @endif
                          </div>
                          <div class="col-md-12" style="padding-top: 10px;">
                            <button class="btn btn-info pull-right">Simpan</button>
                          </div>
	                    </div>
                  </div>
	            </div>
	        </div>
        {!! Form::close() !!}
	    </div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title">Menu</h3>
	            <ul class="panel-controls">
	                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
	            </ul>
	        </div>
	        <div class="panel-body">
	            <div class="row">
                    <div class="col-md-12">
	                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="53%" style="text-align: center;">Nama</th>
                                <th align="center" width="10%" style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        @foreach ($data as $value)
                          @if(!$value->parent)
                            <tr style="cursor:pointer">
                                <td><a href="{!! url((string)$value->url) !!}">{!! $value->name !!}</a></td>
                                <td style="text-align:center; vertical-align: middle;">
                                  @if($value->urutan == 1)
                                    <a href="{{ route('menu_down', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs">
                                      <i class="fa fa-arrow-down"></i>
                                    </a>
                                  @endif
                                  @if($value->urutan > 1)
                                    @if($value->urutan == $hmenu)
                                      <a href="{{ route('menu_up', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs">
                                        <i class="fa fa-arrow-up"></i>
                                      </a>
                                    @else
                                      <a href="{{ route('menu_up', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs">
                                        <i class="fa fa-arrow-up"></i>
                                      </a>
                                      <a href="{{ route('menu_down', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs">
                                        <i class="fa fa-arrow-down"></i>
                                      </a>
                                    @endif
                                  @endif

                                  <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                                  {{ Form::open(['url'=>route('menu.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                                  {{ csrf_field() }}
                                  {{ Form::close() }}
                                </td>
                            </tr>
                            @foreach ($data as $valuec)
                              @if($valuec->parent == $value->id)
                                <tr>
                                  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{!! url((string)$valuec->url) !!}">{!! $valuec->name !!}</a></td>
                                  <td style="text-align:center; vertical-align: middle;">
                                      @if($valuec->urutan == 1)
                                        <a href="{{ route('menu_down', ['data'=>Crypt::encrypt($valuec->id)]) }}" class="btn btn-warning btn-xs">
                                          <i class="fa fa-arrow-down"></i>
                                        </a>
                                      @endif
                                      @if($valuec->urutan > 1)
                                        @if($valuec->urutan == $hmenu)
                                          <a href="{{ route('menu_up', ['data'=>Crypt::encrypt($valuec->id)]) }}" class="btn btn-warning btn-xs">
                                            <i class="fa fa-arrow-up"></i>
                                          </a>
                                        @else
                                          <a href="{{ route('menu_up', ['data'=>Crypt::encrypt($valuec->id)]) }}" class="btn btn-warning btn-xs">
                                            <i class="fa fa-arrow-up"></i>
                                          </a>
                                          <a href="{{ route('menu_down', ['data'=>Crypt::encrypt($valuec->id)]) }}" class="btn btn-warning btn-xs">
                                            <i class="fa fa-arrow-down"></i>
                                          </a>
                                        @endif
                                      @endif

                                    <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$valuec->id}}"><i class="fa fa-trash-o"></i></button>
                                    {{ Form::open(['url'=>route('menu.destroy', ['data'=>Crypt::encrypt($valuec->id)]), 'method'=>'delete', 'id' => $valuec->id, 'style' => 'display: none;']) }}
                                    {{ csrf_field() }}
                                    {{ Form::close() }}
                                  </td>
                                </tr>
                              @endif
                            @endforeach
                          @endif
                        @endforeach
	                    </table>
	                </div>
	            </div>
	        </div>
	        <div class="panel-footer">
	        </div>
	    </div>
	</div>
</div>
<!-- page end-->
@stop

@section('script')
{!! Html::script('https://statik.unesa.ac.id/profileunesa_konten_statik/admin/js/plugins/datatables/jquery.dataTables.min.js') !!}
<script src="https://statik.unesa.ac.id/spn_konten_statik/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
  $('#parent').select2();
  $('#parentpage').select2();
  $('#page').select2();

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
