<?php

namespace App\Http\Controllers;
use \App\GameApi;
use Illuminate\Http\Request;

class GameController extends Controller
{
    function startNewGame()
	{
        return GameApi::startNew();
	}

	function guess($id, Request $request)
	{
        $char = $request->input('character');
		return GameApi::guess($id, $char);
	}


}
