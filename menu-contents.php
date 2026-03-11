<ul class="mainmenu">
    <li class="<?php echo current_menu() ?>"><a href="<?= url() ?>">Home</a></li>
    <li class="<?php echo current_menu("about") ?>"><a href="<?= url("about/") ?>">About</a></li>
    <li class="<?php echo current_menu("services") ?>"><a href="<?= url("services/") ?>">Our Services</a></li>
    <!-- <li class="has-droupdown has-menu-child-item">
        <a href="services/">Services</a>
        <ul class="submenu">
            <li><a href="blog-grid.html">Zeeq Training</a></li>
            <li class="has-third-lev">
                <a href="#">Service 4</a>
                <ul class="submenu">
                    <li><a href="blog-details.html">Blog Details</a></li>
                    <li><a href="blog-details-standard.html">Details Standard <span class="tmp-badge-card">New</span></a></li>
                    <li><a href="blog-details-sidebar.html">Blog Details Right Sidebar</a></li>
                    <li><a href="blog-deails-sidebar-left.html">Blog Details Left Sidebar</a></li>
                    <li><a href="blog-deails-video.html">Blog Details Video</a></li>
                    <li><a href="blog-deails-video-two.html">Blog Details Video Two</a></li>
                    <li><a href="blog-deails-video-popup.html">Blog Details Video Popup</a></li>
                </ul>
            </li>
        </ul>
    </li> -->
    <li class="<?php echo current_menu("contact") ?>"><a href="<?= url("contact/") ?>">Contact Us</a></li>
</ul>
