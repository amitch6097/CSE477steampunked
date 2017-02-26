<?php
require __DIR__ . "/../vendor/autoload.php";
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/24/17
 * Time: 1:57 PM
 */
session_start();

define("STEAMPUNKED_SESSION", "steampunked");

if(!isset($_SESSION["STEAMPUNKED_SESSION"])){
    $_SESSION["STEAMPUNKED_SESSION"] = new \Steampunked\Game("kyle", "jerry"); //should be new model
}
//$_SESSION["STEAMPUNKED_SESSION"] = new \Steampunked\Game("kyle", "jerry"); //should be new model


$steampunked = $_SESSION["STEAMPUNKED_SESSION"];
