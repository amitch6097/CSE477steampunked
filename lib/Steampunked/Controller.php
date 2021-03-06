<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/25/17
 * Time: 12:34 PM
 */

namespace Steampunked;


class Controller
{
    private $game;
    private $reset = false;
    private $page = 'steampunked.php';

    public function __construct(Game $game, $post)
    {
        $this->game = $game;
        if(isset($post['clear'])) {
            $this->game->change_turn();
            $this->page = 'win.php';
        }
        else if(isset($post['rotate'])) {
            if(isset($post['pipe'])){ //get the value of selected pipe
                $value = $post['pipe'];
                $this->game->rotate($value);
            }
        }
        else if(isset($post['discard'])) {
            if(isset($post['pipe'])){ //get the value of selected pipe
                $value = $post['pipe'];
                $this->game->discard($value);
            }
        }
        else if(isset($post['open_valve'])) {
            if($this->game->open_valve()){
                $this->page = 'win.php';
            }
        }
        else if(isset($post['leak'])) { //get the value of selected grid button
            if(isset($post['pipe'])){ //get the value of selected pipe
                $value = $post['pipe'];
                $this->game->submit(strip_tags($post['leak']), $value);
            }
        }
    }
    public function isReset(){
        return $this->reset;
    }
    public function getPage(){
        return $this->page;
    }
}