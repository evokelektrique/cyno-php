<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     			=> \CodeIgniter\Filters\CSRF::class,
		'toolbar'  			=> \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' 			=> \CodeIgniter\Filters\Honeypot::class,
		'authentication' 	=> \App\Filters\Authentication::class,
		'is_logged_in' 		=> \App\Filters\IsLoggedIn::class,
		'keys' 				=> \App\Filters\Keys::class,
		'jwtauth' 			=> \App\Filters\JWT_Auth::class
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			//'honeypot'
			// 'csrf',
			'authentication' => ['except' => ['/', 'auth*', 'api*']],
			'is_logged_in' => ['except' => ['/', 'dashboard*']],
			'keys' => [
				'dashboard*', 
				'except' => [
					'dashboard/setup*', 
					'dashboard/profile/logout',
					'/',
					'/auth*',
					'jobs*',
					'api*'
				]
			]

		],
		'after'  => [
			// 'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [];
}
