<?php

namespace App;

use \App\Exceptions\CharacterUsedException;
use \App\Exceptions\GameOverException;
use \App\Exceptions\GameWonUsedException;

class GameApi
{
    private $chars	= [];

    static function startNew()
    {
        return self::getStatus(Game::startNew());
    }

    static function guess($id, $char)
	{
        try {
            $response = self::getStatus(Game::guess($id, $char));
        } catch (\App\Exceptions\BaseGameException $e) {
            $response = self::getStatus($e->getGame(), $e->getMessage());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e ) {
            $response = json_encode(['error' => 'Game not found!']);
        }
        return $response;
	}

	static function getStatus($game, $error = NULL) {
        return (New ApiResponse($game, $error))->render();
    }
}