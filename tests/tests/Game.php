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
        $game = new \Steampunked\Game("kyle", "jerry");
        $this->assertInstanceOf('Steampunked\Game', $game);
	}

    public function test_get_name() {
        $game = new \Steampunked\Game("kyle", "jerry");
        $this->assertContains("kyle", $game->get_name());
        $game->submit("0,0", 0);
        $this->assertContains("jerry", $game->get_name());
    }
}

/// @endcond
?>
