?>
<?php
require __DIR__ . "/../../vendor/autoload.php";


/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */
class PipesTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct() {
        $pipes = new \Steampunked\Pipes();
        $this->assertInstanceOf('Steampunked\Pipes', $pipes);
    }

    public function test_return_random(){
        $pipes = new \Steampunked\Pipes();
        $this->assertInstanceOf('Steampunked\Pipes', $pipes);

        $pipe = $pipes->return_random();
        $this->assertInstanceOf('Steampunked\Pipe', $pipe);
    }
    public function test_start_pipes(){
        $pipes = new \Steampunked\Pipes();
        $this->assertInstanceOf('Steampunked\Pipes', $pipes);

        $start_pipes = $pipes->start_pipes();
        //there are 3 starting pipes
        $this->assertArrayHasKey(0, $start_pipes);
        $this->assertArrayHasKey(1, $start_pipes);
        $this->assertArrayHasKey(2, $start_pipes);
    }

    public function test_smoke(){
        $pipes = new \Steampunked\Pipes();
        $this->assertInstanceOf('Steampunked\Pipes', $pipes);

        $smoke = $pipes->smoke();
        $this->assertInstanceOf('Steampunked\Pipe', $smoke);
    }
}

/// @endcond
?>
