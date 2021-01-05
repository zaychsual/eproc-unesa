@extends('procurement.layouts.tender.app')

@section('title')
  {{ $title }}
@stop

@section('breadcrumbs')
<li><a href="{{URL::to('dashboard')}}">Dashboard</a></li>
<li class="active">Show Pokja</li>
@stop

@section('content')
<!-- page start-->
<div class="row">
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><strong>Detail</strong> Pokja</h3>
	        </div>
	        <div class="panel-body">
	            <div class="row">
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>:</td>
                            <td> {{ Form::text('name', old('name',$user->name), array('class' => 'form-control')) }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td> {{ Form::text('name', old('name',$user->email), array('class' => 'form-control')) }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Sertifikat</td>
                            <td>:</td>
                            <td> {{ Form::text('name', old('name',$user->nomor_sertifikat), array('class' => 'form-control')) }}</td>
                        </tr>
                        <tr>
                            <td>File Sertifikat</td>
                            <td>:</td>
                            <td>
                                <a href="{{ asset('uploads/file/'.$user->file_sertifikat) }}" target="_blank">
                                    {{ $user->file_sertifikat }}
                                </a>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td>Rekanan</td>
                            <td>:</td>
                            <td>
                                <select name="rekanan_id" id="rekanan_id" class="form-control" required>
                                    <option value="">Pilih</option>
                                    @foreach($rekanans as $key => $value)
                                        <option value="{{ $key }}"> {{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr> --}}
                        <tr>
                            <td>Jenis Pengadaan</td>
                            <td>:</td>
                            <td>
                                {{ Form::select('id_jenis_pengadaan', $jenis_pengadaan, old('id_jenis_pengadaan'), ['class' => 'form-control jenis_pengadaan', 'style' => 'width: 100%;', 'id' => 'id_jenis_pengadaan', 'placeholder' => '- Pilih Data -', 'required']) }}
                            </td>
                        </tr>
                    </table>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-9">
	    <div class="panel panel-default">
	        <div class="panel-footer">
                <a href="{{URL::to('webprofile/pokja')}}" class="btn btn-default pull-right">Batal</a>
                @if($user->is_active == \App\User::NotActive)
	            <button class="btn btn-info pull-right" id="verify" data-id="{{ $user->id }}"
                    data-verify="1">Verify</button>
                &nbsp;&nbsp;
	            <button class="btn btn-danger pull-right" data-id="{{ $user->id }}" id="reject" data-verify="0">Reject</button>
                @endif
	        </div>
	    </div>
	</div>
</div>
<!-- page end-->
@stop

@section('script')
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('ress/js/plugins/summernote/summernote.js') !!}

<script>
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('button#verify').on('click', function(e){
        e.preventDefault();
        let ids = $(this).data('id')
        let verifys = $(this).attr('data-verify')
        //let rekanan_id = $("#rekanan_id").val()
        let id_jenis_pengadaan = $("#id_jenis_pengadaan").val()

        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan diverifikasi!",
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
                const urlYes = "{{ route('pokja-validate-pokja-kepala') }}"
                $.getJSON(urlYes, {
                        'id': ids,
                        'is_validate':verifys,
                        //'rekanan_id' : rekanan_id,
                        'id_jenis_pengadaan' : id_jenis_pengadaan }, 
                function (response) {
                    console.log(response)
                    if( response.is_error == false ) {
                        swal("Success",response.success_msg, "success");
                        setTimeout(function() {
                            location.reload()
                        },200)
                    } else {
                        swal("Oopss",response.error_msg, "error");
                        return false
                    }
                })

            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        });
    });

    $('button#reject').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var verify = $(this).attr('data-verify');

        swal({
            title             : "Apakah Anda yakin?",
            text              : "Data ini akan dibatalkan!",
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
                const urlYes = "{{ route('pokja-validate-pokja-kepala') }}"
                $.getJSON(urlYes, {'id': id,'is_validate':verify }, function (response) {
                    console.log(response)
                    if( response.is_error == false ) {
                        swal("Dipakai",response.success_msg, "success");
                        setTimeout(function() {
                            location.reload()
                        },200)
                    } else {
                        swal("Dipakai",response.error_msg, "success");
                        return false
                    }
                })
            }else{
                swal("cancelled","Dibatalkan", "error");
                return false
            }
        });
    });
</script>
@stop
