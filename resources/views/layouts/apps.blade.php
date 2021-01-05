<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="body-full-height">
<head>        
        <!-- META SECTION -->
        <title>{{ config('app.name', 'Eproc Unesa') }}</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('ress/css/theme-default.css') }}"/>
        <!-- EOF CSS INCLUDE -->                             
    </head>
    <body>
        
        @yield('content')

        <script src="{{URL::to('ress/js/ajax.js')}}"></script>
        <script>
            $('.btn-refresh').click(function(){
                $.ajax({
                    type: 'GET',
                    url: '{{ url('refresh_captcha') }}',
                    success: function(data) {
                        $('.captcha span').html(data);
                    }
                });
            });
        </script>
        
    </body>

</html>






