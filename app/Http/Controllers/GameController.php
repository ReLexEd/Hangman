<?php

namespace App\Http\Controllers;
use \App\GameApi;

class GameController extends Controller
{
    function startNewGame()
	{
		return GameApi::startNew();
	}

	function guess($id, $letter)
	{
		return GameApi::guess($id, $letter);
	}


}
