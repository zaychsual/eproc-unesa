@extends('layouts.profile.master')

@section('assets')
	<link rel="stylesheet" href="{{URL::to('https://statik.unesa.ac.id/cv_konten_statik/sw/dist/sweetalert.css')}}">
@endsection

@section('content')
  <section class="post-wrapper-top jt-shadow clearfix">
    <div class="container">
      <div class="col-lg-12">
          <h2>Usulan Buku</h2>
      </div>
    </div>
  </section><!-- end post-wrapper-top -->

  <section class="blog-wrapper">
    <div class="container">
        <div class="row">
          <div id="main-content" class="col-md-8">
						<div class="doc">
            	<h3>Basic Example</h3>
                {!! Form::open(array('url' => route('usulan.store'), 'method' => 'POST')) !!}
                  <div class="form-group">
										<label for="nama">Nama <span class="required" style="color: red;">*</span></label>
						        {{ Form::text('nama', null, array('size'=>'20', 'aria-required'=>'true', 'required', 'class'=>'form-control')) }}
                  </div>
                  <div class="form-group">
										<label for="nim">NIM/NIP <span class="required" style="color: red;">*</span></label>
						        {{ Form::text('nim', null, array('size'=>'20', 'aria-required'=>'true', 'required', 'class'=>'form-control')) }}
                  </div>
                  <div class="form-group">
										<label for="judul">Judul Buku <span class="required" style="color: red;">*</span></label>
						        {{ Form::text('judul', null, array('size'=>'20', 'aria-required'=>'true', 'required', 'class'=>'form-control')) }}
                  </div>
                  <div class="form-group">
										<label for="pengarang">Pengarang</label>
						        {{ Form::text('pengarang', null, array('size'=>'20', 'aria-required'=>'true', 'class'=>'form-control')) }}
                  </div>
                  <div class="form-group">
										<label for="penerbit">Penerbit</label>
						        {{ Form::text('penerbit', null, array('size'=>'20', 'aria-required'=>'true', 'class'=>'form-control')) }}
                  </div>
                  <div class="form-group">
										<label for="alasan">Alasan Pengajuan Buku <span class="required" style="color: red;">*</span></label>
						        {{ Form::textarea('alasan', null, array('cols'=>'45', 'rows'=>'3', 'style'=>'resize:none;', 'aria-required'=>'true', 'required', 'class'=>'form-control')) }}
                  </div>
									{!! Recaptcha::render() !!}
									<br>
                  <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
          </div>
					<div id="sidebar" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
          	<div class="widget">
            	<div class="title">
                <h2>INFO & PENGUMUMAN</h2>
              </div><!-- end title -->
              @foreach($info as $value)
              <div class="">
                <div class="event-date"> {!! InseoHelper::tglbulanindo2($value->created_at) !!} </div>
                <div class="event-text">
                  <h4><a href="#" class="su-link" data-ua-action="hp-event" data-ua-label="id ">{!! $value->title !!}</a></h4>
                  <p></p>
                </div>
              </div>
              @endforeach
            </div><!-- end widget -->

          	<div class="widget">
              <div id="tabbed_widget" class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent" data-toggle="tab">Terbaru</a></li>
                    <li><a href="#new" data-toggle="tab">Populer</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="recent">
                        <ul class="recent_posts_widget">
                            @foreach($resend as $value)
                            <li>
                              <a href="#"><img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/posts/{!! $value->thumbnail !!}" alt="" />{!! $value->title !!}</a>
                              <a class="readmore" href="#">{!! InseoHelper::tglbulanindo2($value->post_date) !!}</a>
                            </li>
                            @endforeach
                        </ul><!-- recent posts -->
                    </div>
                    <div class="tab-pane" id="new">
                        <ul class="recent_posts_widget">
                          @foreach($hot as $value)
                          <li>
                            <a href="#"><img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/posts/{!! $value->thumbnail !!}" alt="" />{!! $value->title !!}</a>
                            <a class="readmore" href="#">{!! InseoHelper::tglbulanindo2($value->post_date) !!}</a>
                          </li>
                          @endforeach
                        </ul><!-- recent posts -->
                    </div>
                </div><!-- end tab content -->
              </div><!-- end tab pane -->
            </div><!-- end widget -->
          </div><!-- end content -->
        </div>
      </div><!-- end title -->
    </div><!-- end container -->
  </section><!--end white-wrapper -->
@endsection

@section('scripts')
	<script src="{{URL::to('https://statik.unesa.ac.id/cv_konten_statik/sw/dist/sweetalert.min.js')}}"></script>
	@include('sweet::alert')
@endsection
