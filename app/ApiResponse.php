<?php
namespace App;

class ApiResponse {
    private $game;

    private $error = [];

    function __construct(Game $game, $error = NULL)
    {
        $this->game = $game;
        if($error) {
            $this->error = ['error'  => $error];
        }
    }

    function render()
    {
        return [
            'id'            => $this->game->id,
            'tries_left'    => $this->game->tries_left,
            'word'          => $this->game->getWord(),
            'chars'         => $this->game->characters_guessed,
            'status'        => $this->game->status
        ] + $this->error;
    }
}
