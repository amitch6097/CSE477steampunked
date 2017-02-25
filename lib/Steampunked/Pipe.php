<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/24/17
 * Time: 8:34 PM
 */

namespace Steampunked;


class Pipe{

    /**
     * an array of strings, with image file locations of all orientations,
     * Example, array("ninety-es.png", "ninety-sw.png", "ninety-wn.png", "ninety-ne.png");
     * An index will later be used to maintain a position in this array
     * thus when we want to rotate we will just add 1 to the index, moving the file string
     * to the next image
     */
    private $file_names;

    /**
     * Array of Arrays, where is the pipe, used to track leaks?
     * Each array in the array coresponds exactly to the image file string's properties
     * Thus the index we used earlier to rotate the file image, will help
     * us maintain the properties that each image has as well
     */
    private $open_at;

    private $connects_to; //Array of Arrayswhere the pipe is open as well kind of, used to track where we can place the next pipe
    private $current; //current orientation of the pipe

    public function __construct($file_names, $open_at, $connects_to)
    {
        $this->file_names = $file_names;
        $this->open_at = $open_at;
        $this->connects_to = $connects_to;

        //always start with a random orientation
        $this->current = rand(0, (sizeof($file_names)-1));
    }

    //adds 1 to current, which is the index talked about earlier
    public function rotate(){
        $this->current = (($this->current+1)%sizeof($this->file_names));
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