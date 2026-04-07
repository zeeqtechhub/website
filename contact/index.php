<?php require_once ("../important.php") ?>
<?php $app->setTitle("Contact Us") ?>
<?php $app->setMetaTags(array('description' => "Our Contact Information")); ?>
<?php $app->setMetaTags(array('keywords' => "Contact Us")); ?>

<?php require_once (path("header.php")) ?>

    <!-- Start Contact Area  -->
    <div class="main-content">

        <div class="tmp-contact-area tmp-section-gap pb--50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tmp-section-title-border text-center">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                    <span class="subtitle-text">Contact With Us</span>
                                </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 mt--20 Xtmp-title-split">Let's Hear From You</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- appoinment area start -->
        <div class="inv-appoinment-area-start tmp-section-gapBottom">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-5">
                        <div class="tmp-contact-address mt_dec--30">
                            <div class="tmp-address tmponhover">
                                <div class="icon">
                                    <i class="feather-headphones"></i>
                                </div>
                                <div class="inner">
                                    <h4 class="title">Call us todays</h4>
                                    <p><a href="tel:+2349098880751">+234 909 888 0751</a></p>
                                </div>
                            </div>
                            <div class="tmp-address tmponhover">
                                <div class="icon">
                                    <i class="feather-mail"></i>
                                </div>
                                <div class="inner">
                                    <h4 class="title">Send an Email</h4>
                                    <p><a href="mailto:info@zeeqtech.com">info@zeeqtech.com</a></p>
                                </div>
                            </div>
                            <div class="tmp-address tmponhover">
                                <div class="icon">
                                    <i class="feather-map-pin"></i>
                                </div>
                                <div class="inner">
                                    <h4 class="title">Visit our HQ</h4>
                                    <p>Suite D4 Triple H Plaza Wuye Behind VIO office. Abuja, Nigeria</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form class="contact-form-1 appoinment-form-wrapper tmponhover tmp-dynamic-form" id="contact-form" method="POST" action="https://html.inversweb.com/corpox/mail/">
                            <div class="form-group-wrapper">
                                <div class="form-group tmponhover">
                                    <input type="text" name="contact-name" id="contact-name" placeholder="Your Name" required>
                                </div>
                                <div class="form-group tmponhover">
                                    <input type="tel" name="contact-phone" id="contact-phone" placeholder="Phone Number">
                                </div>
                            </div>
                            
                            <div class="form-group tmponhover">
                                <input type="email" id="contact-email" name="contact-email" placeholder="Your Email" required>
                            </div>

                            <div class="form-group tmponhover">
                                <input type="text" id="subject" name="subject" placeholder="Your Subject">
                            </div>

                            <div class="form-group tmponhover">
                                <textarea name="contact-message" id="contact-message" placeholder="Your Message"></textarea>
                            </div>

                            <div class="tmponhover">
                                <button name="submit" id="submit" class="btn-default btn-small tmp-btn w-100">
                                    <span>Submit Now</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- appoinment area end -->

    </div>
    <!-- End Contact Area  -->

<?php include(path("footer.php")) ?>
