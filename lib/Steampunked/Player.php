<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/12/17
 * Time: 1:44 PM
 */

namespace Steampunked;


class Player
{
    private $name;
    private $pipes = [];

    function __construct($name){
        $this->name = $name;

    }
    function get_name(){
        return $this->name;
    }

}