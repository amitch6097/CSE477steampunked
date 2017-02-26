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
    private $open_locations = [];


    function __construct($name){
        $this->name = $name;
    }

    public function initalize_pipes($number, $init_pipes){
        /**
         * sets the players pipes location based on their $number
         * @return array of pipes which needs to be added to update_pipes in Game
         */

        if($number == 1){
            $pipes[] = array(array(1,7), $init_pipes[1]);
            $pipes[] = array(array(0,7), $init_pipes[2]);

            $pipes[] = array(array(0,0), $init_pipes[0]);

            $this->open_locations = array(array(0, 1));
        }else{
            $pipes[] = array(array(4,7), $init_pipes[1]);
            $pipes[] = array(array(3,7), $init_pipes[2]);

            $pipes[] = array(array(5,0), $init_pipes[0]);
            $this->open_locations = array(array(5, 1));
        }
        $this->pipes = $pipes;
        return $pipes;
    }

    public function add_pipe($location, $pipe){
        $this->pipes[] = array($location, $pipe);
        $this->update_open($location, $pipe);
    }
    private function update_open($location, $pipe){
        $adds = array(array(0,1), array(1,0), array(0, -1), array(-1, 0));
        $locations = array();

        $open_at = $pipe->get_opens_at();
        $count = 0;
        foreach ($open_at as $at){

            $row_add = $adds[$at][0];
            $column_add = $adds[$at][1];
            $this->open_locations = array($location[0] + $row_add, $location[0] + $column_add);
        }
    }
    public function get_open_locations(){
        return $this->open_locations;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_pipes(){
        return $this->pipes;
    }
}