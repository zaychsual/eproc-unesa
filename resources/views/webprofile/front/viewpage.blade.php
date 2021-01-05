@extends('webprofile.layouts.front.master')

@section('content')
  <section class="post-wrapper-top jt-shadow clearfix">
    <div class="container">
      <div class="col-lg-12">
          <h2>{!! $data->title !!}</h2>
          {{-- <ul class="breadcrumb pull-right">
              <a href="/"> Home</a>
              <i class="fa fa-chevron-circle-right"></i>
              <a href="/page/tentang-unesa">Tentang Unesa</a>
              <i class="fa fa-chevron-circle-right"></i>
              <a href="/page/tentang-unesa/selayang-pandang">Selayang Pandang</a>
          </ul> --}}
      </div>
    </div>
  </section><!-- end post-wrapper-top -->

  <section class="blog-wrapper">
    <div class="container">
        <div class="row">
          <div id="main-content" class="col-md-12" role="main" align="justify">
            {!! $data->content !!}
          </div>
        </div>
      </div><!-- end title -->
    </div><!-- end container -->
  </section><!--end white-wrapper -->

@endsection
