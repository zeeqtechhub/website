<!-- Start Header Area  -->
    <?php if(segment(0)): ?>
        <header class="tmp-header header-default header-transparent header-sticky-smooth header-sticky">
    <?php else: ?>
        <header class="tmp-header header-default header-transparent logo-white-show default-nav-white header-sticky header-one">
    <?php endif; ?>
        <div class="container position-relative">
            <div class="row align-items-center row--0">
                <div class="col-xl-2 col-lg-2 col-md-6 col-4">
                    <div class="logo">
                        <a href="<?= url() ?>">
                            <img src="<?= img("assets/images/logo/logo.png") ?>" alt="Corporate Logo">
                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-10 col-md-6 col-8 position-static">
                    <div class="header-right with-search">

                        <nav class="mainmenu-nav d-none d-lg-block">
                            <?php include path('menu-contents.php'); ?>
                        </nav>

                        <!-- Start Mobile-Menu-Bar -->
                        <div class="mobile-menu-bar ml--5 d-block d-lg-none">
                            <div class="hamberger">
                                <button class="hamberger-button">
                                    <i class="feather-menu"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Start Mobile-Menu-Bar -->

                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header Area  -->

    <div class="popup-mobile-menu">
        <div class="inner">
            <div class="header-top">
                <div class="logo">
                    <a href="<?= url() ?>">
                        <img src="<?= img("assets/images/logo/logo.png") ?>" alt="Corporate Logo">
                    </a>
                </div>
                <div class="close-menu">
                    <button class="close-button">
                        <i class="feather-x"></i>
                    </button>
                </div>
            </div>
            <?php include path('menu-contents.php'); ?>
        </div>
    </div>
