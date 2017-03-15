<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/25/17
 * Time: 12:34 PM
 */

namespace Steampunked;


class StartController
{
    private $reset = false;
    private $page = "index.php";

    public function __construct($game, $post)
    {
        if(isset($post['start_game'])) {
            if(isset($post['name1'])  and isset($post['name2'])){
                $size = $post['size'];

                $name1 = $post['name1'];
                $name2 = $post['name2'];

                $game->construct($name1, $name2, intval($size));

                $this->page = "steampunked.php";
            } else {

            }
        }
    }
    public function getPage(){
        return $this->page;
    }
}