@extends('webprofile.layouts.backend.master')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Pengaturan</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{!! $title !!}</h3>
                <a class="btn btn-info" href="{{URL::to('webprofile/setting/create')}}" style="margin: 0cm 0px 0cm 10px;">Tambah</a>
                <ul class="panel-controls">
                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <table class="table datatable table-hover" id="berita">
                    <thead>
                        <tr>
                            <th width="7%">No</th>
                            <th width="33%">Name</th>
                            <th width="30%">Value</th>
                            <th align="center" width="15%">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;?>
                    @foreach($data as $value)
                        <tr style="cursor:pointer">
                            <td align="center"><?php echo $no; ?></td>
                            <td>{!! $value->name_setting !!}</td>
                            <td>{!! $value->value_setting !!}</td>
                            <td style="text-align:center;">
                                <a href="{{ route('setting.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
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
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js')
@stop
