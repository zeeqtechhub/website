<?php
session_start();
ob_start();

require_once ("class.php");
require_once ("function.php");
$app = App();
$app->run();
//update_base();
