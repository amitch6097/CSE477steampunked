<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/24/17
 * Time: 1:56 PM
 */

require 'lib/steampunked.inc.php';

$controller = new Steampunked\Controller($steampunked, $_POST);

if($controller->getPage() == 'index.php') {
    unset($_SESSION["STEAMPUNKED_SESSION"]);
}
//
//header("location: steampunked.php");

header('Location: ' . $controller->getPage());

exit;