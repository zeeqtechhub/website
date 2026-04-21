<?php require_once ("../important.php") ?>
<?php $app->setTitle("Contact Us") ?>
<?php $app->setMetaTags(array('description' => "Our Contact Information")); ?>
<?php $app->setMetaTags(array('keywords' => "Contact Us")); ?>

<?php require_once (path("header.php")) ?>

    <!-- Start Contact Area  -->
    <div class="main-content contact-page">

        <div class="tmp-contact-area tmp-section-gap pb--50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tmp-section-title-border text-center">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                    <span class="subtitle-text">Contact Us</span>
                                </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 mt--20 Xtmp-title-split">Let's Hear From You</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                        <form id="contact-form" method="POST" action="" class="contact-form-1 appoinment-form-wrapper tmponhover Xtmp-dynamic-form">
                            <div class="form-group-wrapper">
                                <div class="form-group tmponhover">
                                    <input type="text" id="contact-name" name="name" placeholder="Your Name" required>
                                </div>
                                <div class="form-group tmponhover">
                                    <input type="tel" id="contact-phone" name="telephone" placeholder="Phone Number">
                                </div>
                            </div>
                            
                            <div class="form-group tmponhover">
                                <input type="email" id="contact-email" name="email" placeholder="Your Email" required>
                            </div>

                            <div class="form-group tmponhover">
                                <input type="text" id="subject" name="subject" placeholder="Your Subject">
                            </div>

                            <div class="form-group tmponhover">
                                <textarea id="contact-message" name="message" placeholder="Your Message"></textarea>
                            </div>

                            <?php if(config("enable-captcha", true)): ?>
                                <div class="row mt-3">
                                    <div class="mb-3 col-md-12">
                                        <div class="col-md-6 mb-2">
                                            <div class="input-group d-flex align-items-stretch captcha-code">
                                                <input class="form-control captcha-input" type="text" placeholder="Enter the text here" name="captcha" id="captcha-input"/>
                                                <img id="captcha-image" class="mr-1" src="<?php echo url("libraries/captcha.php") ?>" />
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:;" class="ml-1" onclick="document.getElementById('captcha-image').src='<?php echo url("libraries/captcha.php") ?>?' + Math.random(); document.getElementById('captcha-input').focus();">
                                                        <i class="fa fa-refresh"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="g-recaptcha" data-sitekey="<?php echo config('recaptcha-key'); ?>"></div>
                                <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en">
                                </script>
                            <?php endif ?>

                            <div>
                                <button class="btn-small w-100 spin" data-send="false">
                                <i class="fa fa-spinner fa-spin"></i> <span>Submit Now</span>
                            </button>
                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Contact Area  -->

<?php include(path("footer.php")) ?>
