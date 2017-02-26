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
    private $model;

    /**
     * $size is the size of the grid you want to make ie.
     * $size = 6 for 6X6 grid
     * @return HTML string
     */
    public function __construct($model)
    {
        $this->model = $model;
        $this->grid = $this->make_grid($this->size);
    }

    private function make_grid($size){
        $html = array();
        for($row=0; $row<$size;$row++) {
            $width = $this->make_rows($size, $row);
            $html[] = $width;
        }
        return $html;
    }

    private function make_rows($size, $row){
        $html = array();
        for($column=0; $column<$size+2;$column++) {
            $html[] = <<<HTML
<input type="submit" name="leak" value="$row,$column">
HTML;
        }
        return $html;
    }

    private function get_grid(){
        $html = '';

        foreach($this->grid as $row){
            $row_html = '';
            foreach($row as $column){
                $row_html .= <<<HTML
<div class="cell">
    $column
</div>
HTML;
            }
            $html .= <<<HTML
<div class="row">
    $row_html
</div>
HTML;
        }
        return $html;
    }

    public function update_view(){
        $pipes_to_add = $this->model->get_update_pipes();
        foreach($pipes_to_add as $pipe){
            $location = $pipe[0]; //[row, column]
            $row = $location[0];
            $column = $location[1];

            $pipe_object = $pipe[1];
            $pipe_image = $pipe_object->get_image();

            $new_element = <<<HTML
<img src="images/$pipe_image" alt="$pipe_image">
HTML;
            $this->grid[$row][$column] = $new_element;
        }
    }

    /**
     * Returns a message of whose turn it is
     * @return HTML string
     */
    private function message(){
        $name = $this->model->get_name();
        $html = <<<HTML
<p>$name it is your turn!</p>
HTML;
        return $html;
    }

    private function get_images(){
        $pipes = $this->model->get_bottom_pipes();
        $files = array();
        foreach($pipes as $pipe){
            $files[] = $pipe->get_image();
        }
        return $files;
    }

    /**
     * Returns the bottom part of the view
     * The message, the pipe pictures, and buttons
     * @return HTML string
     */
    private function bottom_view(){
        $message = $this->message();
        $files = $this->get_images();
        $html = <<<HTML
$message
<div class="pipe_pictures">
    <img src="images/$files[0]" alt="$files[0]"><input type="radio" value="0" name="pipe">
    <img src="images/$files[1]" alt="$files[1]"><input type="radio" value="1" name="pipe">
    <img src="images/$files[2]" alt="$files[2]"><input type="radio" value="2" name="pipe">
    <img src="images/$files[3]" alt="$files[3]"><input type="radio" value="3" name="pipe">
    <img src="images/$files[4]" alt="$files[4]"><input type="radio" value="4" name="pipe">
</div>
<div class="pipe_buttons">
    <input type="submit" name="rotate" value="Rotate">
    <input type="submit" name="discard" value="Discard">
    <input type="submit" name="open_valve" value="Open Valve">
    <input type="submit" name="clear" value="Give Up">
</div>
HTML;
        return $html;
    }

    /**
     * Returns the whole view
     * Grid and bottom part of the view
     *
     * @return HTML string
     */
    public function present(){
        $this->update_view();
        $grid = $this->get_grid();
        $bottom = $this->bottom_view();
        $html = <<<HTML
<form method="post" action="steampunked-post.php">
   <div class="game">
        $grid
    </div>
    $bottom
</form>
HTML;
        return $html;
    }
}