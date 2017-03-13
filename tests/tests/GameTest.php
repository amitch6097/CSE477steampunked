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
        $game = new \Steampunked\Game("kyle", "jerry");
        $this->assertInstanceOf('Steampunked\Game', $game);
    }

    public function test_get_name() {
        $game = new \Steampunked\Game("kyle", "jerry");
        $this->assertContains("kyle", $game->get_name());
        $game->submit("0,0", 0);
        $this->assertContains("jerry", $game->get_name());
    }

    public function test_get_open(){
        $game = new \Steampunked\Game("kyle", "jerry");
        $open = $game->get_open_from_player();
        $this->assertCount(2, $open);

        $this->assertCount(1, $open[0]);
        $this->assertArrayHasKey("0,1", $open[0]);
        $this->assertContainsOnlyInstancesOf('Steampunked\Pipe',$open[0]);
        $this->assertInstanceOf('Steampunked\Pipe', $open[0]["0,1"]);

        $this->assertCount(1, $open[1]);
        $this->assertArrayHasKey("5,1", $open[1]);
        $this->assertContainsOnlyInstancesOf('Steampunked\Pipe',$open[0]);
        $this->assertInstanceOf('Steampunked\Pipe', $open[1]["5,1"]);
    }
}

/// @endcond
?>
