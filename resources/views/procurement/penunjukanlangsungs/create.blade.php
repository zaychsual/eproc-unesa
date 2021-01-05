@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('home')}}">Dashboard</a></li>
<li class="active">Edit {!! $title !!}</li>
@stop

@section('pagetitle')
<h2><span class="fa fa-arrow-circle-o-left"></span> {!! $title !!} </h2>
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="panel with-nav-tabs panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"></h3>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tabInfoPaket" data-toggle="tab">Informasi Paket</a></li>
                <li><a href="#tabPp" data-toggle="tab">Pertanyaan dan Penjelasan</a></li>
                <li><a href="#tabPpp" data-toggle="tab">Penawaran Peserta</a></li>
                <li><a href="#tabEvaluassi" data-toggle="tab">Evaluasi</a></li>
                @if($getTahapan != null)
                    @if($getTahapan->nama == 'Debriefing')
                        <li><a href="#tabDbriefing" data-toggle="tab">Dbriefing</a></li>
                    @endif
                @endif
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tabInfoPaket">
                    @include('procurement.penunjukanlangsungs.tab-infopaket')
                </div>
                <div class="tab-pane fade" id="tabPp">
                    @include('procurement.penunjukanlangsungs.tab-pertanyaan')
                </div>
                <div class="tab-pane fade" id="tabPpp">
                    @include('procurement.penunjukanlangsungs.tab-penawaran')
                </div>
                <div class="tab-pane fade" id="tabEvaluassi">
                    @include('procurement.penunjukanlangsungs.tab-evaluasi')
                </div>
                @if($getTahapan != null)
                    @if($getTahapan->nama == 'Debriefing')
                    <div class="tab-pane fade" id="tabDbriefing">
                        @include('procurement.penunjukanlangsungs.tab-briefing')
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@include('procurement.penunjukanlangsungs.pop-up')
@stop
@section('script')
{!! Html::script('ress/js/plugins/datatables/jquery.dataTables.min.js') !!}
    <script>
    //init const persetujuan
    const Approve = 1
    const Reject  = 3

    $("#btns").click(function() {
        $("#rekanan_ids").val($(this).data('rekanan'))
    });

    $('button#submit').on('click', function(e){
        e.preventDefault();
        let paket_id = $("#paket_id").val()
        let masa_berlaku = $("#masa_berlaku").val()

        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan disubmit!",
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
                const urlYes = "{{ route('store-masa-berlaku') }}"
                $.ajax({
                    url : urlYes,
                    type : 'POST',
                    data: {
                        paket_id : paket_id,
                        masa_berlaku : masa_berlaku
                    },
                    dataType: 'json',
                    success:function (response) {
                        if( response.is_error == true ) {
                            swal("Oopss!!!",response.error_msg, "error")
                            return false
                        } else {
                            setTimeout(function() {
                                location.reload()
                            },200)
                            swal("Success",response.error_msg, "success")
                        }
                    }
                })                
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        });
    });

    $('button#submits').on('click', function(e){
        e.preventDefault();

        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan disubmit!",
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
                const urlYesJadwal = "{{ route('store-jadwal-pengadaans') }}"
                $.ajax({
                    url : urlYesJadwal,
                    type : 'POST',
                    data: $("#form-jadwal").serialize(),
                    dataType: 'json',
                    success:function (response) {
                        if( response.is_error == true ) {
                            swal("Oopss!!!",response.error_msg, "error")
                            return false
                        } else {
                            setTimeout(function() {
                                location.reload()
                            },200)
                            swal("Success",response.error_msg, "success")
                        }
                    }
                })                
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        });
    });
    
    $('button#setuju').on('click', function(e){
        e.preventDefault();

        let paket_idx = $(this).data('paket_id')
        console.log(paket_idx)

        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan disubmit!",
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
                const urlYes = "{{ route('penunjukan-langsung.store-approval-pokja') }}"
                $.ajax({
                    url : urlYes,
                    type : 'POST',
                    data: {
                        paket_id : paket_idx,
                        status : Approve
                    },
                    dataType: 'json',
                    success:function (response) {
                        if( response.is_error == true ) {
                            swal("Oopss!!!",response.error_msg, "error")
                            return false
                        } else {
                            setTimeout(function() {
                                location.reload()
                            },200)
                            swal("Success",response.error_msg, "success")
                        }
                    }
                })                
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        })
    })

    $('button#tidaksetuju').on('click', function(e){
        e.preventDefault()
        let paket_ids = $(this).data('pakets_id')
        let reason = $("#reason").val()


        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan disubmit!",
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
                const urlYes = "{{ route('penunjukan-langsung.store-approval-pokja') }}"
                $.ajax({
                    url : urlYes,
                    type : 'POST',
                    data: {
                        paket_id : paket_ids,
                        status : Reject,
                        reason : reason
                    },
                    dataType: 'json',
                    success:function (response) {
                        if( response.is_error == true ) {
                            swal("Oopss!!!",response.error_msg, "error")
                            return false
                        } else {
                            setTimeout(function() {
                                location.reload()
                            },200)
                            swal("Success",response.error_msg, "success")
                        }
                    }
                })                
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        })
    })

    function basicPopup(url) {
        popupWindow = window.open(url,'popUpWindow','height=300,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')
	}
    </script>
@endsection