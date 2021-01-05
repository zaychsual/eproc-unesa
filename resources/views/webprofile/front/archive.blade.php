@extends('webprofile.layouts.front.master')

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
        <div id="content" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
          <div class="row">
              <div class="blog-masonry">
                  <div class="col-lg-12">
                      <div class="blog-carousel">
                          <div class="">
                              <div class="flexslider">
                                @foreach($data as $value)
                                @if ($title != 'Informasi')
                                <div class="row">
          							        	<div class="headline">
          							          		<h2><a  href="{!! url('post/'.$value->slug) !!}">{!! $value->title !!}</a></h2>
          							        	</div>
							                     <div class="news-text">
            								          <div class="col-lg-4">
                                        <a  href="{!! url('post/'.str_replace(' ', '-', $value->title)) !!}">
                                          @if($value->thumbnail)
                                            <img style="max-width:200px" align="left" class="img-responsive" src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/posts/{!! $value->thumbnail !!}">
                                          @else
                                            <img style="max-width:200px" align="left" class="img-responsive" src="https://www.unesa.ac.id/assets/switcher/images/logo.png">
                                          @endif
                                        </a>
                                      </div>
                                      <strong>{!! InseoHelper::tglbulanindo2($value->post_date) !!}</strong>
                                      {{-- <p>{!! substr(html_entity_decode($value->content),0 , 100) !!}</p> --}}
                                      <p>{!! strip_tags(substr(html_entity_decode($value->content,ENT_COMPAT,"UTF-8"),0 , 250)) !!}</p>
										                  <br>
                                      <a  href="{!! url('post/'.$value->slug) !!}">selengkapnya &raquo;&raquo;</a>
							                      </div>
                                </div>
                                @else
                                <div class="row">
                                      <div class="headline">
                                          <h2><a target="_blank" href="{!! url('info/'.$value->slug) !!}">{!! $value->title !!}</a></h2>
                                      </div>
                                    <div class="news-text">
                                      <strong> {!! InseoHelper::tglbulanindo2($value->event_date) !!}</strong> — 
                                      {!! strip_tags(substr(html_entity_decode($value->content,ENT_COMPAT,"UTF-8"),0 , 250)) !!}
                                    <br><a target="_blank" href="{!! url('info/'.$value->slug) !!}">
                                    Selengkapnya »»</a>
                                    </div>
                                </div>
                                @endif
                                @endforeach
									          </div>
                            <div class="clearfix"></div>
                            <hr>
                            {!! $data->render() !!}
                          </div><!-- end post-slider -->
                      </div><!-- end entry -->
                  </div><!-- end blog-carousel -->
        		  </div><!-- end blog-masonry -->
      	    </div><!-- end widget -->
          </div><!-- end left-sidebar -->
          @include('webprofile.front.widget')
        </div>
    </div><!-- end container -->
  </section><!--end white-wrapper -->
@endsection
