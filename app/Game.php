<?php

namespace App;

use \App\Exceptions\CharacterUsedException;
use \App\Exceptions\GameWonException;
use \App\Exceptions\GameOverException;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid;
use Requests;

class Game extends Model
{
	use HasUuid;

    const MASK_CHAR = '.';

	const MAX_TRIES = 6;

	// Switch between database and API for word generation/selection
    //      1 - Use word-table in database,
    //      0 - will use API on SetGetGo
    const USE_DATABASE = 0;

	const BUSY 		= 0;
	const FAIL 		= 1;
	const SUCCESS 	= 2;
	private $statusInformation = [ "busy", "fail", "success" ];

	protected $table = 'game';

	public $incrementing = false;
    public $timestamps = false;

	protected $fillable = ['word'];

	protected $casts = [
		'characters_guessed' => 'array'
	];

	public function __construct(Array $attributes = []) {
		$attributes['word'] = $this->getRandomWord();
		return parent::__construct($attributes);
	}

	public function getStatusAttribute($value)
	{
		return $this->statusInformation[$value];
	}


	public static function startNew()
	{
		$game = New self;
		$game->tries_left 			= self::MAX_TRIES;
		$game->word 				= $game->getRandomWord();
		$game->status 				= self::BUSY;
		$game->characters_guessed 	= [];
		$game->save();
		return $game;
	}

	static function guess($id, $char)
	{
		$game = Game::where('status', self::BUSY)->findOrFail($id);
		$chars = $game->characters_guessed;

		if(in_array(strtolower($char), $chars)) {
            throw (new CharacterUsedException($char .' has already been used'))->setGame($game);
        }

        if (strpos($game->word, $char) === false) $game->tries_left--;

        $chars[] = $char;
        $game->characters_guessed = $chars;

        if ($game->won()) {
            $game->status = self::SUCCESS;
            $game->save();
            throw (new GameWonException('Congratulations! ' . $game->word . ' is the correct word.'))->setGame($game);
        }

        if($game->tries_left <= 0) {
            $game->status = self::FAIL;
            $game->save();
            throw (new GameOverException('You lost. The word was: '. $game->word))->setGame($game);
        }

        $game->save();

        return $game;
	}

	private function getRandomWord()
	{
        if (self::USE_DATABASE == 0)
        {
            $request = Requests::get('http://randomword.setgetgo.com/get.php');
            return strtolower($request->body);
        }

        return \App\Word::orderBy(\DB::raw('RAND()'))->first()->word;
	}

	public function getWord() {
		$chars = $this->characters_guessed;
    	$invalidChars = array_diff(range('a', 'z'), $chars);
        $word = str_replace($invalidChars, self::MASK_CHAR, $this->word);
    	return $word;
    }

    public function won()
    {
    	return strpos($this->getWord(), self::MASK_CHAR) === false;
    }
}