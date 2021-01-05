@extends('webprofile.layouts.front.master')

@section('content')
  <section class="post-wrapper-top jt-shadow clearfix">
    <div class="container">
      <div class="col-lg-12">
          <h2>Agenda - {!! $data->title !!}</h2>
      </div>
    </div>
  </section><!-- end post-wrapper-top -->

  <section class="blog-wrapper">
    <div class="container">
        <div class="row">
          <div id="main-content" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="row">
              <div class="blog-masonry">
                <div class="col-lg-12">
                  <div class="blog-carousel">
                    <div class="blog-carousel-header">
                      <h1>{!! $data->title !!}</h1>
                      <div class="blog-carousel-meta">
                          <span><i class="fa fa-eye"></i> <a href="#">{!! $data->viewer !!} Views</a></span>
                          {{-- <span><i class="fa fa-user"></i> <a href="#">Redaksi</a></span> --}}
                      </div><!-- end blog-carousel-meta -->
                    </div><!-- end blog-carousel-header -->
                    <div class="blog-carousel-desc">
                      {!! $data->content !!}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @include('webprofile.front.widget')
        </div>
    </div><!-- end container -->
  </section><!--end white-wrapper -->

@endsection
