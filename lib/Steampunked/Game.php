<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/25/17
 * Time: 2:45 PM
 */

namespace Steampunked;


class Game
{
    private $players; // array of players
    private $current_player; // integer, index for use in $players

    private $pipes; // Pipes Object
    private $update_pipes; //Pipes to add to the view
    private $bottom_pipes; //Array of Arrays [player1 bottom_pipes, player2 bottom_pipes]
    private $open;
    private $size_of_grid;

    public function construct($name1, $name2, $size)
    {
        $this->size_of_grid = $size;
        $this->open = false;
        //add pipes object
        $this->pipes = new \Steampunked\Pipes();

        $middle = $size/2; //3
        $top = $middle-3; // 3-3
        $top2 = $middle-2; //2
        $bottom = $middle+2;
        $bottom2 = $middle+1;
        $end = $size + 1;

        $player1_end = array("$top,$end", "$top2,$end", "$top,0");
        $player2_end = array("$middle,$end", "$bottom2,$end", "$bottom,0");

        //make an array of both player objects
        $this->players = array();
        $this->players[] = new \Steampunked\Player($name1, $size, $player1_end);
        $this->players[] = new \Steampunked\Player($name2, $size, $player2_end);
        $this->current_player = 0; //current player is the first player

        //intalize both players starting pipes
        $starter_pipes = $this->pipes->start_pipes();

        $this->players[0]->add_pipe("$top,$end", $starter_pipes[2]);
        $this->players[0]->add_pipe("$top2,$end", $starter_pipes[1]);
        $this->players[0]->add_pipe("$top,0", $starter_pipes[0]);

        $this->players[1]->add_pipe("$middle,$end", $starter_pipes[2]);
        $this->players[1]->add_pipe("$bottom2,$end", $starter_pipes[1]);
        $this->players[1]->add_pipe("$bottom,0", $starter_pipes[0]);

        //setup the bottom pipes for both players
        $this->bottom_pipes = array($this->make_bottom_pipes(),$this->make_bottom_pipes());
    }

    public function get_open_from_player(){
        $this->update_smoke();

        $next_player = (($this->current_player + 1)%2);
        $both = [];
        $both[] = $this->players[$this->current_player]->get_open_locations();
        $both[] = $this->players[$next_player]->get_open_locations();

        return $both;
    }

    private function update_smoke(){
        foreach (array_keys($this->players[0]->get_open_locations()) as $location){
            if(in_array($location, array_keys($this->players[0]->get_pipes()))){
                $this->players[0]->remove_smoke($location);
            }
            if (in_array($location, array_keys($this->players[1]->get_pipes()))){
                $this->players[1]->remove_smoke($location);
            }
        }
        foreach (array_keys($this->players[1]->get_open_locations()) as $location){
            if(in_array($location, array_keys($this->players[0]->get_pipes()))){
                $this->players[0]->remove_smoke($location);
            }
            if (in_array($location, array_keys($this->players[1]->get_pipes()))){
                $this->players[1]->remove_smoke($location);
            }
        }
    }

    private function make_bottom_pipes(){
        /**
         * Returns 5 random pipes in an array
         * @return array
         */
        $bottom_pipes = array();
        for($i=0;$i<5;$i++){
            $bottom_pipes[] = $this->pipes->return_random();
        }
        return $bottom_pipes;
    }

    public function get_bottom_pipes(){
        /**
         * Returns the bottom pipes of the current player
         * @return array
         */
        return $this->bottom_pipes[$this->current_player];
    }

    public function get_pipes(){
        /**
         * Returns the pipes that need to be added to the grid
         * @return array [[row, column], pipe object]
         */
//        return $this->update_pipes;
        $ret  = [];
        foreach(array_keys($this->players[0]->get_pipes()) as $key){
            if($key != '0'){
                $ret[$key] = $this->players[0]->get_pipes()[$key];
            }
        }
        foreach(array_keys($this->players[1]->get_pipes()) as $key){
            if($key != '0') {
                $ret[$key] = $this->players[1]->get_pipes()[$key];
            }
        }
        return $ret;
    }
    public function get_name(){
        /**
         * @return String, the current player's name
         */
        return $this->players[$this->current_player]->get_name();
    }

    public function rotate($num){
        /**
         * Rotates the selected pipe from bottom pipes, given by $num
         */
        $this->bottom_pipes[$this->current_player][$num]->rotate();
    }
    public function discard($num){
        /**
         * Discards the selected pipe from bottom pipes, given by $num
         */
        $this->bottom_pipes[$this->current_player][$num] = $this->pipes->return_random();
        $this->change_turn();
    }
    public function open_valve(){
        if ($this->get_current_player()->done()){
            return true;
        } else {
            return false;
        }
    }
    public function submit($row_column, $num){

        $pipe_to_add = $this->bottom_pipes[$this->current_player][$num];
        $next_player_pipes = $this->players[(($this->current_player+1)%2)]->get_pipes();

        if ($this->players[$this->current_player]->does_it_connect($row_column, $pipe_to_add, $next_player_pipes)){
            $this->players[$this->current_player]->add_pipe($row_column, $pipe_to_add);
            if ($this->get_current_player()->done()){
                $this->get_current_player()->update_end($this->pipes->end_pipes());
            }
            $this->discard($num);
        }
    }

    public function change_turn(){
        /**
         * changes the current player
         */
        $this->current_player = ($this->current_player + 1) % 2;
    }

    public function get_current_player(){
        return $this->players[$this->current_player];
    }

    public function get_message(){
    $name = $this->get_name();
    return "$name it is your turn.";
    }

    public function get_size(){
        return $this->size_of_grid;
    }

}