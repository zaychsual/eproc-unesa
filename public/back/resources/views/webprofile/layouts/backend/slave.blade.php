<!DOCTYPE html>
<html lang="en">
<head>        
        <!-- META SECTION -->
        <title>@yield('title') | {{Session::get('ss_setting')['web_title']}}</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="{{ asset('ress/favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('ress/css/theme-default.css') }}"/>

        <link rel="stylesheet" href="{{ asset('ress/dist/sweetalert.css') }}">
        <!-- EOF CSS INCLUDE -->  
        @yield('assets')                                    
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal">
                    <li class="xn-logo">
                        <a href="#">{{Session::get('ss_setting')['header_admin']}}</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>                                   
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    @yield('breadcrumbs')
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    @yield('pagetitle')
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <!-- <div class="row">
                        <div class="col-md-12"> -->
                            @include('webprofile.layouts.backend.partials.alert')
                            @include('webprofile.layouts.backend.partials.validation')
                            @yield('content')
                        <!-- </div>
                    </div> -->


                </div>
                <!-- PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();" class="btn btn-success btn-lg">
                                Yes
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{ asset('ress/audio/alert.mp3') }}" preload="auto"></audio>
        <audio id="audio-fail" src="{{ asset('ress/audio/fail.mp3') }}" preload="auto"></audio>
        <!-- END PRELOADS -->               

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{ asset('ress/js/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('ress/js/plugins/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('ress/js/plugins/bootstrap/bootstrap.min.js') }}"></script>        
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src="{{ asset('ress/js/plugins/icheck/icheck.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('ress/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="{{ asset('ress/js/plugins/bootstrap/bootstrap-select.js') }}"></script>
        <!-- END PAGE PLUGINS -->       

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="{{ asset('ress/js/settings.js') }}"></script>

        @yield('script')
        
        <script type="text/javascript" src="{{ asset('ress/js/plugins.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('ress/js/actions.js') }}"></script>        
        <!-- END TEMPLATE -->

        <!-- END THIS PAGE PLUGINS-->
        <script type="text/javascript" src="{{ asset('ress/dist/sweetalert.min.js') }}"></script>
        @include('sweet::alert')
        @yield('scriptbottom')
    <!-- END SCRIPTS -->         
    </body>
</html>