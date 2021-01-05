<tr>
    <td>
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            {{ Form::text('sertifikat_tahun[]', old('sertifikat_tahun'), array('class' => 'form-control')) }}
        </div>  
        @if ($errors->has('sertifikat_tahun'))
        <span class="help-block">{{$errors->first('sertifikat_tahun')}}</span>
        @endif
    </td>
    <td>                                           
        {{ Form::textarea('sertifikat_uraian[]', old('sertifikat_uraian'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
            @if ($errors->has('sertifikat_uraian'))
            <span class="help-block">{{$errors->first('sertifikat_uraian')}}</span>
            @endif
    </td>
    <td>
        <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
    </td>
</tr>