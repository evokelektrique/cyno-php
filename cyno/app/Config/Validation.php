<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	// 
	// Rules
	// 

	public $register = [
		// Email Rules
		'email' => [
			'rules' => 'required|valid_email|trim|max_length[100]|is_unique[users.email]',
		],
		'password' => [
			'rules' => 'required|trim',
		]
	];

	public $register_errors = [
		// Email Errors
		'email' => [
			'required' 	=> 'email is required!',
			'is_unique' => 'email must be unique'
		],
		'password' => [
			'required' => 'Password is required !'
		],
	];


	public $login = [
		// Email Rules
		'email' => [
			'rules' => 'required|valid_email|trim|max_length[100]',
		],
		'password' => [
			'rules' => 'required|trim',
			'errors' => [
				'required' => 'Password is required !!!'
			]
		]
	];
	public $login_errors = [
		// Email Errors
		'email' => [
			'required' 	=> 'فیلد ایمیل اجباری می باشد',
		],
		// Password Errors
		'password' => [
			'required' => 'فیلد رمز عبور اجباری می باشد',
		]
	];

	public $settings = [
		'password' => [
			'rules' => 'required|trim',
			'errors' => [
				'required' => 'Passwrod is required !!!'
			]
		],
		'password_confirm' => [
			'rules' => 'required|trim|matches[password]',
			'errors' => [
				'required' => 'Passwrod is required !!!',
				'matches' => 'Passwords must match !!'
			]
		]
	];

	public $password_create = [
		'masterkey' => [
			'rules' => 'required|trim|min_length[5]|max_length[50]',
			'errors' => [
				'required' => 'masterkey is required !'
			]
		],
		'masterkey_ad' => [
			'rules' => 'required|trim|min_length[5]|max_length[50]',
			'errors' => [
				'required' => 'ad is masterkey_ad required'
			]
		],
		'cipher_text' => [
			'rules' => 'required|trim|min_length[1]|max_length[200]',
			'errors' => [
				'required' => 'password is required'
			]
		]
	];



	// public $category = [
	// 	'title' => [
	// 		'rules' => 'required|min_length[1]|max_length[50]',
	// 		'errors' => [
	// 			'required' => 'title is required'
	// 		]
	// 	],
	// 	'color' => [
	// 		'rules' => 'required|min_length[4]|max_length[8]',
	// 		'errors' => [
	// 			'required' => 'title is required'
	// 		]
	// 	],
	// ];

	public $folder_create = [
		'title' => [
			'rules' => 'required|min_length[1]|max_length[50]',
			'errors' => [
				'required' => 'Title is required'
			]
		],
	];




	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
