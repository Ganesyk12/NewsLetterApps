<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
   <a class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="sidebar-brand-icon">
         <i class="fas fa-newspaper"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Daily News</div>
   </a>

   <hr class="sidebar-divider my-0">
   <li class="nav-item active">
      <a class="nav-link" href="<?= base_url('C_Dashboard') ?>">
         <i class="fas fa-fw fa-tachometer-alt"></i>
         <span>Dashboard</span></a>
   </li>
   <hr class="sidebar-divider">
   <div class="sidebar-heading">
      Menu
   </div>
   <li class="nav-item">
      <a class="nav-link" href="<?= base_url('C_Agenda') ?>">
         <i class="fas fa-fw fa-table"></i>
         <span>Agenda</span></a>
   </li>
   <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
         <i class="fas fa-fw fa-wrench"></i>
         <span>Manajemen Media</span>
      </a>
      <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Media:</h6>
            <a class="collapse-item" href="<?= base_url('C_Berita') ?>">Berita</a>
         </div>
      </div>
   </li>
   <li class="nav-item">
      <a class="nav-link" href="<?= base_url('C_Contact') ?>">
         <i class="fas fa-fw fa-phone"></i>
         <span>Hubungi Kami</span></a>
   </li>
   <li class="nav-item">
      <a class="nav-link" href="<?= base_url('C_User') ?>">
         <i class="fas fa-fw fa-users"></i>
         <span>Manajemen User</span></a>
   </li>
   <hr class="sidebar-divider">
   <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
   </div>
</ul>