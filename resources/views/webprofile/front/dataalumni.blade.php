@extends('layouts.profile.master')

@section('content')
  <section class="post-wrapper-top jt-shadow clearfix">
    <div class="container">
      <div class="col-lg-12">
          <h2>{!! $title !!}</h2>
      </div>
    </div>
  </section><!-- end post-wrapper-top -->

  <section class="blog-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
          <div class="row">
            <div class="blog-masonry">
              <div class="col-lg-12">
                <div class="doc">
                  <h3>Pendaftaran Alumni</h3>
                    <a href="https://simalumni.unesa.ac.id/simal-register" class="btn btn-success" style="width:100%; height: 60px; vertical-align: middle; padding-top: 12px; font-size: 24px;" target="_blank">Pendaftaran Alumni</a>
                </div>
							  <div class="doc">
                	<h3>Filter</h3>
                  {{ Form::open(array('url' => route('data_alumni_filter'), 'method' => 'get', 'style'=>'padding-left: 15px; padding-top: 15px;')) }}
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" class="form-control" name="nama" value="{{ Session::get('ss_fr_nama') }}" id="nama" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="nim">NIM</label>
                      <input type="text" class="form-control" name="nim" value="{{ Session::get('ss_fr_nim') }}" id="nim" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="fakultas">Fakultas</label>
                      {{ Form::select('fakultas', $fakultas, Session::get('ss_fr_fakultas'), array('id'=>'fakultas', 'placeholder' => '- Fakultas -', 'class'=>'form-control input-sm')) }}
                    </div>
                    <div class="form-group">
                      <label for="thnmasuk">Tahun Masuk</label>
                      {{ Form::selectYear('angkatan', 2000, 2017, Session::get('ss_fr_angkatan'), ['class'=>'form-control input-sm', 'placeholder'=>'- Tahun -']) }}
                      {{-- {{ Form::select('angkatan', $angkatan, Session::get('ss_adm_angkatan'), array('id'=>'angkatan', 'placeholder' => '- Angkatan -', 'class'=>'form-control input-sm')) }} --}}
                    </div>
                    <button type="submit" class="btn btn-primary">Cari Data</button>
                    <a href="{{ url('data_alumni') }}" class="btn btn-danger">Reset Pencarian</a>
                  {{ Form::close() }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="content" class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <div class="row">
              <div class="blog-masonry">
                  <div class="col-lg-12">
                      <div class="blog-carousel">
                          <div class="">
                            <div class="doc">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th style="text-align: center;">NIM</th>
                                    <th style="text-align: center;">Nama Lengkap</th>
                                    <th style="text-align: center;">Fakultas</th>
                                    <th style="text-align: center;">Jenjang Pendidikan</th>
                                    <th style="text-align: center;">Tahun Masuk</th>
                                    <th style="text-align: center;">Menu</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($data as $value)
                                    <tr>
                                      <td style="text-align: center;">{{ $value->nim }}</td>
                                      <td>{{ $value->nama }}</td>
                                      <td style="text-align: center;">{{ $value->fakultas }}</td>
                                      <td style="text-align: center;">{{ $value->programpend }}</td>
                                      <td style="text-align: center;">{{ $value->tglregistrasi }}</td>
                                      <td style="text-align: center;">
                                        {{-- <a class="btn btn-xs btn-info">Detil</a> --}}
                                        <a href="#myModal" data-toggle="modal" data-target="#myModal" data-id="{{ $value->nim }}" class="detilinseo modalLink btn btn-xs btn-info">Detil</a>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                          </div>
                            <div class="clearfix"></div>
                            <hr>
                            <center>{!! $data->render() !!}</center>
                          </div><!-- end post-slider -->
                      </div><!-- end entry -->
                  </div><!-- end blog-carousel -->
        		  </div><!-- end blog-masonry -->
      	    </div><!-- end widget -->
          </div><!-- end left-sidebar -->
          {{-- @include('front.widget') --}}
        </div>
    </div><!-- end container -->
  </section><!--end white-wrapper -->

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
              <center><h4 class="modal-title">Biodata Alumni</h4></center>
            </div>
            <div class="modal-body" id="inseojs">
              {{-- <div class="form-group">
                  <div style="padding: 10px; 10px; 10px; 10px;">
                    {{ Form::textarea('note', null, array('class' => 'form-control tkh', 'id' => 'note', 'autofocus')) }}
                  </div>
              </div> --}}
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
  </div>
  <meta name="csrf_token" content="{{ csrf_token() }}" />
@endsection

@section('scripts')
  <script>
  $(document).on("click", ".detilinseo", function () {
       var nim = $(this).data('id');
      //  console.log(nim);
      //  $(".modal-body #note").val(nim);
       var request = $.ajax ({
           url : "{{ URL::to('data_alumni_detil') }}",
           beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
           data : "nim="+nim,
           type : "post",
           dataType: "html"
       });

       //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
       $('#inseojs').html("<div class='progress'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width: 40%'><span class='sr-only'>40% Complete (success)</span></div></div>");

       //Jika pencarian selesai
       request.done(function(output) {
           //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
           $('#inseojs').html(output);
       });
  });
  </script>
@stop
