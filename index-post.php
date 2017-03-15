<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/24/17
 * Time: 1:56 PM
 */

require 'lib/steampunked.inc.php';

$controller = new Steampunked\StartController($steampunked, $_POST);

header('Location: ' . $controller->getPage());

exit;