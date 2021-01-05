{!! Html::style("ress/css/theme-white.css", array('id'=>'theme')) !!}

@php
    $reqId = app('request')->input('reqId');
    
    if(empty($reqId)) {
        $url = URL::to('webprofile/rekanans/create');
    }
    else {
        $url = route('rekanans.edit', ['data'=>$reqId]);
    }
    
@endphp

{!! Html::script('ress/js/plugins/jquery/jquery.min.js') !!}

<script type="text/javascript">
    function eClick(varItem){
        $( "a[id*='btnRekanan']" ).removeClass('active');
        if(varItem == 'rekanan'){
            parent.mainFramePop.location.href="{{$url}}";
            $('#btnRekanan').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
        else if(varItem == 'rekanan_ijin_usaha')
        {
            parent.mainFramePop.location.href="{{URL::to('webprofile/ijinusahas')}}";
            $('#btnRekananIjinUsaha').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
        else if(varItem == 'rekanan_akta')
        {
            parent.mainFramePop.location.href="{{URL::to('webprofile/aktas')}}";
            $('#btnRekananAkta').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
        else if(varItem == 'rekanan_pemilik')
        {
            parent.mainFramePop.location.href="{{URL::to('webprofile/pemiliks')}}";
            $('#btnRekananPemilik').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
        else if(varItem == 'rekanan_pengurus')
        {
            parent.mainFramePop.location.href="{{URL::to('webprofile/pengurus')}}";
            $('#btnRekananPengurus').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
        else if(varItem == 'rekanan_tenaga_ahli')
        {
            parent.mainFramePop.location.href="{{URL::to('webprofile/tenagaahlis')}}";
            $('#btnRekananTenagaAhli').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
        else if(varItem == 'rekanan_peralatan')
        {
            parent.mainFramePop.location.href="{{URL::to('webprofile/peralatans')}}";
            $('#btnRekananPeralatan').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
        else if(varItem == 'rekanan_pengalaman')
        {
            parent.mainFramePop.location.href="{{URL::to('webprofile/pengalamans')}}";
            $('#btnRekananPengalaman').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
        else if(varItem == 'rekanan_pajak')
        {
            parent.mainFramePop.location.href="{{URL::to('webprofile/pajaks')}}";
            $('#btnRekananPajak').addClass('active');
            parent.document.getElementById('trdetil').style.display = 'none';
        }
    }
</script>
<!-- START CONTENT FRAME -->
<div class="content-frame">
                    
    <!-- START CONTENT FRAME TOP -->
    <?php
    if($reqId == null || $reqId == ""){ }
    else {
    ?>
        <div class="content-frame-top">                        
            <div class="page-title">                    
                <h3> Frame Title </h3>
            </div>
        </div>
    <?php
    }
    ?>
    <!-- END CONTENT FRAME TOP -->
    
    <!-- START CONTENT FRAME LEFT -->
    <div class="content-frame-left">
        <div class="block">
            <div class="list-group border-bottom">
                {{-- <li class="{{ Request::is('webprofile/rekanans') ? 'active' : '' }}"><a href="{{URL::to('webprofile/rekanans')}}"><span class="fa fa-image"></span> Identitas Perusahaan</a></li>
                <li class="{{ Request::is('webprofile/ijinusahas') ? 'active' : '' }}"><a href="{{URL::to('webprofile/ijinusahas')}}"><span class="fa fa-user"></span> Ijin Usaha</a></li>
                <li class="{{ Request::is('webprofile/aktas') ? 'active' : '' }}"><a href="{{URL::to('webprofile/aktas')}}"><span class="fa fa-users"></span> Akta</a></li>
                <li class="{{ Request::is('webprofile/pemiliks') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pemiliks')}}"><span class="fa fa-comments"></span> Pemilik</a></li>
                <li class="{{ Request::is('webprofile/pengurus') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pengurus')}}"><span class="fa fa-calendar"></span> Pengurus</a></li>
                <li class="{{ Request::is('webprofile/tenagaahlis') ? 'active' : '' }}"><a href="{{URL::to('webprofile/tenagaahlis')}}"><span class="fa fa-users"></span> Tenaga Ahli</a></li>                                 
                <li class="{{ Request::is('webprofile/peralatans') ? 'active' : '' }}"><a href="{{URL::to('webprofile/peralatans')}}"><span class="fa fa-edit"></span> Peralatan</a></li>
                <li class="{{ Request::is('webprofile/pengalamans') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pengalamans')}}"><span class="fa fa-columns"></span> Pengalaman</a></li>
                <li class="{{ Request::is('webprofile/pajaks') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pajaks')}}"><span class="fa fa-question-circle"></span> Pajak</a></li> --}}
                
                    <a onclick="eClick('rekanan');" href="#" class="list-group-item active" id="btnRekanan"><span class="fa fa-image"></span> Identitas Perusahaan </a>
                
                <?php
                if($reqId == null || $reqId == ""){ }
                else {
                ?>
                    <a onclick="eClick('rekanan_ijin_usaha');" href="#" class="list-group-item " id="btnRekananIjinUsaha"><span class="fa fa-user"></span> Ijin Usaha </a>
                    <a onclick="eClick('rekanan_akta');" href="#" class="list-group-item " id="btnRekananAkta"><span class="fa fa-users"></span> Akta </a>
                    <a onclick="eClick('rekanan_pemilik');" href="#" class="list-group-item " id="btnRekananPemilik"><span class="fa fa-comments"></span> Pemilik </a>
                    <a onclick="eClick('rekanan_pengurus');" href="#" class="list-group-item " id="btnRekananPengurus"><span class="fa fa-calendar"></span> Pengurus </a>                            
                    <a onclick="eClick('rekanan_tenaga_ahli');" href="#" class="list-group-item " id="btnRekananTenagaAhli"><span class="fa fa-users"></span> Tenaga Ahli </a>                            
                    <a onclick="eClick('rekanan_peralatan');" href="#" class="list-group-item " id="btnRekananPeralatan"><span class="fa fa-edit"></span> Peralatan </a>                            
                    <a onclick="eClick('rekanan_pengalaman');" href="#" class="list-group-item " id="btnRekananPengalaman"><span class="fa fa-columns"></span> Pengalaman </a>                            
                    <a onclick="eClick('rekanan_pajak');" href="#" class="list-group-item " id="btnRekananPajak"><span class="fa fa-question-circle"></span> Pajak </a>                            
                <?php
                }
                ?>
            </div>                        
        </div>
    </div>
    <!-- END CONTENT FRAME LEFT -->
    
    <!-- START CONTENT FRAME BODY -->
    {{-- <div class="content-frame-body">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3>Responsive Body</h3>
                This is responsive frame body. Can be used for all elements of template.
            </div>
        </div>
    </div> --}}
    <!-- END CONTENT FRAME BODY -->
</div>
<!-- END CONTENT FRAME -->