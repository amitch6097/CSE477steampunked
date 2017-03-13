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
    private $grid;

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
            <div class="empty"></div>
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
        $pipes_to_add = $this->model->get_pipes();
        $pipes_to_add_keys = array_keys($pipes_to_add);
        foreach($pipes_to_add_keys as $location){
            $location_array  = explode(",", $location);
            $row = $location_array[0]; //"rows,column"
            $column = $location_array[1];
            $pipe_object = $pipes_to_add[$location];
            $pipe_image = $pipe_object->get_image();

            $new_element = <<<HTML
<img src="images/$pipe_image" alt="$pipe_image">
HTML;
            $this->grid[$row][$column] = $new_element;
        }
    }
    public function update_smoke(){
        $smoke_to_add = $this->model->get_open_from_player();
        $current_player_smoke = $smoke_to_add[0];
        $other_player_smoke = $smoke_to_add[1];


        foreach(array_keys($current_player_smoke) as $location){

            $location_array  = explode(",", $location);
            $row = $location_array[0]; //"rows,column"
            $column = $location_array[1];
            $pipe_object = $current_player_smoke[$location];
            $pipe_image = $pipe_object->get_image();

            $new_element = <<<HTML
<input type="submit" name="leak" value="$row,$column" style="background-image: url('images/$pipe_image') ;">
HTML;
            $this->grid[$row][$column] = $new_element;
        }
        foreach(array_keys($other_player_smoke) as $location){
            if ($location == '0'){
                continue;
            }

            $location_array  = explode(",", $location);
            $row = $location_array[0]; //"rows,column"
            $column = $location_array[1];
            $pipe_object = $other_player_smoke[$location];
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
        $message = $this->model->get_message();
        $html = <<<HTML
<p>$message</p>
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
        $this->update_smoke();
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