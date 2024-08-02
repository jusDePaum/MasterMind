<?php

namespace Model;

interface AbstractGame
{

    /**
     * @param $boardSize
     */
    public function initGame($boardSize); //Initializes the game with different rules

    /**
     * @param $move
     */
    public function playMove($move); //Called after a move, check a win condition by calling checkWin(), then record it in $datas

    /**
     * @param $move
     */
    public function checkWin($move); //Called by playMove(), checks the win condition after a move. Returns a boolean if it's either a win or not
}