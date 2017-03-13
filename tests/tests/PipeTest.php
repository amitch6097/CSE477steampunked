?>
<?php
require __DIR__ . "/../../vendor/autoload.php";


/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PipeTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct() {
        $straight_file_names = array("straight-h.png", "straight-v.png");
        $straight_open_at = array(array(0,2), array(1, 3));
        $straight_connects_to = array(array(0,2), array(1, 3));

        $pipe = new Steampunked\Pipe($straight_file_names, $straight_open_at, $straight_connects_to);
        $this->assertInstanceOf('Steampunked\Pipe', $pipe);

        //pipe has an image
        $this->assertContains(".png", $pipe->get_image());

        //pipe should have two arrays open at inside its get open
        $this->assertArrayHasKey(0, $pipe->get_opens_at());
        $this->assertArrayHasKey(1, $pipe->get_opens_at());
        //as well as connects to
        $this->assertArrayHasKey(0, $pipe->get_connects_to());
        $this->assertArrayHasKey(1, $pipe->get_connects_to());
    }

    public function test_rotate()
    {
        $straight_file_names = array("straight-h.png", "straight-v.png");
        $straight_open_at = array(array(0, 2), array(1, 3));
        $straight_connects_to = array(array(0, 2), array(1, 3));

        //get current
        $pipe = new Steampunked\Pipe($straight_file_names, $straight_open_at, $straight_connects_to);
        $pipe_image = $pipe->get_image();
        $pipe_connect = $pipe->get_connects_to();
        $pipe_open = $pipe->get_opens_at();

        //rotate the pipe
        $pipe->rotate();

        //get new
        $new_pipe_image = $pipe->get_image();
        $new_pipe_connect = $pipe->get_connects_to();
        $new_pipe_open = $pipe->get_opens_at();

        //make sure old and new are not the same
        $this->assertNotEquals($pipe_image, $new_pipe_image);
        $this->assertNotEquals($pipe_connect, $new_pipe_connect);
        $this->assertNotEquals($pipe_open, $new_pipe_open);
    }

    public function test_get_image(){
        $straight_file_names = array("straight-h.png", "straight-v.png");
        $straight_open_at = array(array(0,2), array(1, 3));
        $straight_connects_to = array(array(0,2), array(1, 3));

        $pipe = new Steampunked\Pipe($straight_file_names, $straight_open_at, $straight_connects_to);
        $this->assertInstanceOf('Steampunked\Pipe', $pipe);

        $this->assertContains(".png", $pipe->get_image());
        $this->assertContains("straight-", $pipe->get_image());
    }
}

/// @endcond
?>
