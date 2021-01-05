<div class="modal-body" id="inseojs">
  <div class="form-group">
    <div class="col-lg-12">

      @if(strpos($mime, 'png') == false)
        {{-- siakadu --}}
        <center><img src="https://siakadu.unesa.ac.id/photo/yudisium/{{$data->nim}}.jpg" alt="{!! Session::get('ss_userid') !!}" style="height:150px; width: auto; margin-bottom: 10px;"></center>
      @else
        {{-- yudisium --}}
        <center><img src="https://yudisium.unesa.ac.id/assets/foto_yudisium/{{$data->nim}}.jpg" alt="{!! Session::get('ss_userid') !!}" style="height:150px; width: auto; margin-bottom: 10px;"></center>
      @endif
    </div>
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Nim', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->nim)
      {{ Form::label('nuid', $data->nim, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Nama', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->nama)
      {{ Form::label('nuid', $data->nama, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  {{-- <div class="form-group">
    {{ Form::label('nuid', 'Tempat Lahir', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->tmplahir)
      {{ Form::label('nuid', $data->tmplahir, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div> --}}
  {{-- <div class="form-group">
    {{ Form::label('nuid', 'Tanggal Lahir', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->tgllahir)
      {{ Form::label('nuid', InseoHelper::tglbulanindo2($data->tgllahir), array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div> --}}
  {{-- <div class="form-group">
    {{ Form::label('nuid', 'Jenis Kelamin', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->sex)
      {{ Form::label('nuid', $data->sex, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div> --}}
  <div class="form-group">
    {{ Form::label('nuid', 'Fakultas', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->fakultas)
      {{ Form::label('nuid', $data->fakultas, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Prodi', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->prodi)
      {{ Form::label('nuid', $data->prodi, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Angkatan', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->tglregistrasi)
      {{ Form::label('nuid', $data->tglregistrasi, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Pekerjaan', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->jabatan_lembaga)
      {{ Form::label('nuid', $data->jabatan_lembaga, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Kantor', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->nm_lembaga)
      {{ Form::label('nuid', $data->nm_lembaga, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Sektor', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->jenis_lembaga)
      {{ Form::label('nuid', $data->jenis_lembaga, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  {{-- <div class="form-group">
    {{ Form::label('nuid', 'Lulus', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->tglselesai)
      {{ Form::label('nuid', $data->tglselesai, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Alamat sesuai KTP', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->alamatktp)
      {{ Form::label('nuid', $data->alamatktp, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Alamat Sekarang', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->alamatsekarang)
      {{ Form::label('nuid', $data->alamatsekarang, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Nomor HP', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->hp)
      {{ Form::label('nuid', $data->hp, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Email', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->email)
      {{ Form::label('nuid', $data->email, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div> --}}
  {{-- <div class="form-group">
    {{ Form::label('nuid', 'Status Bekerja', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    @if($data->statusbekerja)
      {{ Form::label('nuid', $data->statusbekerja, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', '-', ['class'=>'control-label col-lg-8']) }}
    @endif
  </div> --}}
</div>
