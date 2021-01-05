@if(!array_key_exists("0",$footer))
<footer id="footer-style-1">
    <div class="container">
        @if(array_key_exists("footer_row_1",$footer))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            {!! stripslashes($footer['footer_row_1']) !!}
        </div><!-- end columns -->
        @endif
        @if(array_key_exists("footer_row_2",$footer))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            {!! stripslashes($footer['footer_row_2']) !!}
        </div><!-- end columns -->
        @endif
        @if(array_key_exists("footer_row_3",$footer))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            {!! stripslashes($footer['footer_row_3']) !!}
        </div><!-- end columns -->
        @endif
        @if(array_key_exists("footer_row_4",$footer))
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            {!! stripslashes($footer['footer_row_4']) !!}
        </div><!-- end columns -->
        @endif
    </div><!-- end container -->
</footer>
@endif