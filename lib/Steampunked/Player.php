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
    public $name;
    private $pipes = [];

    function __construct($name){
        $this->name = $name;
    }

    public function initalize_pipes($number, $init_pipes){

        if($number == 1){
            $pipes[] = array(array(1,7), $init_pipes[1]);
            $pipes[] = array(array(0,7), $init_pipes[2]);
            $pipes[] = array(array(0,0), $init_pipes[0]);
        }else{
            $pipes[] = array(array(4,7), $init_pipes[1]);
            $pipes[] = array(array(3,7), $init_pipes[2]);
            $pipes[] = array(array(5,0), $init_pipes[0]);
        }
        $this->pipes = $pipes;
        return $pipes;
    }

    public function get_name(){
        return $this->name;
    }
}