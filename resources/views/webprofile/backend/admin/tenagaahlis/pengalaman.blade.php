<tr>
    <td>
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            {{ Form::text('pengalaman_tahun[]', old('pengalaman_tahun'), array('class' => 'form-control')) }}
        </div>  
        @if ($errors->has('pengalaman_tahun'))
        <span class="help-block">{{$errors->first('pengalaman_tahun')}}</span>
        @endif
    </td>
    <td>                                           
        {{ Form::textarea('pengalaman_uraian[]', old('pengalaman_uraian'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
            @if ($errors->has('pengalaman_uraian'))
            <span class="help-block">{{$errors->first('pengalaman_uraian')}}</span>
            @endif
    </td>
    <td>
        <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
    </td>
</tr>