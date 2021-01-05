<!DOCTYPE html>
<html lang="en">
<head>

  <meta http-equiv="content-type" content="text/html; charset=UTF-8">

  <title>{{Session::get('ss_setting')['web_title']}}</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">

  <!-- Bootstrap Styles -->
  <link href="{{URL::to('ress/front/css/bootstrap.css')}}" rel="stylesheet">
  
<!--   <style media="screen">
    a.navbar-brand {
      background: url({!! Session::get('ss_setting')['logo'] !!}) no-repeat scroll left top rgba(0, 0, 0, 0);
    }

    a {
        color: #428bca;
        text-decoration: none;
        background: transparent;
    }

    a:link {
    text-decoration: none;
    }

    a:visited {
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    a:active {
        text-decoration: underline;
    }
  </style> -->

   <!-- Styles -->
  <link rel="stylesheet" type="text/css" href="{{URL::to('ress/front/css/style.css ')}}" />

  <!-- Flex Slider -->
  <link href="{{URL::to('ress/front/css/flexslider.css')}}" rel="stylesheet">

  <!-- Carousel Slider -->
  <link href="{{URL::to('ress/front/css/owl-carousel.css')}}" rel="stylesheet">

  <!-- CSS Animations -->
  <link href="{{URL::to('ress/front/css/animate.min.css')}}" rel="stylesheet">
  <link href="{{URL::to('ress/front/css/prettyPhoto.css')}}" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="{{URL::to('css/family.css')}}" rel='stylesheet' type='text/css'>
  <link href="{{URL::to('css/family_.css')}}" rel='stylesheet' type='text/css'>
  <link href="{{URL::to('css/family__.css')}}" rel='stylesheet' type='text/css'>

  <!-- SLIDER ROYAL CSS SETTINGS -->
  <link href="{{URL::to('ress/front/royalslider/royalslider.css')}}" rel="stylesheet">
  <link href="{{URL::to('ress/front/royalslider/skins/default-inverted/rs-default-inverted.css')}}" rel="stylesheet">

  <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
  <link rel="stylesheet" type="text/css" href="{{URL::to('ress/front/rs-plugin/css/settings.css')}}" media="screen" />

  <!-- Demo Examples -->
  <link rel="stylesheet" type="text/css" href="{{URL::to('ress/front/switcher/css/tael.css')}}" title="green" media="all" />
  @yield('assets')
</head>
<body>
  <div id="topbar" class="clearfix">
    <div class="container">
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="social-icons">
              <span><a data-toggle="tooltip" data-placement="bottom" title="Facebook" href="#"><i class="fa fa-facebook"></i></a></span>
              <span><a data-toggle="tooltip" data-placement="bottom" title="Google Plus" href="#"><i class="fa fa-google-plus"></i></a></span>
              <span><a data-toggle="tooltip" data-placement="bottom" title="Twitter" href="#"><i class="fa fa-twitter"></i></a></span>
              <span><a data-toggle="tooltip" data-placement="bottom" title="Youtube" href="#"><i class="fa fa-youtube"></i></a></span>
              <span><a data-toggle="tooltip" data-placement="bottom" title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a></span>
          </div><!-- end social icons -->
      </div><!-- end columns -->
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <div class="topmenu">
              <span class="topbar-login"><i class="fa fa-user"></i> <a href="{!! url('/eproc-login') !!}">login</a></span>
              <span class="topbar-cart"><i class="fa fa-globe"></i> <a href="https://www.unesa.ac.id" target="_blank">www.unesa.ac.id</a></span>
          </div><!-- end top menu -->
        <div class="callus">
            <span class="topbar-email"><i class="fa fa-envelope"></i> <a href="mailto:{!! Session::get('ss_setting')['email'] !!}">{!! Session::get('ss_setting')['email'] !!}</a></span>
          </div><!-- end callus -->
      </div><!-- end columns -->
    </div><!-- end container -->
  </div><!-- end topbar -->

  <header id="header-style-1">
    <div class="container">
      <nav class="navbar yamm navbar-default">
        <div class="navbar-header">
          <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a href="{!! url('/') !!}" class="navbar-brand">E-proc</a>
        </div><!-- end navbar-header -->

        <div id="navbar-collapse-1" class="navbar-collapse collapse navbar-right">
          <ul class="nav navbar-nav">
            @include('webprofile.layouts.front.menu')
          </ul><!-- end navbar-nav -->
        </div><!-- #navbar-collapse-1 -->
      </nav><!-- end navbar yamm navbar-default -->
    </div><!-- end container -->
  </header><!-- end header-style-1 -->

  @yield('slider')

  @yield('content')

  {{-- @yield('footer') --}}
  @include('webprofile.front.footer')

  <div id="copyrights">
    <div class="container">
     <div id="global-footer" style="text-align:center; line-height:15px"><br>
        <a href="/"><img src="{{URL::to('ress/front/images/unesa-bawah.png')}}" alt="Surabaya State University" width="105" height="49"><br>Copyright © {!! Date('Y') !!} {{Session::get('ss_setting')['web_title']}}. Supported By PPTI Universitas Negeri Surabaya</a>
     </div>
    </div><!-- end container -->
  </div>

  <div class="dmtop">Scroll to Top</div>

  <!-- Main Scripts-->
  <script src="{{URL::to('ress/front/js/jquery.js')}}"></script>
  <script src="{{URL::to('ress/front/js/bootstrap.min.js')}}"></script>
  <script src="{{URL::to('ress/front/js/menu.js')}}"></script>
  <script src="{{URL::to('ress/front/js/owl.carousel.min.js')}}"></script>
  <script src="{{URL::to('ress/front/js/jquery.parallax-1.1.3.js')}}"></script>
  <script src="{{URL::to('ress/front/js/jquery.simple-text-rotator.js')}}"></script>
  <script src="{{URL::to('ress/front/js/wow.min.js')}}"></script>
  <script src="{{URL::to('ress/front/js/jquery.fitvids.js')}}"></script>
  <script src="{{URL::to('ress/front/js/custom.js')}}"></script>

  <script src="{{URL::to('ress/front/js/jquery.isotope.min.js')}}"></script>
  <script src="{{URL::to('ress/front/js/custom-portfolio.js')}}"></script>

  <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
  <script type="text/javascript" src="{{URL::to('ress/front/rs-plugin/js/jquery.themepunch.plugins.min.js')}}"></script>
  <script type="text/javascript" src="{{URL::to('ress/front/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
  @yield('scripts')
  <script src="{{URL::to('js/prettyPhoto.js')}}"></script>
  <script type="text/javascript">
  (function($) {
      "use strict";
      jQuery('a[data-gal]').each(function() {
        jQuery(this).attr('rel', jQuery(this).data('gal'));
      });   
      jQuery("a[data-gal^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',slideshow:false,overlay_gallery: false,theme:'light_square',social_tools:false,deeplinking:false});
  })(jQuery);
  </script>
  <script type="text/javascript">
  var revapi;
  jQuery(document).ready(function() {
    revapi = jQuery('.tp-banner').revolution(
    {
      delay:9000,
      startwidth:1686,
      startheight:500,
      hideThumbs:10,
      fullWidth:"on",
      forceFullWidth:"on"
    });
  }); //ready
  </script>

  <script>
  (function($) {
    "use strict";
    $(document).ready(function(){
    // Target your .container, .wrapper, .post, etc.
    $("body").fitVids();
    });
  })(jQuery);
  </script>

  <script src="{{URL::to('ress/front/js/jquery.flexslider.js')}}"></script>
  <script type="text/javascript">
  (function($) {
    "use strict";
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "fade",
        controlNav: false,
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  })(jQuery);
  </script>

  <!-- Demo Switcher JS -->
  <script type="text/javascript" src="{{URL::to('ress/front/switcher/js/fswit.js')}}"></script>
  <script src="{{URL::to('ress/front/switcher/js/bootstrap-select.js')}}"></script>

</body>
</html>
