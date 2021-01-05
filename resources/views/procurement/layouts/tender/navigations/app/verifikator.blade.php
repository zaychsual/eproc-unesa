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
        <li class="{{ Request::is('webprofile/listrekanans') ? 'active' : '' }}"><a href="{{URL::to('webprofile/listrekanans')}}"><span class="fa fa-image"></span> Data Penyedia (Non Aktif)</a></li>
        <li class="{{ Request::is('webprofile/listrekanans_aktif') ? 'active' : '' }}"><a href="{{URL::to('webprofile/listrekanans_aktif')}}"><span class="fa fa-user"></span> Data Penyedia</a></li>
            
    </ul>
</li>  
<li class="xn-openable {{ Request::is('procurement/inbox') ? 'active' : '' }}">
    <a href="{{URL::to('procurement/inbox')}}"><span class="fa fa-cogs"></span> <span class="xn-text">Inbox</span></a>
</li>
<li class="xn-openable {{ Request::is('procurement/log-akses') ? 'active' : '' }}">
    <a href="{{URL::to('procurement/log-akses')}}"><span class="fa fa-pencil"></span> <span class="xn-text">Log Akses</span></a>
</li>
<li class="xn-openable {{ Request::is('webprofile/user') ? 'active' : '' }}">
    <a href="{{ route('user.edit', ['data'=>Crypt::encrypt(Auth::user()->id)])}}"><span class="fa fa-pencil"></span> <span class="xn-text">Ganti Password</span></a>
</li>

<!-- SIGN OUT -->
<li class="xn-icon-button pull-right">
    <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
</li> 
<!-- END SIGN OUT -->  
