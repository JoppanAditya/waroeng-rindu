 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link <?= $menuTitle == 'Dashboard' ? '' : 'collapsed'; ?>" href="<?= base_url('admin/dashboard'); ?>">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li><!-- End Dashboard Nav -->

         <li class="nav-item">
             <a class="nav-link <?= $menuTitle == 'User' ? '' : 'collapsed'; ?>" data-bs-target="#user-nav" data-bs-toggle="collapse" href="javascript:void(0)">
                 <i class="bi bi-person-lines-fill"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="user-nav" class="nav-content <?= $menuTitle == 'User' ? '' : 'collapse'; ?>" data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="<?= base_url('admin/admin'); ?>" class="<?= $title == 'Admin' ? 'active' : ''; ?>">
                         <i class="bi bi-circle"></i><span>Admin List</span>
                     </a>
                 </li>
                 <li>
                     <a href="<?= base_url('admin/user'); ?>" class="<?= $title == 'User' ? 'active' : ''; ?>">
                         <i class="bi bi-circle"></i><span>User List</span>
                     </a>
                 </li>
             </ul>
         </li><!-- End User Nav -->

         <li class="nav-item">
             <a class="nav-link <?= $menuTitle == 'Menu' ? '' : 'collapsed'; ?>" data-bs-target="#menu-nav" data-bs-toggle="collapse" href="javascript:void(0)">
                 <i class="bi bi-menu-button-wide"></i><span>Menu</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="menu-nav" class="nav-content <?= $menuTitle == 'Menu' ? '' : 'collapse'; ?>" data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="<?= base_url('admin/menu'); ?>" class="<?= $title == 'Menu' ? 'active' : ''; ?>">
                         <i class="bi bi-circle"></i><span>Menu List</span>
                     </a>
                 </li>
                 <li>
                     <a href="<?= base_url('admin/category'); ?>" class="<?= $title == 'Category' ? 'active' : ''; ?>">
                         <i class="bi bi-circle"></i><span>Category</span>
                     </a>
                 </li>
             </ul>
         </li><!-- End Menu Nav -->

         <li class="nav-item">
             <a class="nav-link <?= $menuTitle == 'Transaction' ? '' : 'collapsed'; ?>" data-bs-target="#transaction-nav" data-bs-toggle="collapse" href="javascript:void(0)">
                 <i class="bi bi-journal-text"></i><span>Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="transaction-nav" class="nav-content <?= $menuTitle == 'Transaction' ? '' : 'collapse'; ?>" data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="<?= base_url('admin/transaction'); ?>" class="<?= $menuTitle == 'Transaction' ? 'active' : ''; ?>">
                         <i class="bi bi-circle"></i><span>Order List</span>
                     </a>
                 </li>
             </ul>
         </li><!-- End Transaction Nav -->

         <li class="nav-item">
             <a class="nav-link <?= $menuTitle == 'Profile' ? '' : 'collapsed'; ?>" href="<?= base_url('admin/profile'); ?>">
                 <i class="bi bi-person"></i>
                 <span>My Profile</span>
             </a>
         </li><!-- End Profile Page Nav -->
     </ul>

 </aside><!-- End Sidebar-->
