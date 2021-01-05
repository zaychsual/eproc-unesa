<li class="xn-logo">
    <a href="{{URL::to('/home')}}">{{Session::get('ss_setting')['header_admin']}}</a>
    <a href="#" class="x-navigation-control"></a>
</li>

<li class="xn-openable {{ Request::is('home') ? 'active' : '' }}">
    <a href="{{URL::to('home')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
</li> 

<li class="">
    <a href="{{route('pejabatdaftarpaket.index')}}"> <span class="fa fa-cubes"></span>Daftar Paket</a>
</li>

<li class="xn-openable">
    <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Data Penyedia</span></a>
    <ul class="animated zoomIn">
        <!-- <li class="{{ Request::is('procurement/rekanansnonaktif') ? 'active' : '' }}"><a href="{{URL::to('procurement/rekanansnonaktif')}}"><span class="fa fa-image"></span> Data Penyedia (Non Aktif)</a></li> -->
        <li class="{{ Request::is('procurement/rekanansaktif') ? 'active' : '' }}"><a href="{{URL::to('procurement/rekanansaktif')}}"><span class="fa fa-user"></span> Data Penyedia (Sudah Verifikasi)</a></li>
    </ul>
</li>  
<li class="xn-openable {{ Request::is('procurement/inbox') ? 'active' : '' }}">
    <a href="{{URL::to('procurement/inbox')}}"><span class="fa fa-cogs"></span> <span class="xn-text">Inbox</span></a>
</li>
 {{-- <li class="xn-openable {{ Request::is('procurement/Logbook') ? 'active' : '' }}">
    <a href="{{URL::to('procurement/Logbook')}}"><span class="fa fa-book"></span> <span class="xn-text">Logbook</span></a>
</li>   --}}
<li class="xn-openable {{ Request::is('procurement/log_akses') ? 'active' : '' }}">
    <a href="{{URL::to('procurement/log_akses')}}"><span class="fa fa-pencil"></span> <span class="xn-text">Log Akses</span></a>
</li>
<li class="xn-openable {{ Request::is('webprofile/user') ? 'active' : '' }}">
    <a href="{{ route('user.edit', ['data'=>Crypt::encrypt(Auth::user()->id)])}}"><span class="fa fa-pencil"></span> <span class="xn-text">Ganti Password</span></a>
</li>

<!-- SIGN OUT -->
<li class="xn-icon-button pull-right">
    <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
</li> 
<!-- END SIGN OUT -->  
