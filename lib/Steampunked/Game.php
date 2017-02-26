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
    private $player1;
    private $player2;
    private $players;

    private $current_player;

    private $pipes;
    private $update_pipes;
    private $bottom_pipes;

    public function __construct()
    {
        $this->pipes = new \Steampunked\Pipes();

        $this->players = array();
        $this->players[] = new \Steampunked\Player("jerry");
        $this->players[] = new \Steampunked\Player("carl");
        $this->current_player = 0;

        $starter_pipes = $this->pipes->start_pipes();

        $new_pipes1 = $this->players[0]->initalize_pipes(1, $starter_pipes);
        $new_pipes2 = $this->players[1]->initalize_pipes(2, $starter_pipes);

        $this->update_pipes = array_merge($new_pipes1, $new_pipes2);

        $this->bottom_pipes = array($this->make_bottom_pipes(),$this->make_bottom_pipes());
    }

    private function make_bottom_pipes(){
        $bottom_pipes = array();
        for($i=0;$i<5;$i++){
            $bottom_pipes[] = $this->pipes->return_random();
        }
        return $bottom_pipes;
    }

    public function get_bottom_pipes(){
        return $this->bottom_pipes[$this->current_player];
    }

    public function get_update_pipes(){
        return $this->update_pipes;
    }
    public function get_name(){
        return $this->players[$this->current_player]->get_name();
    }

    public function rotate($num){
        $this->bottom_pipes[$this->current_player][$num]->rotate();
    }
    public function discard($num){
        $this->bottom_pipes[$this->current_player][$num] = $this->pipes->return_random();
    }
    public function open_valve(){
        pass;
    }
    public function submit($row_column, $num){
        $row_column_array = explode(",", $row_column);
        $this->update_pipes[] = array($row_column_array, $this->bottom_pipes[$this->current_player][$num]);
        $this->discard($num);
        $this->change_turn();
    }
    private function change_turn(){
        $this->current_player = ($this->current_player + 1) % 2;
    }

}