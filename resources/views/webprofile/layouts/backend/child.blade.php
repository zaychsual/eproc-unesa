<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <meta name="description" content="Profile Alumni Unesa">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />


        <style>
            .x-r li > a:hover {
    background: yellow;
    color: #fff;
    transition: all 200ms ease;
</style>

        <title>@yield('title') | {{Session::get('ss_setting')['web_title']}}</title>

        {!! Html::style("https://statik.unesa.ac.id/digilib_konten_statik/images/favicon.png", array('type'=>'image/x-icon', 'rel'=>'shortcut icon')) !!}
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        {!! Html::style("ress/css/theme-white.css", array('id'=>'theme')) !!}
        <link rel="stylesheet" href="{{URL::to('https://statik.unesa.ac.id/cv_konten_statik/sw/dist/sweetalert.css')}}">
        <!-- EOF CSS INCLUDE -->
        @yield('assets')
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top-fixed" >

            <!-- PAGE CONTENT -->
            <div class="page-content" style="padding-top: 10px; margin-left: 0px;">

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
                <!-- END PAGE CONTENT WRAPPER -->
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
                        <p>Apakah Anda yakin ingin keluar dari halaman admin?</p>
                        <p>Pilih Batal jika Anda tidak ingin meninggalkan halaman admin. Pilih Keluar untuk keluar halaman admin.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();" class="btn btn-success btn-lg">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <button class="btn btn-default btn-lg mb-control-close">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{URL::to('https://statik.unesa.ac.id/profileunesa_konten_statik/admin/audio/alert.mp3')}}" preload="auto"></audio>
        <audio id="audio-fail" src="{{URL::to('https://statik.unesa.ac.id/profileunesa_konten_statik/admin/audio/fail.mp3')}}" preload="auto"></audio>
        <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        {!! Html::script('ress/js/plugins/jquery/jquery.min.js') !!}
        {!! Html::script('ress/js/plugins/jquery/jquery-ui.min.js') !!}
        {!! Html::script('ress/js/plugins/bootstrap/bootstrap.min.js') !!}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="{{ asset('ress/js/plugins/bootstrap/bootstrap-select.js') }}"></script>
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        {!! Html::script('ress/js/plugins/icheck/icheck.min.js') !!}
        {!! Html::script('ress/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') !!}
        @yield('script')
        <!-- END THIS PAGE PLUGINS-->
        
        {!! Html::script('ress/js/plugins.js') !!}
        {!! Html::script('ress/js/actions.js') !!}
        <script src="{{URL::to('https://statik.unesa.ac.id/cv_konten_statik/sw/dist/sweetalert.min.js')}}"></script>
        @include('sweet::alert')
        @yield('scriptbottom')
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
        {!! Html::script('js/eModal.js') !!}
        <script>
            function openPopup(linkUrl) {
                //alert("cek emodal");
                eModal.iframe(linkUrl, 'Vendor Management System')
            }

            function closePopup() {
                eModal.close();
            }
        </script>
    </body>
</html>
