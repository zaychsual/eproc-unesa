@extends('procurement.layouts.tender.app')

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
<div class="page-content-wrap">
                    
    <!-- START WIDGETS -->  
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info push-down-20">
                <span style="color: #FFF500;">ATENTION!</span> You are logged in as <code>{{Auth::user()->role}}</code>-<code>{{Auth::user()->name}}</code>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
    </div>

    <div class="row">

        
        <div class="col-md-3">
            
            <!-- START WIDGET MESSAGES -->
            <div class="widget widget-default widget-item-icon" onclick="location.href='{{URL::to('webprofile/listrekanans')}}';">
                <div class="widget-item-left">
                    <span class="fa fa-users"></span>
                </div>                             
                <div class="widget-data">
                    <div class="widget-int num-count">
                    	<?php 
		                    echo $rekanan = DB::table('v_penyedia')
		                    ->whereNull('is_active')
		                    ->orwhere('is_active', 0)
		                    ->count();
		                ?>
                    </div>
                    <div class="widget-title">Partner not verified</div>
                    <div class="widget-subtitle">On your website</div>
                </div>      
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
            </div>                            
            <!-- END WIDGET MESSAGES -->
            
        </div>
        <div class="col-md-3">
            
            <!-- START WIDGET REGISTRED -->
            <div class="widget widget-default widget-item-icon" onclick="location.href='{{URL::to('webprofile/listrekanans_aktif')}}';">
                <div class="widget-item-left">
                    <span class="fa fa-users"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int num-count">
                    	<?php 
		                    echo $rekanan = DB::table('v_penyedia')
		                    ->where('is_active', 1)
		                    ->count();
		                ?>	
		            </div>
                    <div class="widget-title">Registered partner</div>
                    <div class="widget-subtitle">On your website</div>
                </div>
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>                            
            </div>                            
            <!-- END WIDGET REGISTRED -->
            
        </div>
        
    </div>
    <!-- END WIDGETS --> 
    <div class="row">
    	<div class="col-md-4">
                            
        <!-- START PROJECTS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>File </h3>
                    <span>Dokumen</span>
                </div>                                    
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                        <ul class="dropdown-menu">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                        </ul>                                        
                    </li>                                        
                </ul>
            </div>
            <div class="panel-body panel-body-table">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Dokumen</th>
                                <th width="50%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Bukti Penerimaan</strong></td>
                                <td><span class="label label-success"><a href="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/vms/file/a7f08460-abb0-11ea-a66b-c398b03b917c.xlsx">Unduh</a></span></td>
                            </tr>                                                
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!-- END PROJECTS BLOCK -->
    </div>

    <div class="col-md-4">
                            
        <!-- START PROJECTS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Jenis </h3>
                    <span>Pengadaan yang <b style="color: blue">sudah di verifikasi</b></span>
                </div>                                    
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                        <ul class="dropdown-menu">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                        </ul>                                        
                    </li>                                        
                </ul>
            </div>
            <div class="panel-body panel-body-table">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="70%">Jenis Pengadaan</th>
                                <th width="30%">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Jasa  konstruksi</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('is_active', 1)
					                    ->where('jenis', 'Jasa Konstruksi')
					                    ->count();
					                ?>
                                </span></td>
                            </tr>
                            <tr>
                                <td><strong>Jasa konsultansi perencanaan</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('is_active', 1)
					                    ->where('jenis', 'Jasa Konsultasi Perencanaan')
					                    ->count();
					                ?>
                                </span></td>
                            </tr>                                                 
                            <tr>
                                <td><strong>Jasa konsultansi pengawasan</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('is_active', 1)
					                    ->where('jenis', 'Jasa Konsultasi Pengawasan')
					                    ->count();
					                ?>
                                </span></td>
                            </tr> 
                            <tr>
                                <td><strong>Jasa lainnya</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('is_active', 1)
					                    ->where('jenis', 'Jasa Lainnya')
					                    ->count();
					                ?>
                                </span></td>
                            </tr> 
                            <tr>
                                <td><strong>Barang</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('is_active', 1)
					                    ->where('jenis', 'Barang')
					                    ->count();
					                ?>
                                </span></td>
                            </tr> 
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!-- END PROJECTS BLOCK -->
    </div>

    <div class="col-md-4">
                            
        <!-- START PROJECTS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Jenis </h3>
                    <span>Pengadaan yang <b style="color: red">belum di verifikasi</b></span>
                </div>                                    
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                        <ul class="dropdown-menu">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                        </ul>                                        
                    </li>                                        
                </ul>
            </div>
            <div class="panel-body panel-body-table">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="70%">Jenis Pengadaan</th>
                                <th width="30%">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Jasa  konstruksi</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('jenis', 'Jasa Konstruksi')
					                    ->whereNull('is_active')
					                    ->count();
					                ?>
                                </span></td>
                            </tr>
                            <tr>
                                <td><strong>Jasa konsultansi perencanaan</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('jenis', 'Jasa Konsultasi Perencanaan')
					                    ->whereNull('is_active')
					                    ->count();
					                ?>
                                </span></td>
                            </tr>                                                 
                            <tr>
                                <td><strong>Jasa konsultansi pengawasan</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('jenis', 'Jasa Konsultasi Pengawasan')
					                    ->whereNull('is_active')
					                    ->count();
					                ?>
                                </span></td>
                            </tr> 
                            <tr>
                                <td><strong>Jasa lainnya</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('jenis', 'Jasa Lainnya')
					                    ->whereNull('is_active')
					                    ->count();
					                ?>
                                </span></td>
                            </tr> 
                            <tr>
                                <td><strong>Barang</strong></td>
                                <td><span class="label label-info">
                                	<?php 
					                    echo $rekanan = DB::table('v_penyedia')
					                    ->where('jenis', 'Barang')
					                    ->whereNull('is_active')
					                    ->count();
					                ?>
                                </span></td>
                            </tr> 
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!-- END PROJECTS BLOCK -->
    </div>
    
    <!-- START DASHBOARD CHART -->
	<div class="chart-holder" id="dashboard-area-1" style="height: 700px;"></div>
	<div class="block-full-width">
                                                       
    </div>                    
    <!-- END DASHBOARD CHART -->
    
</div>

@endsection
