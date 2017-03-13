<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 3/13/17
 * Time: 1:12 AM
 */

namespace Steampunked;


class Smoke
{
    private $file_names;
    private $open_at;
    private $connects_to; //Array of Arrayswhere the pipe is open as well kind of, used to track where we can place the next pipe
    private $current; //current orientation of the pipe

    public function __construct($direction)
    {
        $this->file_names = array("leak-e.png", "leak-s.png", "leak-w.png", "leak-n.png");
        $this->open_at = array(array(0,1,2,3), array(0,1,2,3), array(0,1,2,3), array(0,1,2,3));
        $this->connects_to = array(array(0), array(1), array(2), array(3));

        //always start with a random orientation
        $this->current = $direction;
    }
    //uses the current index to find the current filename
    public function get_image(){
        return $this->file_names[$this->current];

    }
    //uses the current index to find the current property open_at
    public function get_opens_at(){
        return $this->open_at[$this->current];
    }
    //uses the current index to find the current property connect_to
    public function get_connects_to(){
        return $this->connects_to[$this->current];
    }

}