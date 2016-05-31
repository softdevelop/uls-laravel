<?php
 
return [

	/*
	|--------------------------------------------------------------------------
	| Default Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the connections below you wish to use as
	| your default connection for all work. Of course, you may use many
	| connections at once using the manager class.
	|
	*/

	'default' => 'main',

	/*
    |--------------------------------------------------------------------------
    | Pusher Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

	'connections' => [

		'main' => [
			'auth_key' => env('pusher_auth_key', '0f0a9c0664b5af4b7e6d'),
			'secret' => env('pusher_secret', '25a844c59511a845833d'),
			'app_id' => env('pusher_app_id', '120104'),
			'options' => [],
			'host' => null,
			'port' => null,
			'timeout' => 0.0001
		],

		'alternative' => [
			'auth_key' => '0f0a9c0664b5af4b7e6d',
			'secret' => '25a844c59511a845833d',
			'app_id' => '120104',
			'options' => [],
			'host' => null,
			'port' => null,
			'timeout' => 0.0001
		],

	]

];
