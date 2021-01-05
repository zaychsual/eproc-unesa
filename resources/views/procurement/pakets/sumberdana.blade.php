<tr>
    <td>
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            {{ Form::text('sumber_dana[]', old('sumber_dana'), array('class' => 'form-control')) }}
        </div>  
        @if ($errors->has('sumber_dana'))
        <span class="help-block">{{$errors->first('sumber_dana')}}</span>
        @endif
    </td>
    <td>                                           
        {{ Form::number('kode_anggaran[]', old('kode_anggaran'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
            @if ($errors->has('kode_anggaran'))
            <span class="help-block">{{$errors->first('kode_anggaran')}}</span>
            @endif
    </td>
    <td>                                           
        {{ Form::number('nilai[]', old('nilai'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
            @if ($errors->has('nilai'))
            <span class="help-block">{{$errors->first('nilai')}}</span>
            @endif
    </td>
    <td>
        <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
    </td>
</tr>