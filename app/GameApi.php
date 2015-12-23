<?php

namespace App;

class GameApi
{
    private $chars = [];

    public static function startNew()
    {
        return self::getStatus(Game::startNew());
    }

    public static function guess($id, $char)
    {
        try {
            $response = self::getStatus(Game::guess($id, $char));
        } catch (\App\Exceptions\BaseGameException $e) {
            $response = self::getStatus($e->getGame(), $e->getMessage());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $response = json_encode(['error' => 'Game not found!']);
        }
        return $response;
    }

    public static function getStatus($game, $error = null)
    {
        return (new ApiResponse($game, $error))->render();
    }
}
