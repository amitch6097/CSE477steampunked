<?php
/**
 * Created by PhpStorm.
 * User: Sndrew
 * Date: 2/24/17
 * Time: 6:32 PM
 */

namespace Steampunked;


/**
 * Pipes is a Class to hold the properties to make any pipe that we need
 * the Pipe class explains the properties of a pipe
 */
class Pipes
{
    /**
     * Returns a Pipe instance with cap properties
     * @return Pipe Object
     */
    private function make_cap(){
        //cap_file_names is all possible orientations of a cap image
        $cap_file_names = array("cap-e.png", "cap-s.png", "cap-w.png", "cap-n.png");

        //cap_open_at is an array of arrays with where the pipe will be left open
        //this will be used to keep track of where we can put a new pipe/leak/
        //cap_open_at and cap_connects_to are kind of the same
        /*
         *    3
         * 2[img]0
         *    1
         */
        $cap_open_at = array(array(-1), array(-1), array(-1), array(-1));
        $cap_connects_to = array(array(0), array(1), array(2), array(3));

        return new Pipe($cap_file_names, $cap_open_at, $cap_connects_to);
    }

    private function make_ninety(){
        $ninety_file_names = array("ninety-es.png", "ninety-sw.png", "ninety-wn.png", "ninety-ne.png");
        $ninety_open_at = array(array(0, 1), array(1, 2), array(2, 3), array(3, 0));
        $ninety_connects_to = array(array(0,1), array(1, 2), array(2, 3), array(3, 0));

        return new Pipe($ninety_file_names, $ninety_open_at, $ninety_connects_to);
    }
    private function make_straight(){
        $straight_file_names = array("straight-h.png", "straight-v.png");
        $straight_open_at = array(array(0,2), array(1, 3));
        $straight_connects_to = array(array(0,2), array(1, 3));

        return new Pipe($straight_file_names, $straight_open_at, $straight_connects_to);
    }

    private function make_tee(){
        $tee_file_names = array("tee-esw.png", "tee-swn.png", "tee-wne.png", "tee-nes.png");
        $tee_open_at = array(array(0, 1, 2), array(1, 2, 3), array(2, 3, 0), array(1, 0, 3));
        $tee_connects_to = array(array(0, 1, 2), array(1, 2, 3), array(2, 3, 0), array(3, 0, 1));

        return new Pipe($tee_file_names, $tee_open_at, $tee_connects_to);
    }

    /**
     * returns a random pipe of any type
     */
    public function return_random(){
        $make_array = array($this->make_cap(), $this->make_straight(), $this->make_ninety(), $this->make_tee());
        $random_number = rand(0, sizeof($make_array)-1);

        return $make_array[$random_number];
    }

    public function start_pipes(){
        $pipes = [];
        $pipes[] = new Pipe(array("valve-closed.png"), array(array(0)), array(array(0)));
        $pipes[] = new Pipe(array("gauge-0.png"), array(array(2)), array(array(2)));
        $pipes[] = new Pipe(array("gauge-top-0.png"), array(array(-1)), array(array(-1)));
        return $pipes;
    }
    public function end_pipes(){
        $pipes = [];
        $pipes[] = new Pipe(array("valve-open.png"), array(array(0)), array(array(0)));
        $pipes[] = new Pipe(array("gauge-190.png"), array(array(2)), array(array(2)));
        $pipes[] = new Pipe(array("gauge-top-190.png"), array(array(-1)), array(array(-1)));
        return $pipes;
    }
    public function smoke(){
         return new Pipe(array("leak-e.png", "leak-s.png", "leak-w.png", "leak-n.png"), array(array(0,1,2,3), array(0,1,2,3), array(0,1,2,3), array(0,1,2,3)), array(array(0), array(1), array(2), array(3)));
    }
}
