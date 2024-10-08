<?php

abstract class Model_AbstractGame
{
    /**
     * Initializes the game with different rules
     * @param $boardSize
     * @return void
     */
    public function initGame($boardSize){

    }

    /**
     * Called after a move to record it
     * @return void
     */
    public function playMove(){

    }

    /**
     * Checks the win condition. Returns a boolean whether it's a win or not
     * @param $move
     * @return bool
     */
    public function checkWin($move){

    }
}