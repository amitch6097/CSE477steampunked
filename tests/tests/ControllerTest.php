?>
<?php
require __DIR__ . "/../../vendor/autoload.php";


/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class GameTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct() {
        $game = new Steampunked\Game("Jerry", "Kyle");
        $controller = new Steampunked\Controller($game, array());

        $this->assertInstanceOf('Steampunked\Controller', $controller);
        $this->assertFalse($controller->isReset());
    }

    public function test_reset() {
        $game = new Steampunked\Game("Jerry", "Kyle");
        $controller = new Steampunked\Controller($game, array('clear' => ''));

        $this->assertTrue($controller->isReset());
    }

    public function test_rotate() {
        $game = new Steampunked\Game("Jerry", "Kyle");
        $pipe_image_1 = $game->get_bottom_pipes()[0]->get_image();
        $pipe_image_2 = $game->get_bottom_pipes()[1]->get_image();
        $pipe_image_3 = $game->get_bottom_pipes()[2]->get_image();
        $pipe_image_4 = $game->get_bottom_pipes()[3]->get_image();
        $pipe_image_5 = $game->get_bottom_pipes()[4]->get_image();

        $controller = new Steampunked\Controller($game, array('rotate' => '', 'pipe' => '0'));
        $pipe_image_after_rotate_1 = $game->get_bottom_pipes()[0]->get_image();
        $pipe_image_after_rotate_2 = $game->get_bottom_pipes()[1]->get_image();
        $pipe_image_after_rotate_3 = $game->get_bottom_pipes()[2]->get_image();
        $pipe_image_after_rotate_4 = $game->get_bottom_pipes()[3]->get_image();
        $pipe_image_after_rotate_5 = $game->get_bottom_pipes()[4]->get_image();

        //only pipe 1 should be changed
        $this->assertNotEquals($pipe_image_1, $pipe_image_after_rotate_1);
        $this->assertEquals($pipe_image_2, $pipe_image_after_rotate_2);
        $this->assertEquals($pipe_image_3, $pipe_image_after_rotate_3);
        $this->assertEquals($pipe_image_4, $pipe_image_after_rotate_4);
        $this->assertEquals($pipe_image_5, $pipe_image_after_rotate_5);
    }

}

/// @endcond
?>














