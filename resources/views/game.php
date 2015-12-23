<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Hangman API - VueJS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="assets/hangman.css">
</head>
<body>
	<div id="hangman">

		<h1>VueJS/Canvas Hangman via API</h1>

		<div id="game">

			<canvas id="canvas" width="300" height="280"></canvas>

			<div class="testWord">{{ game.word }}</div>

			<div v-show="game.id" class="keyboard">
				<div>
					<button @click="guess()">a</button>
					<button @click="guess()">b</button>
					<button @click="guess('c')">c</button>
					<button @click="guess('d')">d</button>
					<button @click="guess('e')">e</button>
					<button @click="guess('f')">f</button>
					<button @click="guess('g')">g</button>
				</div>
				<div>
					<button @click="guess('h')">h</button>
					<button @click="guess('i')">i</button>
					<button @click="guess('j')">j</button>
					<button @click="guess('k')">k</button>
					<button @click="guess('l')">l</button>
					<button @click="guess('m')">m</button>
					<button @click="guess('n')">n</button>
				</div>
				<div>
					<button @click="guess('o')">o</button>
					<button @click="guess('p')">p</button>
					<button @click="guess('q')">q</button>
					<button @click="guess('r')">r</button>
					<button @click="guess('s')">s</button>
					<button @click="guess('t')">t</button>
					<button @click="guess('u')">u</button>
				</div>
				<div>
					<button @click="guess('v')">v</button>
					<button @click="guess('w')">w</button>
					<button @click="guess('x')">x</button>
					<button @click="guess('y')">y</button>
					<button @click="guess('z')">z</button>
				</div>
			</div>
		</div>

		<button v-show="!game.id" class="startNew" @click="startNewGame">Start New Game</button>

		<div v-if="game.status == 'fail'" @click="startNewGame" class="gameOver">
			<h2>{{ game.error }}</h2>
			<h3>Click this box to try again.</h3>
		</div>

		<div v-if="game.status == 'success'" @click="startNewGame" class="youWon">
			<h2>{{ game.error }}</h2>
			<h3>You are doing great! Click this box to play again.</h3>
		</div>

	</div>

	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/vue/1.0.12/vue.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/vue-resource/0.5.1/vue-resource.js"></script>
	<script type="text/javascript" src="assets/hangman.js"></script>
</body>
</html>