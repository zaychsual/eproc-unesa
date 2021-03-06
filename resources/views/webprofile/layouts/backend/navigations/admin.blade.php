<li class="{{ Request::is('home') ? 'active' : '' }}">
    <a href="{{URL::to('home')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
</li>
<li class="xn-openable
    {{ 
    request()->is('webprofile/pokja') || 
    request()->is('webprofile/ppk') || 
    request()->is('webprofile/pejabat-pengadaan') || 
    request()->is('webprofile/user') || 
    request()->is('webprofile/user/ka-ukpbj') || 
    request()->is('webprofile/rekanans') || 
    request()->is('webprofile/user/unit-kerja') || 
    request()->is('webprofile/pengendali-kualitas') 
     ? 'active' : '' 
    }}">
    <a href="#"><span class="fa fa-database"></span> <span class="xn-text">Master</span></a>
    <ul>
        <li class="{{ Request::is('webprofile/rekanans') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/rekanans')}}"><span class="fa fa-users"></span> <span class="xn-text">Rekanan</span></a>
        </li>
        <li class="{{ Request::is('webprofile/user') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/user')}}"><span class="fa fa-user"></span> <span class="xn-text">Pengguna</span></a>
        </li>
        <li class="{{ Request::is('webprofile/pokja') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/pokja')}}"><span class="fa fa-user"></span> <span class="xn-text">Pokja</span></a>
        </li>
        <li class="{{ Request::is('webprofile/ppk') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/ppk')}}"><span class="fa fa-user"></span> <span class="xn-text">PPK</span></a>
        </li>
        <li class="{{ Request::is('webprofile/pejabat-pengadaan') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/pejabat-pengadaan')}}"><span class="fa fa-user"></span> <span class="xn-text">Pejabat Pengadaan</span></a>
        </li>
        <li class="{{ Request::is('webprofile/pengendali-kualitas') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/pengendali-kualitas')}}"><span class="fa fa-user"></span> <span class="xn-text">Pengendali Kualitas</span></a>
        </li>
        <li class="{{ Request::is('webprofile/user/ka-ukpbj') ? 'active' : '' }}">
            <a href="{{route('user.ka-ukpbj')}}"><span class="fa fa-user"></span> <span class="xn-text">UKPBJ/UPL</span></a>
        </li>
        <li class="{{ Request::is('webprofile/user/unit-kerja') ? 'active' : '' }}">
            <a href="{{route('user.unit-kerja')}}"><span class="fa fa-user"></span> <span class="xn-text">Unit Kerja</span></a>
        </li>
    </ul>
</li>
<li class="xn-openable {{ 
    request()->is('webprofile/pokja/list-validate') || 
    request()->is('webprofile/ppk/list-validate') || 
    request()->is('webprofile/pejabat-pengadaan/list-validate') || 
    request()->is('webprofile/pengendali-kualitas/list-validate') 
     ? 'active' : '' 
    }}">
    <a href="#"><span class="fa fa-check"></span> <span class="xn-text">Validate</span></a>
    <ul>
        <li class="{{ Request::is('webprofile/pokja/list-validate') ? 'active' : '' }}">
            <a href="{{ route('pokja.list-validate') }}"><span class="fa fa-user"></span> <span class="xn-text">Pokja</span></a>
        </li>
        <li class="{{ Request::is('webprofile/ppk/list-validate') ? 'active' : '' }}">
            <a href="{{ route('ppk.list-validate') }}"><span class="fa fa-user"></span> <span class="xn-text">PPK</span></a>
        </li>
        <li class="{{ Request::is('webprofile/pejabat-pengadaan/list-validate') ? 'active' : '' }}">
            <a href="{{ route('pejabat-pengadaan.list-validate') }}"><span class="fa fa-user"></span> <span class="xn-text">Pejabat Pengadaan</span></a>
        </li>
        <li class="{{ Request::is('webprofile/pengendali-kualitas/list-validate') ? 'active' : '' }}">
            <a href="{{ route('pengendali-kualitas.list-validate') }}"><span class="fa fa-user"></span> <span class="xn-text">Pengendali Kualitas</span></a>
        </li>
    </ul>
</li>
<li class="xn-openable">
    <a href="#"><span class="fa fa-paper-plane-o"></span> <span class="xn-text">Setting Web Profil</span></a>
    <ul>
        {{-- <li class="xn-title">Setting Web Profil</li> --}}
        <li class="xn-openable">
            <a href="#"><span class="fa fa-paper-plane-o"></span> <span class="xn-text">Berita</span></a>
            <ul>
                <li class="{{ Request::is('webprofile/posts') ? 'active' : '' }}"><a href="{{URL::to('webprofile/posts')}}">Semua Berita</a></li>
                <li class="{{ Request::is('webprofile/posts/create') ? 'active' : '' }}"><a href="{{URL::to('webprofile/posts/create')}}">Berita Baru</a></li>
                <li class="{{ Request::is('webprofile/categories') ? 'active' : '' }}"><a href="{{URL::to('webprofile/categories')}}">Kategori</a></li>
            </ul>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-file"></span> <span class="xn-text">Halaman</span></a>
            <ul>
                <li class="{{ Request::is('webprofile/pages') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pages')}}">Semua Halaman</a></li>
                <li class="{{ Request::is('webprofile/pages/create') ? 'active' : '' }}"><a href="{{URL::to('webprofile/pages/create')}}">Halaman Baru</a></li>
            </ul>
        </li>
        <li class="{{ Request::is('webprofile/admin/info') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/admin/info')}}"><span class="fa fa-info-circle"></span><span class="xn-text">Informasi</span></a>
        </li>
        <li class="{{ Request::is('webprofile/slider') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/slider')}}"><span class="fa fa-sliders"></span><span class="xn-text">Slider</span></a>
        </li>
        <li class="{{ Request::is('webprofile/gallery') ? 'active' : '' }}">
            <a href="{{URL::to('webprofile/gallery')}}"><span class="fa fa-file-image-o"></span><span class="xn-text">Gallery</span></a>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-file-o"></span> <span class="xn-text">Dokumen</span></a>
            <ul>
                <li class="{{ Request::is('webprofile/file') ? 'active' : '' }}"><a href="{{URL::to('webprofile/file')}}">File</a></li>
                <li class="{{ Request::is('webprofile/categories_file') ? 'active' : '' }}"><a href="{{URL::to('webprofile/categories_file')}}">Kategori File</a></li>
            </ul>
        </li>
        <li class="{{ Request::is('webprofile/newmenu') ? 'active' : '' }}">
        <a href="{{URL::to('webprofile/newmenu')}}"><span class="fa fa-tasks"></span> <span class="xn-text">Menu</span></a>
        </li>
        <li class="{{ Request::is('webprofile/layouts') ? 'active' : '' }}">
        <a href="{{URL::to('webprofile/layouts')}}"><span class="fa fa-tasks"></span> <span class="xn-text">Layouts</span></a>
        </li>
        <li class="{{ Request::is('webprofile/setting') ? 'active' : '' }}">
        <a href="{{URL::to('webprofile/setting')}}"><span class="fa fa-gears"></span><span class="xn-text">Pengaturan</span></a>
        </li>
    </ul>
</li>