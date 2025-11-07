<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="mdi mdi-home menu-icon"></i><span class="menu-title">Dashboard</span></a></li>
    
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-circle-outline menu-icon"></i><span class="menu-title">Tiket</span><i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ route('kategori.index') }}"><span class="menu-title">Kategori</span></a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.status.index') }}">Status</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('prioritas.index') }}">Prioritas</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('event.index') }}">Event</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.tiket.index') }}">Tiket</a></li>

        </ul>
      </div>
    </li>

    <li class="nav-item">
  <a class="nav-link" data-toggle="collapse" href="#report-menu" aria-expanded="false">
    <i class="mdi mdi-file-document-box-outline menu-icon"></i>
    <span class="menu-title">Laporan</span>
    <i class="menu-arrow"></i>
  </a>
  <div class="collapse" id="report-menu">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.report.index') }}">Daftar Laporan</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.report.create') }}">Buat Laporan Baru</a></li>
    </ul>
  </div>
</li>
    
  </ul>
</nav>