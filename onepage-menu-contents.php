<ul class="mainmenu onepagenav">
    <li class="<?php echo current_menu() ?>"><a href="<?= url() ?>">Home</a></li>
    <li class="<?php echo current_menu("about") ?>"><a href="#about">About</a></li>
    <li class="<?php echo current_menu("services") ?>"><a href="#services">Our Services</a></li>
    <li class="<?php echo current_menu("academy") ?>"><a href="#hero">Academy</a></li>
    <li class="<?php echo current_menu("contact") ?>"><a href="<?= url("contact/") ?>">Contact Us</a></li>
</ul>
