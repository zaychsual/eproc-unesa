<li class="xn-logo">
    <a href="{{URL::to('/home')}}">{{Session::get('ss_setting')['header_admin']}}</a>
    <a href="#" class="x-navigation-control"></a>
</li>
<li class="xn-openable {{ Request::is('home') ? 'active' : '' }}">
    <a href="{{URL::to('home')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
</li>  
<li class="xn-openable">
    <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Data Penyedia</span></a>
    <ul class="animated zoomIn">
        <li class="{{ Request::is('webprofile/rekanans') ? 'active' : '' }}"><a href="{{URL::to('webprofile/rekanans')}}"><span class="fa fa-image"></span> Identitas Perusahaan</a></li>
        <li class="{{ Request::is('webprofile/ijinusahas') ? 'active' : '' }}"><a href="{{URL::to('webprofile/ijinusahas')}}"><span class="fa fa-user"></span> Ijin Usaha</a></li>
        <li class="{{ Request::is('webprofile/aktas') ? 'active' : '' }}"><a href="{{URL::to('webprofile/aktas')}}"><span class="fa fa-users"></span> Akta</a></li>
        <li class="{{ Request::is('webprofile/pemiliks') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pemiliks')}}"><span class="fa fa-comments"></span> Pemilik</a></li>
        <li class="{{ Request::is('webprofile/pengurus') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pengurus')}}"><span class="fa fa-calendar"></span> Pengurus</a></li>
        <li class="{{ Request::is('webprofile/tenagaahlis') ? 'active' : '' }}"><a href="{{URL::to('webprofile/tenagaahlis')}}"><span class="fa fa-users"></span> Tenaga Ahli</a></li>                                 
        {{--         
        <li class="xn-openable">
            <a href="#"><span class="fa fa-users"></span> Tenaga Ahli</a>           
            <ul>   
                <li><a href="#"><span class="fa fa-file-o"></span> Pengalaman Kerja</a></li>
                <li><a href="#"><span class="fa fa-file-o"></span> Pendidikan</a></li>
                <li><a href="#"><span class="fa fa-file-o"></span> Sertifikat/Pelatihan</a></li>
                <li><a href="#"><span class="fa fa-file-o"></span> Bahasa</a></li>
            </ul>
        </li>
        --}}
        <li class="{{ Request::is('webprofile/peralatans') ? 'active' : '' }}"><a href="{{URL::to('webprofile/peralatans')}}"><span class="fa fa-edit"></span> Peralatan</a></li>
        <li class="{{ Request::is('webprofile/pengalamans') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pengalamans')}}"><span class="fa fa-columns"></span> Pengalaman</a></li>
        <li class="{{ Request::is('webprofile/pajaks') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pajaks')}}"><span class="fa fa-question-circle"></span> Pajak</a></li>         
    </ul>
</li>
<li class="{{ Request::is('procurement/rekananpaketbaru') ? 'active' : '' }}"> 
    <a href="{{URL::to('procurement/paket-baru')}}"><span class="fa fa-file-text-o"></span>Paket Baru</a>
</li>
<li class="xn-openable {{ Request::is('procurement/inbox') ? 'active' : '' }}">
    <a href="{{URL::to('procurement/inbox')}}"><span class="fa fa-cogs"></span> <span class="xn-text">Inbox</span></a>
</li>

<li class="xn-openable {{ Request::is('webprofile/user') ? 'active' : '' }}">
    <a href="{{ route('user.edit', ['data'=>Crypt::encrypt(Auth::user()->id)])}}"><span class="fa fa-pencil"></span> <span class="xn-text">Ganti Password</span></a>
</li>
<li class="xn-openable {{ Request::is('procurement/log_akses') ? 'active' : '' }}">
    <a href="{{URL::to('procurement/log_akses')}}"><span class="fa fa-pencil"></span> <span class="xn-text">Log Akses</span></a>
</li>
<!-- <li class="xn-openable {{ Request::is('procurement/log_akses') ? 'active' : '' }}">
    <a href="{{URL::to('procurement/log_akses')}}"><span class="fa fa-file-text-o"></span> <span class="xn-text">Log Akses</span></a>
</li> -->

<!-- SIGN OUT -->
<li class="xn-icon-button pull-right">
    <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
</li> 
<!-- END SIGN OUT -->  
