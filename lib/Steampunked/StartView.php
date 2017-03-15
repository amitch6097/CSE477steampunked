<?php
/**
 * Created by PhpStorm.
 * User: wintonsea
 * Date: 2017/3/13
 * Time: 21:43
 */

namespace Steampunked;


class StartView
{
    public function __construct($game)
    {
        $this->model = $game;
    }

    private function start_title()
    {
        $start_title = <<<HTML
<p class = "title">STEAM PUNKED</p>
HTML;
        return $start_title;
    }

    private function name_start()
    {
        $info = <<<HTML
<article>
    <p><label for="name1">Player one:  </label><input type="text" name="name1" id="name1"></p>
    <p><label for="name2">Player two:  </label><input type="text" name="name2" id="name2"></p>
    <p><input type="submit"name="start_game" value="Start Game"></p>
    <div>
        <p>
         6x6<input type="radio" value="6" name="size">
        10x10<input type="radio" value="10" name="size">
        20x20<input type="radio" value="20" name="size">
        </p>
    </div>

</article>
HTML;
        return $info;
    }

    private function instruction()
    {
        $instruction = <<<HTML
<p><a href="Instruction.php">Instruction</a></p>
HTML;
        return $instruction;
    }

    public function Start_Present()
    {
        $start_title = $this->start_title();
        $name = $this->name_start();
        $instruction = $this->instruction();
        $html = <<<HTML
<form method="post" action="index-post.php">
    <div class="title">$start_title</div>
    <p>------------------------------------------</p>
    <div class="start_info">$name</div>
    <p>------------------------------------------</p>
    <div class ="link">$instruction</div>
</form>
HTML;
        return $html;
    }



##########  Instruction Part below   #########



    private function instruction_title()
    {
        $instruction_title = <<<HTML
<p class = "title">Instruction</p>
HTML;
        return $instruction_title;
    }

    private function instruction_info()
    {
        $instruction_info = <<<HTML
<div class = "instruction_info">
    <p>Hi! Welcome to Steampunked World!</p>
    <p>In this game, you can either play on your own, or play with your friend. Before you start, please enter your name(s). </p>
    <p>You need to add all pipes into the grid, and you have 5 kinds of pipes to choose.</p>
    <p>Click the rotate botton and the pipe you choose will rotate 90 degrees; you can rotate as many times as you wish; you can also change all 5 pipes by clicking on the Discard botton.</p>
    <p>With a pipe in your satisfied direction, you can now put it into the grid where there is steam.</p>
    <p>When you connect all the pipes, click Open Valve to check if the steam leaks.</p>
    <p>Good luck!</p>
</div>
HTML;
        return $instruction_info;
    }

    private function back_to_start()
    {
        $back_to_start = <<<HTML
<p><a href="index.php">Back To Start</a></p>
HTML;
        return $back_to_start;
    }

    public function Instruction_Present()
    {
        $instruction_title = $this->instruction_title();
        $instruction_info = $this->instruction_info();
        $back_to_start = $this->back_to_start();
        $html = <<<HTML
<form method="post" action="index-post.php">
    <div class="title">$instruction_title</div>
    <p>------------------------------------------</p>
    <div class="instruction_main">$instruction_info</div>
    <p>------------------------------------------</p>
    <div class ="link">$back_to_start</div>
</form>
HTML;
        return $html;
    }



    ##########  Win Page below   #########



    private function win_title()
    {
        $win_title = <<<HTML
<p class = "win_title">Final Result</p>
HTML;
        return $win_title;
    }

    private function win_info()
    {
        $name = $this->model->get_name();
        $win_info = <<<HTML
<p class = "win_info">$name WIN!</p>
HTML;
        return $win_info;
    }

    public function Win_Present()
    {
        $win_title = $this->win_title();
        $win_info = $this->win_info();
        $back_to_start = $this->back_to_start();
        $html = <<<HTML
<form method="post" action="index-post.php">
    <div class="title">$win_title</div>
    <p>------------------------------------------</p>
    <div class="instruction_main">$win_info</div>
    <p>------------------------------------------</p>
    <div class ="link">$back_to_start</div>
</form>
HTML;
        return $html;
    }
}