@extends('procurement.layouts.tender.app')

@section('title')
Dashboard
@endsection

@section('breadcrumbs')
<li class="active">Inbox</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> Inbox</h2>
@stop

@section('content')
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		</div>
		<div class="panel with-nav-tabs panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"></h3>
			</div>
			<div class="panel-body">
				{!! $inbox->message !!}
			</div>
		</div>
                    <a href="{{ route('inbox.index') }}" class="btn btn-danger pull-left">Kembali</a>   
	</div> 

</div>

@endsection
@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
@endsection
