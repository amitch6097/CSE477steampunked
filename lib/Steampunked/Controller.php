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

    public function __construct(Game $game, $post)
    {
        $this->game = $game;
        if(isset($post['clear'])) {
            $this->reset = true;
        }
        else if(isset($post['rotate'])) {
            if(isset($post['pipe'])){
                $value = $post['pipe'];
                $this->game->rotate($value);
            }
        }
        else if(isset($post['discard'])) {
            if(isset($post['pipe'])){
                $value = $post['pipe'];
                $this->game->discard($value);
            }
        }
        else if(isset($post['open_valve'])) {
            $this->game->open_valve();
        }

        else if(isset($post['leak'])) {
            if(isset($post['pipe'])){
                $value = $post['pipe'];
                $this->game->submit(strip_tags($post['leak']), $value);
            }
        }

    }
    public function isReset(){
        return $this->reset;
    }
}