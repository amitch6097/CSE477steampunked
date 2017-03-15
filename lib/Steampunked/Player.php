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
    private $end_location;
    private $grid_size;
    private $end;


    function __construct($name, $size, $end){
        $this->name = $name;
        $this->grid_size = $size;
        $this->end = $end;
    }

    public function update_end($end_pipes){
        $this->pipes[$this->end[0]] = $end_pipes[2];
        $this->pipes[$this->end[1]] = $end_pipes[1];
        $this->pipes[$this->end[2]] = $end_pipes[0];
    }

    public function add_pipe($location, $pipe){
        $this->pipes[$location] = $pipe;
        $this->update_open($location);
    }

    private function update_open($location){
        $add_to = array(array(0, 1), array(1, 0), array(0, -1), array(-1, 0));

        if (count($this->pipes) == 3){
            $location_array = explode(",", $location);
            $new_row = intval($location_array[0]) + $add_to[0][0];
            $new_col = intval($location_array[1]) + $add_to[0][1];
            $open_location = "$new_row,$new_col";
            $this->open_locations[$open_location] = new \Steampunked\Smoke(2);

        } else if (count($this->pipes) > 3) {
            $last_add = $this->pipes[$location];

            $pipe_location = $this->open_locations[$location]->get_connects_to()[0];
            unset($this->open_locations[$location]);

            foreach($last_add->get_opens_at() as $open){
                if($open == -1 ||  $pipe_location == $open){ //cap pipe or open side is where a pipe is
                    continue;
                }
                $location_array = explode(",", $location);
                $new_row = intval($location_array[0]) + $add_to[$open][0];
                $new_col = intval($location_array[1]) + $add_to[$open][1];
                $this->open_locations["$new_row,$new_col"] = new \Steampunked\Smoke((($open+2)%4));
            }
        } else {
            $location_array = explode(",", $location);
            $new_row = intval($location_array[0]) + $add_to[2][0];
            $new_col = intval($location_array[1]) + $add_to[2][1];
            $this->end_location = "$new_row,$new_col";
            return;
        }
    }

    public function does_it_connect($row_column, $pipe, $other_players_pipes){
        $add_to = array(array(0, 1), array(1, 0), array(0, -1), array(-1, 0));
        $location_array = explode(",", $row_column);
        $connector = $this->open_locations[$row_column]->get_connects_to()[0];

        //if it is a smoke location
        if(isset($this->open_locations[$row_column])){
            //if it connects to the smoke location
            if(in_array($this->open_locations[$row_column]->get_connects_to()[0], $pipe->get_connects_to())){

                //if all connections are in the grid
                $connections = $pipe->get_connects_to();
                foreach ($connections as $connection) {

                    $nrow = intval($location_array[0]) + $add_to[$connection][0];
                    $ncol = intval($location_array[1]) + $add_to[$connection][1];

                    //pipe does not open to empty row
                    if($connection == $connector){
                        continue;
                    }

                    else if ($nrow >= $this->grid_size or $nrow < 0) {
                        return false;
                    }
                    //pipe does not open to empty column
                    else if ($ncol > $this->grid_size + 1 or $ncol < 0) {
                        return false;
                    }
                    //pipe does not open to own pipe
                    else if (isset($this->pipes["$nrow,$ncol"])){
                        $open_ar = $this->pipes["$nrow,$ncol"]->get_opens_at();
                        if (in_array((($connection+2)%4), $open_ar)){
                            continue;
                        }
                        return false;
                    }
                    //pipe does not open to another players pipes
                    else if (isset($other_players_pipes["$nrow,$ncol"])){
                        return false;
                    }
                }
                return true;
            }
        }
        return false;
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

    public function remove_smoke($location){
        unset($this->open_locations[$location]);
    }

    public function done(){
        if(sizeof($this->open_locations) == 0 && in_array($this->end_location, array_keys($this->pipes))){
            if (in_array(0, $this->pipes[$this->end_location]->get_opens_at())){
                return true;
            }
        }
        return false;
    }
}