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
    $_SESSION["STEAMPUNKED_SESSION"] = new Steampunked\Player("jerry");
}

$guessing = $_SESSION["STEAMPUNKED_SESSION"];