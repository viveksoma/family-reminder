<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="<?php echo base_url(); ?>" class="brand-link">
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">Family Reminders</span>
        <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="menu"
            data-accordion="false"
        >
            <?php 
                $uri = service('uri'); 
                $totalSegments = $uri->getTotalSegments();
                
                // Ensure there is at least one segment before accessing it
                $last_segment = $uri->getSegment($totalSegments);      
            ?>
            <li class="nav-item">
                <a href="<?php echo base_url('dashboard'); ?>" class="nav-link <?php if($last_segment == 'dashboard' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('reminders'); ?>" class="nav-link <?php if($last_segment == 'reminders' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-calendar"></i>
                    <p>
                        Reminders
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('warranties'); ?>" class="nav-link <?php if($last_segment == 'warranties' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-person-fill"></i>
                    <p>
                        Warrenties
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('members'); ?>" class="nav-link <?php if($last_segment == 'members' ) { echo 'active'; } ?>">
                    <i class="nav-icon bi bi-person-fill"></i>
                    <p>
                        Members
                    </p>
                </a>
            </li>
        </ul>
        <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>