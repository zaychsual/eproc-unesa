<div id="simply-search" style="padding-top: 10px;">
  <center>
    <form id="search-form" role="form" method="post" action="{!! url('search') !!}" style="width: 90%;">
    {!! Form::open(array('url' => route('search'), 'method' => 'POST', 'id' => 'search', 'role' => 'form', 'style'=>'width: 90%;')) !!}
      <div class="input-group">
        <input type="text" name="search" class="form-control search-form" placeholder="Search" value="{!! Session::get('ss_search') !!}">
        <span class="input-group-btn"><button type="submit" class="btn btn-primary btn-inseo-search search-btn" data-target="#search-form" name="q"><i class="fa fa-search"></i></button></span>
      </div>
    </form>
  </center>
</div>

<div id="advance-search" style="display:none;">
  {!! Form::open(array('url' => route('advsearch'), 'method' => 'POST', 'id' => 'advsearch', 'class' => 'form-horizontal')) !!}
    <div class="box-body">
      <div class="form-group">
        <label for="typedoc" class="col-sm-2 control-label">Tipe Dokumen</label>

        <div class="col-sm-9">
          {{ Form::select('typedoc', $typedoc, Session::get('ss_adv_typedoc'), array('class' => 'form-control select2', 'id'=>'typedoc', 'required', 'placeholder'=>'- Pilih -', 'style'=>'width: 100%')) }}
        </div>
      </div>
      <div class="form-group">
        <label for="fakultas" class="col-sm-2 control-label">Fakultas</label>

        <div class="col-sm-9">
          {{ Form::select('fakultas', InseoHelper::fakultas(), Session::get('ss_adv_fakultas'), array('class' => 'form-control select2', 'id'=>'fakultas', 'required', 'placeholder'=>'- Pilih -', 'style'=>'width: 100%')) }}
          {{-- {{ Form::text('fakultas', null, array('class' => 'form-control')) }} --}}
        </div>
      </div>
      <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Judul</label>

        <div class="col-sm-9">
          {{ Form::text('title', Session::get('ss_adv_judul'), array('class' => 'form-control')) }}
        </div>
      </div>
      <div class="form-group">
        <label for="author" class="col-sm-2 control-label">Penulis</label>

        <div class="col-sm-9">
          {{ Form::text('author', Session::get('ss_adv_penulis'), array('class' => 'form-control')) }}
        </div>
      </div>
      {{-- <div class="form-group">
        <label for="subject" class="col-sm-2 control-label">Subyek</label>

        <div class="col-sm-9">
          {{ Form::select('subject', $subject, null, array('class' => 'form-control select2', 'id'=>'subject', 'required', 'placeholder'=>'- Pilih -', 'style'=>'width: 100%')) }}
        </div>
      </div> --}}
    </div>
    <div class="form-group">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-9">
        <button type="submit" class="btn btn-advanced-search pull-right" style="margin-right: 10px;">Search</button>
      </div>
    </div>
  </form>
</div>
<div id="advance" align="center">
    <a><span style="font-size:16px; cursor:pointer;">Advanced Search</span></a>
</div>
