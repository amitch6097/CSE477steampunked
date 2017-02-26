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
    private $smoke;
    private $update_pipes; //Pipes to add to the view
    private $bottom_pipes; //Array of Arrays [player1 bottom_pipes, player2 bottom_pipes]

    public function __construct($name1, $name2)
    {
        //add pipes object
        $this->pipes = new \Steampunked\Pipes();

        //make an array of both player objects
        $this->players = array();
        $this->players[] = new \Steampunked\Player($name1);
        $this->players[] = new \Steampunked\Player($name2);
        $this->current_player = 0; //current player is the first player

        //intalize both players starting pipes
        $starter_pipes = $this->pipes->start_pipes();
        $new_pipes1 = $this->players[0]->initalize_pipes(1, $starter_pipes);
        $new_pipes2 = $this->players[1]->initalize_pipes(2, $starter_pipes);
        $this->update_pipes = array_merge($new_pipes1, $new_pipes2); //add it to pipes to update

        //setup the bottom pipes for both players
        $this->bottom_pipes = array($this->make_bottom_pipes(),$this->make_bottom_pipes());
        $this->smoke = array(array(), array());
        $this->update_smoke(0);
        $this->update_smoke(1);
    }
    private function update_smoke($player){
        $open_locations = $this->players[$player]->get_open_locations();
        foreach ($open_locations as $open) {
            $this->smoke[$player][] = array($open, $this->pipes->smoke());
        }
    }

    public function get_open(){
        $next_player = (($this->current_player + 1)%2);
        $both = array();
        $both[0]  = $this->smoke[$this->current_player];
        $both[1] = $this->smoke[$next_player];
        return $both;
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

    public function get_update_pipes(){
        /**
         * Returns the pipes that need to be added to the grid
         * @return array [[row, column], pipe object]
         */
        return $this->update_pipes;
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
        pass;
    }
    public function submit($row_column, $num){
        /**
         * $row_column, is the selected button on the grid
         * $num is the selected pipe from bottom pipes
         * adds the selected pipe to the grid, removes the pipe from
         * bottom pipes, and changes the turn
         */
        $row_column_array = explode(",", $row_column);
        $pipe_to_add = $this->bottom_pipes[$this->current_player][$num];

        $this->update_pipes[] = array($row_column_array, $pipe_to_add);
        $this->remove_from_smoke($row_column_array);

        $this->players[$this->current_player]->add_pipe($row_column_array, $pipe_to_add);
//        $this->update_smoke($this->current_player);
        $this->discard($num);

    }
    private function change_turn(){
        /**
         * changes the current player
         */
        $this->current_player = ($this->current_player + 1) % 2;
    }

    private function remove_from_smoke($el){
        $row_column = $el[0];
        $current_smoke = $this->smoke[$this->current_player];
        $i  = array_search($row_column, $current_smoke);
        unset($current_smoke[$i]);
        $this->smoke[$this->current_player] = $current_smoke;
    }

}