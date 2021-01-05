<tr>
    <td>                                           
        {{ Form::textarea('bahasa_uraian[]', old('bahasa_uraian'), array('class' => 'form-control', 'rows' => 2, 'cols' => 40)) }}
            @if ($errors->has('bahasa_uraian'))
            <span class="help-block">{{$errors->first('bahasa_uraian')}}</span>
            @endif
    </td>
    <td>
        <a style="cursor:pointer" onclick="$(this).parent().parent().remove();"> <span class="fa fa-trash-o"></span> </a>
    </td>
</tr>