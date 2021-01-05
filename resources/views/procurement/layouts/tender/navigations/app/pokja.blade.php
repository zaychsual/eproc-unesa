<li class="xn-logo">
    <a href="{{URL::to('/home')}}">{{Session::get('ss_setting')['header_admin']}}</a>
    <a href="#" class="x-navigation-control"></a>
</li>

<li class="xn-openable {{ Request::is('home') ? 'active' : '' }}">
    <a href="{{URL::to('home')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
</li> 

<!-- <li class="xn-openable">
    <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Daftar Master</span></a>
    <ul class="animated zoomIn">
        <li class="{{ Request::is('procurement/tahaps') ? 'active' : '' }}"><a href="{{URL::to('procurement/tahaps')}}"><span class="fa fa-list"></span> Master Tahap</a></li>
        <li class="{{ Request::is('procurement/statuss') ? 'active' : '' }}"><a href="{{URL::to('procurement/statuss')}}"><span class="fa fa-list"></span> Master Status</a></li>
        <li class="{{ Request::is('procurement/pemenangs') ? 'active' : '' }}"><a href="{{URL::to('procurement/pemenangs')}}"><span class="fa fa-list"></span> Master Pemenang</a></li>
        <li class="{{ Request::is('procurement/jenispengadaans') ? 'active' : '' }}"><a href="{{URL::to('procurement/jenispengadaans')}}"><span class="fa fa-list"></span> Master Jenis Pengadaan</a></li>
        <li class="{{ Request::is('procurement/pemilihans') ? 'active' : '' }}"><a href="{{URL::to('procurement/pemilihans')}}"><span class="fa fa-list"></span> Master Metode Pemilihan</a></li>
        <li class="{{ Request::is('procurement/kualifikasis') ? 'active' : '' }}"><a href="{{URL::to('procurement/kualifikasis')}}"><span class="fa fa-list"></span> Master Kualifikasi</a></li>
        <li class="{{ Request::is('procurement/metodekualifikasis') ? 'active' : '' }}"><a href="{{URL::to('procurement/metodekualifikasis')}}"><span class="fa fa-list"></span> Master Metode Kualifikasi</a></li>
        <li class="{{ Request::is('procurement/dokumens') ? 'active' : '' }}"><a href="{{URL::to('procurement/dokumens')}}"><span class="fa fa-list"></span> Master Metode Dokumen</a></li>
        <li class="{{ Request::is('procurement/evaluasis') ? 'active' : '' }}"><a href="{{URL::to('procurement/evaluasis')}}"><span class="fa fa-list"></span> Master Metode Evaluasi</a></li>
        <li class="{{ Request::is('procurement/jeniskontraks') ? 'active' : '' }}"><a href="{{URL::to('procurement/jeniskontraks')}}"><span class="fa fa-list"></span> Master Jenis Kontrak</a></li>
        <li class="{{ Request::is('procurement/satuankerjas') ? 'active' : '' }}"><a href="{{URL::to('procurement/satuankerjas')}}"><span class="fa fa-list"></span> Master Satuan Kerja</a></li>
        <li class="{{ Request::is('procurement/klpds') ? 'active' : '' }}"><a href="{{URL::to('procurement/klpds')}}"><span class="fa fa-list"></span> Master KLPD</a></li>
        <li class="{{ Request::is('procurement/tahuns') ? 'active' : '' }}"><a href="{{URL::to('procurement/tahuns')}}"><span class="fa fa-list"></span> Master Tahun</a></li>
        <li class="{{ Request::is('procurement/sumberdanas') ? 'active' : '' }}"><a href="{{URL::to('procurement/sumberdanas')}}"><span class="fa fa-list"></span> Master Sumber Dana</a></li>
          
    </ul>
</li> --> 

<li class="{{ Request::is('pembelian-langsung') ? 'active' : '' }}">
    <a href="{{route('pokjadaftarpaket.index')}}"> <span class="fa fa-cubes"></span>Daftar Paket</a>
</li>

{{-- <li class="xn-openable">
    <a href="#"><span class="fa fa-check"></span> <span class="xn-text">List Persetujuan</span></a>
    <ul class="animated zoomIn">
        <li class="{{ Request::is('pembelian-langsung') ? 'active' : '' }}">
            <a href="{{route('pembelian-langsung')}}"> Pembelian Langsung</a>
        </li>
        <li class="{{ Request::is('webprofile/aktas') ? 'active' : '' }}">
            <a href="{{route('quotation')}}"> Quotation</a>
        </li>
        <li class="{{ Request::is('webprofile/aktas') ? 'active' : '' }}">
            <a href="{{route('tender')}}"> Tender</a>
        </li>
        <li class="{{ Request::is('webprofile/aktas') ? 'active' : '' }}">
            <a href="{{route('penunjukan-langsung')}}"> Penunjukan Langsung</a>
        </li>
        <li class="{{ Request::is('webprofile/aktas') ? 'active' : '' }}">
            <a href="{{route('pembelian-barang-bekas')}}"> Pembelian Barang Bekas</a>
        </li>
    </ul>
</li> --}}

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
