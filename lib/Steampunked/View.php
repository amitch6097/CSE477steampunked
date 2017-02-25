<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/24/17
 * Time: 2:00 PM
 */

namespace Steampunked;

class View
{
    private $size = 6; //default grid size is 6X6

    /**
     * $size is the size of the grid you want to make ie.
     * $size = 6 for 6X6 grid
     * @return HTML string
     */
    public function __construct($size)
    {
        $this->pipes = new Pipes();
        $this->size = $size;
    }

    /**
     * Creates a  html string of class cells based on width
     * @return HTML string
     */
    private function width($size, $row){
        $html = '';
        for($column=-1; $column<=$size;$column++) {
            $html .= <<<HTML
<div class="cell"><input type="submit" name="leak" value="$row, $column"></div>
HTML;
        }
        return $html;
    }

    /**
     * Creates a  html string of rows based on $size with cells inside
     * @return HTML string
     */
    private function height($size){
        $html = '';
        for($row=0; $row<$size;$row++) {
            $width = $this->width($size, $row);
            $html .= <<<HTML
<div class="row">
    $width
</div>
HTML;
        }
        return $html;
    }

    /**
     * Returns a message of whose turn it is
     * @return HTML string
     */
    private function message(){
        $html = <<<HTML
<p>Charles it is your turn!</p>
HTML;
        return $html;
    }

    ////////
    //THE PIPES NEEDS TO COME FROM THE MODEL
    ///////


    /**
     * A junk work around to get random images on the view pre Model class
     * @return HTML string
     */
    private function get_images(){
        $html = '';

        for($num = 0; $num < 4; $num++){
            $file = $this->pipes->return_random()->get_image();
            $html .= <<<HTML
<img src="images/$file" alt="$file"><input type="radio" name="pipe_$num">
HTML;
        }
        return $html;
    }

    /**
     * Returns the bottom part of the view
     * The message, the pipe pictures, and buttons
     * @return HTML string
     */
    private function bottom_view(){
        $message = $this->message();
        $images = $this->get_images();
        $html = <<<HTML
$message
<div class="pipe_pictures">
    $images
</div>
<div class="pipe_buttons">
    <input type="button" name="rotate" value="Rotate">
    <input type="button" name="discard" value="Discard">
    <input type="button" name="open_valve" value="Open Valve">
    <input type="button" name="give_up" value="Give Up">
</div>
HTML;
        return $html;
    }

    /**
     * Returns the whole view
     * Grid and bottom part of the view
     * @return HTML string
     */
    public function present(){

        $grid = $this->height($this->size);
        $bottom = $this->bottom_view();
        $html = <<<HTML
<form ...>
   <div class="game">
        $grid
    </div>
    $bottom
</form>
HTML;
        return $html;
    }
}