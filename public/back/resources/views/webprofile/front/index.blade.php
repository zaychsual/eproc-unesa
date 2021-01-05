@extends('webprofile.layouts.front.master')

@section('slider')
  <section class="slider-wrapper">
      <div class="tp-banner-container">
          <div class="tp-banner" >
            <ul><!-- SLIDE  -->
              @foreach($slider as $value)
              <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                  <img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/slider/{!! $value->images !!}"  alt="{!! $value->title !!}" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
              </li>
              @endforeach
            </ul>
            <div class="tp-bannertimer"></div>
          </div>
      </div>
  </section><!-- end slider-wrapper -->
@endsection

@section('content')
  

    {{-- Label Body Tambahan --}}
    @if ($body->count() != 0)
    <section class="white-wrapper">
        @foreach ($body as $value)
        <div class="container">
            <div class="general-title">
                <h2>{!! $value->title_design !!}</h2>
                <p class="lead">{!! $value->value_design !!}</p>
            </div>
        </div>
        <!-- end container -->
        
        @endforeach
        <div class="clearfix"></div>
    </section>
    @endif

    {{-- Label Gallery --}}
    @if ($gallery->count() != 0)
    <section class="panel-wrapper jt-shadow">
        <div class="container">
            <div class="general-title">
                <h2>Galeri</h2>
                <hr>
            </div>
        </div>
        <!-- end container -->
        <div class="portfolio_wrapper padding-top" style="position: relative; overflow: hidden; height: 372px;">
          <div class="portfolio_item" style="position: absolute; left: 0px; top: 0px; transform: translate(0px, 30px); width: 379px;">
            <div class="entry">
              <img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!! $gallery[0]->images !!}" alt="" class="img-responsive">
              <div class="magnifier">
                <div class="buttons">
                  <a class="st btn btn-default" rel="bookmark" href="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!! $gallery[0]->images !!}" target="_blank">
                    View
                  </a>
                  <h3>{!! $gallery[0]->title !!}</h3>
                </div><!-- end buttons -->
              </div><!-- end magnifier -->
            </div><!-- end entry -->
          </div><!-- end portfolio_item -->
          <div class="portfolio_item" style="position: absolute; left: 0px; top: 0px; transform: translate(379px, 30px); width: 379px;">
            <div class="entry">
              <img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!! $gallery[1]->images !!}" alt="" class="img-responsive">
              <div class="magnifier">
                <div class="buttons">
                  <a class="st btn btn-default" rel="bookmark" href="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!! $gallery[1]->images !!}" target="_blank">
                    View
                  </a>
                  <h3>{!! $gallery[1]->title !!}</h3>
                </div><!-- end buttons -->
              </div><!-- end magnifier -->
            </div><!-- end entry -->
          </div><!-- end portfolio_item -->
          <div class="portfolio_item" style="position: absolute; left: 0px; top: 0px; transform: translate(758px, 30px); width: 379px;">
            <div class="entry">
              <img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!! $gallery[2]->images !!}" alt="" class="img-responsive">
              <div class="magnifier">
                <div class="buttons">
                  <a class="st btn btn-default" rel="bookmark" href="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!! $gallery[2]->images !!}" target="_blank">
                    View
                  </a>
                  <h3>{!! $gallery[2]->title !!}</h3>
                </div><!-- end buttons -->
              </div><!-- end magnifier -->
            </div><!-- end entry -->
          </div><!-- end portfolio_item -->
          <div class="portfolio_item" style="position: absolute; left: 0px; top: 0px; transform: translate(1137px, 30px); width: 379px;">
            <div class="entry">
              <img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!! $gallery[3]->images !!}" alt="" class="img-responsive">
              <div class="magnifier">
                <div class="buttons">
                  <a class="st btn btn-default" rel="bookmark" href="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/gallery/{!! $gallery[3]->images !!}" target="_blank">
                    View
                  </a>
                  <h3>{!! $gallery[3]->title !!}</h3>
                </div><!-- end buttons -->
              </div><!-- end magnifier -->
            </div><!-- end entry -->
          </div><!-- end portfolio_item -->
        </div>
        <div class="clearfix"></div>
    </section>
    @endif

    <section class="grey-wrapper jt-shadow">
    <div class="container">
        <div id="content" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="title">
                <h2>Berita Terbaru
                  <div style="font-size:12px; float:right"><a href="{!! url('archive') !!}" class="btn btn-box"><i class="fa fa-chevron-circle-right"></i> lihat berita selengkapnya</a></div>
                </h2>
              </div><!-- end title -->

              <div class="row">
                 <div class="blog-masonry">
                    <?php $e=1; ?>
                    @foreach($news as $value)
                      <div class="col-lg-6 @if($e%2 != 0) first @else last @endif">
                          <div class="blog-carousel">
                              <div class="entry">
                                  @if($value->thumbnail)
                                  <center><img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/posts/{!! $value->thumbnail !!}" alt="" class="img-responsive" style="height: 150px; width: auto;"></center>
                                  @endif
                              </div>
                              <div class="blog-carousel-header">
                                  <h3><a title="{!! $value->title !!}" href="{!! url('post/'.$value->slug) !!}">{!! $value->title !!}</a></h3>
                                  <div class="blog-carousel-meta">
                                      <span><i class="fa fa-calendar"></i> {!! InseoHelper::tglbulanindo2($value->post_date) !!}</span>
                                      @if($value->comment_status)
                                      <span><i class="fa fa-comment"></i> <a href="#">{!! $value->comment_count !!} Comments</a></span>
                                      @endif
                                      <span><i class="fa fa-eye"></i> <a href="#">{!! $value->viewer !!} Views</a></span>
                                  </div><!-- end blog-carousel-meta -->
                              </div><!-- end blog-carousel-header -->
                              <div class="blog-carousel-desc">
                                  {{-- <p>{!! substr(html_entity_decode($value->content),0 , 250) !!}</p> --}}
                                  <p>{!! strip_tags(substr(html_entity_decode($value->content,ENT_COMPAT,"UTF-8"),0 , 250)) !!}</p>
                                  {{-- <p>{!! $value->content !!}</p> --}}
                              </div><!-- end blog-carousel-desc -->
                          </div><!-- end blog-carousel -->
                      </div><!-- end col-lg-4 -->
                      <?php $e++; ?>
                    @endforeach
                  </div><!-- end blog-masonry -->

                  <div class="clearfix"></div>

                  <hr>

                  <div class="pagination_wrapper">
                      <!-- Pagination Normal -->
                      <ul class="pagination">
                          {!! $news->render() !!}
                      </ul>
                  </div><!-- end pagination_wrapper -->

            </div><!-- end row -->
        </div><!-- end content -->

        {{-- <div id="content" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="title">
                <h2>IKA UNESA
                  <div style="font-size:12px; float:right"><a href="http://ika.unesa.ac.id" target="_blank" class="btn btn-box"><i class="fa fa-chevron-circle-right"></i> lihat berita selengkapnya</a></div>
                </h2>
              </div><!-- end title -->

              <div class="row">
                 <div class="blog-masonry">
                    @foreach ($ika['items'] as $item)
                      <div class="col-lg-6 last">
                          <div class="blog-carousel">
                              <div class="blog-carousel-header">
                                  <h3><a title="{{ $item->get_title() }}" href="{{ $item->get_permalink() }}" target="_blank">{{ $item->get_title() }}</a></h3>
                                  <div class="blog-carousel-meta">
                                      <span><i class="fa fa-calendar"></i> Posted on {{ $item->get_date('j F Y | g:i a') }}</span>
                                  </div><!-- end blog-carousel-meta -->
                              </div><!-- end blog-carousel-header -->
                              <div class="blog-carousel-desc">
                                  <p>{!! strip_tags(substr(html_entity_decode($item->get_description(),ENT_COMPAT,"UTF-8"),0 , 250)) !!}</p>
                              </div><!-- end blog-carousel-desc -->
                          </div><!-- end blog-carousel -->
                      </div><!-- end col-lg-4 -->
                    @endforeach
                  </div><!-- end blog-masonry -->

                  <div class="clearfix"></div>

                  <hr>

                  <div class="pagination_wrapper">
                      <!-- Pagination Normal -->
                      <ul class="pagination">
                          {!! $news->render() !!}
                      </ul>
                  </div><!-- end pagination_wrapper -->

            </div><!-- end row -->
        </div><!-- end content --> --}}

        <div id="sidebar" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="widget">
              <div class="title">
                <h2>AGENDA</h2>
              </div><!-- end title -->
              <ul class="recent_posts_widget">
                  @foreach($info as $value)
                  <li>
                    <a href="{!! url('info/'.$value->slug) !!}"><img src="https://www.unesa.ac.id/assets/demos/logounesa.png" alt="">{!! $value->title !!}</a>
                    <a class="readmore" href="#">{!! InseoHelper::tglbulanindo2($value->event_date) !!}</a>
                  </li>
                  {{-- <div class="">
                    <div class="event-date"> {!! InseoHelper::tglbulanindo2($value->created_at) !!} </div>
                    <div class="event-text">
                      <h4><a href="{!! url('info/'.$value->slug) !!}" class="su-link" data-ua-action="hp-event" data-ua-label="id ">{!! $value->title !!}</a></h4>
                      <p></p>
                    </div>
                  </div> --}}
                  @endforeach
              </ul>
              <a href="{!! url('agenda') !!}" class="btn btn-primary">Lihat Agenda Selengkapnya</a>
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
                              <a href="{!! url('post/'.$value->slug) !!}">@if($value->thumbnail)<img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/posts/{!! $value->thumbnail !!}" alt="" />@endif{!! $value->title !!}</a>
                              <a class="readmore" href="{!! url('post/'.$value->slug) !!}">{!! InseoHelper::tglbulanindo2($value->post_date) !!}</a>
                            </li>
                            @endforeach
                        </ul><!-- recent posts -->
                    </div>
                    <div class="tab-pane" id="new">
                        <ul class="recent_posts_widget">
                          @foreach($hot as $value)
                          <li>
                            <a href="{!! url('post/'.$value->slug) !!}">@if($value->thumbnail)<img src="https://statik.unesa.ac.id/profileunesa_konten_statik/uploads/{!! Session::get('ss_setting')['statik_konten'] !!}/posts/{!! $value->thumbnail !!}" alt="" />@endif{!! $value->title !!}</a>
                            <a class="readmore" href="{!! url('post/'.$value->slug) !!}">{!! InseoHelper::tglbulanindo2($value->post_date) !!}</a>
                          </li>
                          @endforeach
                        </ul><!-- recent posts -->
                    </div>
                </div><!-- end tab content -->
              </div><!-- end tab pane -->
            </div><!-- end widget -->

            @foreach ($widget_right as $vwidget_right)
            <div class="widget">
              <div class="title">
                    <h2>{!! $vwidget_right->title_design !!}</h2>
                </div><!-- end title -->
                {!! $vwidget_right->value_design !!}
            </div><!-- end widget --> 
            @endforeach
          </div><!-- end content -->
    </div><!-- end container -->
  </section><!--end white-wrapper -->

    <section class="white-wrapper">
        
            <div class="container">
                <div class="testimonial-widget">
                    <div id="owl-testimonial" class="owl-carousel">
                        @foreach ($quote as $value)
                            <div class="testimonial">
                                <p class="lead">
                                {!! $value->value_design !!}</p>
                                <h3>{!! $value->title_design !!}</h3>
                            </div>
                        @endforeach
                    </div><!-- end testimonial widget -->             
                </div><!-- end container -->
          </div><!-- end overlay -->
        
    </section><!-- end transparent-bg -->

    <section class="make-bg-full">
        <div class="calloutbox-full-mini nocontainer">
          <div class="long-twitter">
        <p class="lead"><i class="fa fa-twitter"></i> Vendor Management System <b>(VMS)</b></p>
            </div>
        </div><!-- end calloutbox -->
    </section><!-- make bg -->

    
@endsection