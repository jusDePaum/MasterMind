<?php

abstract class Model_AbstractGame implements Repository_Persistable
{
    const SAVE_GAME_STATUS = "gameStatus";
    const SAVE_MOVES = "moves";
    const SAVE_CONFIG = "config";
    const CONFIG_NB_PLAYERS = "nbPlayers";
    const CONFIG_BOARD_SIZE = "boardSize";

    protected Model_StatutPartie $gameStatus;
    protected array $moves;
    protected array $config;

    /**
     * Initializes the game with different rules
     * @param int|null $boardSize
     * @param int|null $nbPlayers
     * @param array|null $config
     * @return void
     */
    public final function initGame(?int $boardSize, ?int $nbPlayers, ?array $config): void
    {
        // save Config
        static::saveConfig($config);
        // init players
        static::initPlayers($nbPlayers);
        // init board
        static::initBoard($boardSize);
    }

    protected function saveConfig(?array $config): void
    {
        $this->config = $config;
    }
    protected function initPlayers($nbPlayers): void{
        $this->config[static::CONFIG_NB_PLAYERS] = $nbPlayers;
    }
    protected function initBoard(?int $boardSize): void
    {
        $this->config[static::CONFIG_BOARD_SIZE] = $boardSize;
        $this->gameStatus = Model_StatutPartie::EnCours;
        $this->moves = [];
    }

    /**
     * Called after a move to record it
     * @param string|null $move
     * @return void
     */
    public function playMove(?string $move): void
    {
        $this->moves[] = $move;
    }

    /**
     * Checks the win condition. Returns a boolean whether it's a win or not
     * @param $move
     * @return void
     */
    abstract public function checkWin($move): array|bool;

    public function serialize(): array{
        return [static::SAVE_GAME_STATUS => $this->gameStatus, static::SAVE_CONFIG => $this->config, static::SAVE_MOVES => $this->moves];
    }
    static public function unserialize(array $data): static
    {
        $game = new static();
        $game->gameStatus = $data[static::SAVE_GAME_STATUS];
        $game->config = $data[static::SAVE_CONFIG];
        $game->moves = $data[static::SAVE_MOVES];
        return $game;
    }

    public function getGameStatus(): Model_StatutPartie
    {
        return $this->gameStatus;
    }

    public function setGameStatus(Model_StatutPartie $gameStatus): void
    {
        $this->gameStatus = $gameStatus;
    }

    public function getMoves(): array
    {
        return $this->moves;
    }

    public function setMoves(array $moves): void
    {
        $this->moves = $moves;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}