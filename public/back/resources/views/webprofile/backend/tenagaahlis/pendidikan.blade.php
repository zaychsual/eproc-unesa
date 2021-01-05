<tr>
    <td>
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            {{ Form::text('pendidikan_tahun[]', old('pendidikan_tahun'), array('class' => 'form-control')) }}
        </div>  
        @if ($errors->has('pendidikan_tahun'))
        <span class="help-block">{{$errors->first('pendidikan_tahun')}}</span>
        @endif
    </td>
    <td>                                           
        {{ Form::textarea('pendidikan_uraian[]', old('pendidikan_uraian'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
            @if ($errors->has('pendidikan_uraian'))
            <span class="help-block">{{$errors->first('pendidikan_uraian')}}</span>
            @endif
    </td>
    <td>
        <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
    </td>
</tr>