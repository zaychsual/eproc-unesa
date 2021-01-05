{{-- @include('webprofile.layouts.backend.child') --}}
@php
    if(empty($data['id'])) {
        $url = URL::to('webprofile/rekanans/create');
        $reqId = "";
    }
    else {
        $url = route('rekanans.edit', ['data'=>$data['id']]);
        $reqId = $data['id'];
        session(['mt_rekanan_id' => $data['id']]);
    }
@endphp
<script type="text/javascript">
    function loadFrameIjinUsaha(){
        this.frames["mainFramePop"].location.href="{{URL::to('webprofile/ijinusahas')}}";
    }
    function loadFrameAkta(){
        this.frames["mainFramePop"].location.href="{{URL::to('webprofile/aktas')}}";
    }
    function loadFramePemilik(){
        this.frames["mainFramePop"].location.href="{{URL::to('webprofile/pemiliks')}}";
    }
    function loadFramePengurus(){
        this.frames["mainFramePop"].location.href="{{URL::to('webprofile/pengurus')}}";
    }
    function loadFrameTenagaAhli(){
        this.frames["mainFramePop"].location.href="{{URL::to('webprofile/tenagaahlis')}}";
    }
    function loadFramePeralatan(){
        this.frames["mainFramePop"].location.href="{{URL::to('webprofile/peralatans')}}";
    }
    function loadFramePengalaman(){
        this.frames["mainFramePop"].location.href="{{URL::to('webprofile/pengalamans')}}";
    }
    function loadFramePajak(){
        this.frames["mainFramePop"].location.href="{{URL::to('webprofile/pajaks')}}";
    }
</script>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" height="100%" style="overflow:hidden;">
        <tr> 
            <td height="100%" valign="top" class="menu" width="1"> 
                    <table width="242" border="0" cellpadding="0" cellspacing="0" height="100%" id="menuFrame">
                    <tr> 
                            <td height="100%"></td>
                            <td valign="top">
                            
                        <!-- MENU -->
                            <iframe src="{{URL::to('webprofile/rekanansmenu/?reqId='.$reqId)}}" name="menuFramePop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe>		  
                            </td>
                    </tr>
                    </table>
            </td>
            <td width="3" class="bg-td-show-hide">
                <!-- <a href="javascript:displayElement('menuFrame')"><img src="images/btn_display_element.gif" title="Buka/Tutup Menu" border="0"></a> -->
            </td>
            <td valign="top" height="100%" width="100%">
                <table cellpadding="0" cellspacing="0"  width="100%" height="100%">
                    <tr height="50%">
                        <td><iframe src="{{$url}}" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe></td>
                    </tr>
                    <tr height="50%" id="trdetil" style="display:none">
                        <td><iframe src="" class="mainframe" id="idMainFrameDetil" name="mainFrameDetilPop" width="100%" height="100%" scrolling="no" frameborder="0"></iframe></td>
                    </tr>
                </table>			
            </td>
        </tr>
    </table>
</body>

{{-- UNTUK IFRAME CHILD --}}
{!! Html::style("ress/css/theme-white.css", array('id'=>'theme')) !!}
{!! Html::script('ress/js/plugins/jquery/jquery.min.js') !!}
{!! Html::script('ress/js/plugins/bootstrap/bootstrap.min.js') !!}
{!! Html::script('js/eModal.js') !!}
<script>
    function openPopup(linkUrl) {
        // alert("cek emodal");
        eModal.iframe(linkUrl, 'Vendor Management System');
    }
    
    function closePopup() {
        eModal.close();
    }
</script>