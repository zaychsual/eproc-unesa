<?php
$id = rand();
?>

<tr>
    <td>
        {{ Form::select('provinsi_id[]', $data['provinsi'], old('provinsi_id'), ['class' => 'form-control provinsi_id',  'data-live-search' => 'true', 'style' => 'width: 100%;', 'id' => 'provinsi_id'.$id, 'placeholder' => '- Pilih Data -', 'required']) }}

        @if ($errors->has('provinsi_id'))
        <span class="help-block">{{$errors->first('provinsi_id')}}</span>
        @endif
    </td>
    <td>                                           
        {{ Form::select('kota_id[]', [], old('kota_id'), ['class' => 'form-control kota_id', 'rows' => 2, 'style' => 'width: 100%;', 'id' => 'kota_id'.$id, 'placeholder' => '- Pilih Data -', 'required']) }}

        @if ($errors->has('kota_id'))
        <span class="help-block">{{$errors->first('kota_id')}}</span>
        @endif
    </td>
    <td>                                           
        {{ Form::textarea('alamat[]', old('alamat'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
            @if ($errors->has('alamat'))
            <span class="help-block">{{$errors->first('alamat')}}</span>
            @endif
    </td>
    <td>
        <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
    </td>
</tr>

<!-- START PLUGINS -->
<script type="text/javascript" src="{{ asset('ress/js/plugins/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('ress/js/plugins/jquery/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('ress/js/plugins/bootstrap/bootstrap.min.js') }}"></script>        
<!-- END PLUGINS -->

<!-- THIS PAGE PLUGINS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript" src="{{ asset('ress/js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<!-- END PAGE PLUGINS -->       


@section('script')
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-datepicker.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-timepicker.min.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap-file-input.js') !!}
{!! Html::script('ress/js/plugins/summernote/summernote.js') !!}


{{Html::script('js/jquery.mask.min.js')}}

<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('#provinsi_id{{$id}}').select2();
        $('#kota_id{{$id}}').select2();
    });
</script>
@stop

<script type="text/javascript">
    $('#provinsi_id{{$id}}').on('change', function (e) {
        var provinsi = e.target.value;
        var request = $.ajax({
            url: urlKota + "/" + provinsi,
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            type: "GET",
            dataType: "html"
        });

        request.done(function (output) {
            $('#kota_id{{$id}}').empty();
            $('#kota_id{{$id}}').html(output);
        });
    })
</script>
