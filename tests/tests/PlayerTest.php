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
        $player = new \Steampunked\Player("kyle");
        $this->assertInstanceOf('Steampunked\Player', $player);

        $this->assertContains('kyle', $player->get_name());
        $this->assertArrayNotHasKey(0, $player->get_open_locations());
        $this->assertCount(0, $player->get_open_locations());
        $this->assertCount(0, $player->get_pipes());
        $this->assertArrayNotHasKey(0, $player->get_pipes());
    }

    public function test_add_pipe(){
        $player = new \Steampunked\Player("kyle");
        $this->assertInstanceOf('Steampunked\Player', $player);

        $pipes = new \Steampunked\Pipes();
        $player->add_pipe("0,0", $pipes->return_random());
        $this->assertArrayHasKey("0,0", $player->get_pipes());
        $this->assertCount(1, $player->get_pipes());
    }

    public function test_get_open_locations() {
        $game = new \Steampunked\Game("kyle", "Jake");
        $first_player = $game->get_current_player();
        $this->assertInstanceOf('Steampunked\Player', $first_player);

        //players start with 3 pipes
        $this->assertArrayHasKey("1,7", $first_player->get_pipes());
        $this->assertArrayHasKey("0,7", $first_player->get_pipes());
        $this->assertArrayHasKey("0,0", $first_player->get_pipes());
        $this->assertCount(3, $first_player->get_pipes());

        //with one open location
        $this->assertArrayHasKey("0,1", $first_player->get_open_locations());
        $this->assertCount(1, $first_player->get_open_locations());

        //put the first pipe in bottom pipes in the grid
        $game->submit("0,1", 0);
        $this->assertArrayNotHasKey("0,1", $first_player->get_open_locations());

        //changes the players turn
        $second_player = $game->get_current_player();
        $this->assertInstanceOf('Steampunked\Player', $second_player);

        $this->assertArrayHasKey("4,7", $second_player->get_pipes());
        $this->assertArrayHasKey("3,7", $second_player->get_pipes());
        $this->assertArrayHasKey("5,0", $second_player->get_pipes());
        $this->assertCount(3, $second_player->get_pipes());

        $this->assertArrayHasKey("5,1", $second_player->get_open_locations());
        $this->assertCount(1, $second_player->get_open_locations());

        $game->submit("5,1", 0);
        $this->assertArrayNotHasKey("5,1", $first_player->get_open_locations());
    }

}

/// @endcond
?>
