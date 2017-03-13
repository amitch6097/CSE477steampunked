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

    public function __construct($name1, $name2)
    {
        $this->open = false;
        //add pipes object
        $this->pipes = new \Steampunked\Pipes();

        //make an array of both player objects
        $this->players = array();
        $this->players[] = new \Steampunked\Player($name1);
        $this->players[] = new \Steampunked\Player($name2);
        $this->current_player = 0; //current player is the first player

        //intalize both players starting pipes
        $starter_pipes = $this->pipes->start_pipes();

        $this->players[0]->add_pipe("0,7", $starter_pipes[2]);
        $this->players[0]->add_pipe("1,7", $starter_pipes[1]);
        $this->players[0]->add_pipe("0,0", $starter_pipes[0]);

        $this->players[1]->add_pipe("3,7", $starter_pipes[2]);
        $this->players[1]->add_pipe("4,7", $starter_pipes[1]);
        $this->players[1]->add_pipe("5,0", $starter_pipes[0]);

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
        $this->open = true;
    }
    public function submit($row_column, $num){

        $pipe_to_add = $this->bottom_pipes[$this->current_player][$num];

        if ($this->players[$this->current_player]->does_it_connect($row_column, $pipe_to_add)){
            $this->players[$this->current_player]->add_pipe($row_column, $pipe_to_add);
            $this->discard($num);
        }
    }
    private function change_turn(){
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
        if ($this->open && $this->get_current_player()->done()){

            return "$name you win!";
        }else{
            return "$name it is your turn.";
        }
    }

}