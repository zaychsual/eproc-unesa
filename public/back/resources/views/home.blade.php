@extends('webprofile.layouts.backend.app')

@section('title')
  Dashboard
@endsection

@section('breadcrumbs')
<li class="active">Dashboard</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> Dashboard</h2>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                You are logged in as <code>{{Auth::user()->role}}</code>-<code>{{Auth::user()->name}}</code>
            </div>
        </div>
    </div>
</div>
@endsection