<?php require_once("important.php"); ?>
<?php $app->setTitle("Page Not Found"); ?>
<?php $app->setMetaTags(array('description' => "Page not found.")); ?>
<?php $app->setMetaTags(array('keywords' => "404, page not found")); ?>
<?php require_once(path("header.php")); ?>

<div class="tmp-about-area tmp-section-gap">
    <div class="container">
        <div class="row justify-content-center mt--60">
            <div class="col-lg-8 text-center">
                <h1 class="title w-700">404</h1>
                <p class="description m-0">Oops! The page you are looking for does not exist.</p>
            </div>
        </div>
    </div>
</div>

<?php include(path("footer.php")); ?>
