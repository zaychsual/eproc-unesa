@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Layouts Website</li>
@stop

@section('content')
<div class="col-md-12">        
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Header</h3>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-3">        
        <div class="panel panel-default">
            <div class="panel-body">
                <h3>Widget Left</h3>
                <div class="panel-body">
                    <a href="{!! url('webprofile/widget/create/left') !!}" class="btn btn-block btn-success"><i class="fa fa-edit"></i> Tambah</a>
                    @foreach ($widget_left as $value)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! $value->title_design !!}    
                            <div class="pull-right">
                                <a href="{{ route('widget.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>

                                <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                                {{ Form::open(['url'=>route('widget.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                                {{ csrf_field() }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">        
        <div class="panel panel-default">
            <div class="panel-body">
                <h3>Content</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">        
        <div class="panel panel-default">
            <div class="panel-body">
                <h3>Widget Right</h3>
                <div class="panel-body">
                    <a href="{!! url('webprofile/widget/create/right') !!}" class="btn btn-block btn-success"><i class="fa fa-edit"></i> Tambah</a>
                    @foreach ($widget_right as $value)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! $value->title_design !!}
                            <div class="pull-right">
                                <a href="{{ route('widget.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>

                                <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                                {{ Form::open(['url'=>route('widget.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                                {{ csrf_field() }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Body <a href="{!! url('webprofile/body/create') !!}" class="btn btn-success"><i class="fa fa-edit"></i> Tambah</a></h3>
            <div class="col-md-12">
                @foreach ($body as $value)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div style="text-align: center;">{!! $value->title_design !!}</div>
                        <div style="text-align: center;">
                            <a href="{{ route('body.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>

                            <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                            {{ Form::open(['url'=>route('body.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                            {{ csrf_field() }}
                            {{ Form::close() }}
                        </div>
                        <hr>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Quote <a href="{!! url('webprofile/quote/create') !!}" class="btn btn-success"><i class="fa fa-edit"></i> Tambah</a></h3>
            <div class="col-md-12">
                @foreach ($quote as $value)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div style="text-align: center;">{!! $value->value_design !!}</div>
                        <div style="text-align: center;">{!! $value->title_design !!}</div>
                        <div style="text-align: center;">
                            <a href="{{ route('quote.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>

                            <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                            {{ Form::open(['url'=>route('quote.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                            {{ csrf_field() }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Footer</h3>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <a href="{{ url('webprofile/footer/footer_row_1') }}" class="btn btn-block btn-success"><i class="fa fa-edit"></i> Footer 1</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{ url('webprofile/footer/footer_row_2') }}" class="btn btn-block btn-success"><i class="fa fa-edit"></i> Footer 2</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{ url('webprofile/footer/footer_row_3') }}" class="btn btn-block btn-success"><i class="fa fa-edit"></i> Footer 3</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{ url('webprofile/footer/footer_row_4') }}" class="btn btn-block btn-success"><i class="fa fa-edit"></i> Footer 4</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
<script>
  $('button#btn_delete').on('click', function(e){
    e.preventDefault();
    var data = $(this).attr('data-file');

    swal({
      title             : "Apakah Anda Yakin?",
      text              : "Anda akan menghapus widget ini!",
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
        swal("Terhapus","Widget berhasil dihapus", "success");
        setTimeout(function() {
          $("#"+data).submit();
        }, 1000); // 1 second delay
      }
      else{
        swal("Dibatalkan","Widget batal dihapus", "error");
      }
    }
  );});
</script>
@stop
