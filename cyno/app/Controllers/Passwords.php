<?php namespace App\Controllers;

///////////////
// Libraries //
///////////////

// Core
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

// Models
use \App\Models\PasswordModel;
use \App\Models\FolderModel;

// Third-Party
use Hashids\Hashids;

class Passwords extends BaseController {

	protected $model;
	protected $category_model;
	protected $hashids;

	public function __construct() {
		$this->model = new PasswordModel();
		$this->folder_model = new FolderModel();
		$this->hashids = new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
	}

	public function index() {
		$passwords = $this->model->where('user_id', $this->session->user['id'])->findAll();
		$data = [
			'session' => $this->session,
			'passwords' => $passwords,
			'time' => new Time()
		];

		return view('dashboard/passwords/index',$data);


		// $data = [
		// 	'masterkey' 	=> 'mymasterkey',
		// 	'masterkey_ad' 	=> 'ad',
		// 	'cipher_text' 	=> 'mysecurepassword',
		// 	'user_id' => 1
		// ];

		// $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);


		

		// // Bob keys
		// $key_pair2 = sodium_crypto_box_keypair();
		// $public_key2 = sodium_crypto_box_publickey($key_pair2);
		// $secret_key2 = sodium_crypto_box_secretkey($key_pair2);

		// $encryption_key = sodium_crypto_box_keypair_from_secretkey_and_publickey(
		// 	$secret_key1, 
		// 	$public_key2
		// );
		// $msg = "Hello Bob!";
		// $encrypted = sodium_crypto_box($msg, $nonce, $encryption_key);

		// echo base64_encode($encrypted) . "<br>";

		// // Bob decrypting
		// $decryption_key = sodium_crypto_box_keypair_from_secretkey_and_publickey(
		// 	$secret_key2, 
		// 	$public_key1
		// );
		// $decrypted = sodium_crypto_box_open($encrypted, $nonce, $decryption_key);
		// echo $decrypted . "\n";



		// $vault = new Vault();
		// $encrypted = $vault->encrypt($data);
		// echo "User Input data: <br>";
		// var_dump($data);
		// echo('Encrypted stuff:<br>');
		// var_dump($encrypted);
	}


	public function new() {
		// $categories = (array)$this->category_model->where('user_id', $this->session->user['id'])->orderBy('id','desc')->findAll();
		// $categories = array_column($categories, 'title', 'hash_id');
		// $default_category = (array)$this->category_model->where('user_id', $this->session->user['id'])->where('is_default', 1)->findAll();
		// $default_category = array_column($default_category, 'hash_id');
		// $folder = new \stdClass;
		// $folder->is_home = true;

		$folders = (array)$this->folder_model
			->select('*')
			->where('user_id', $this->session->user['id'])
			->findAll();

		$multiselect_folders = array_column($folders, 'title', 'hash_id');
		$multiselect_folders['0'] = 'root'; // Root folder


		$data = [
			'session' 			 	=> $this->session,
			// 'folder' 			=> $folder,
			'multiselect_folders'	=> $multiselect_folders,
			// 'difficulty_options' 	=> $difficulty_options
		];
		return view('dashboard/passwords/new',$data);
	}
	 
	











	public function create() {
		if($this->request->isAjax()) {

			// Inputs data
			$input_data = $this->request->getJSON();
			$model_data = [
				'title'      => $input_data->title,
				'salt'       => $input_data->salt,
				'nonce'      => $input_data->nonce,
				'cipher'     => $input_data->cipher,
				'difficulty' => $input_data->difficulty,
				'user_id'    => $this->session->user['id']
			];
			if(strlen($input_data->folder_id) == 1) {
				if($input_data->folder_id == 0) {
					$model_data['folder_id'] = $input_data->folder_id;
				} else {
					return json_encode(['status' => "fail"]);
				}
			} else {
				$model_data['folder_id'] = $this->hashids->decode($input_data->folder_id);
			}
			// $insert_id = false;
			$insert_id = $this->model->insert($model_data);
			$response = [];
			if($insert_id) {
				$response['message'] = "success";
				$response['cipher'] = $input_data->cipher;
				$response['request'] = json_encode($input_data);
			} else {
				$response['message'] = "failed";
			}
			$response['csrf'] = csrf_hash();

			echo json_encode($response);

		// // Validation data
		// $validation = \Config\Services::validation();
		// if(!$validation->run($data, 'password_create')) {
		// 	$this->session->setFlashdata('errors', $validation->getErrors());
		// 	return json_encode(['alert', ['status' => 'FAIL', 'message' => 'validation failed']]);
		// }

		// // Encrypting Data
		// $vault = new Vault();
		// $encrypted = $vault->encrypt($data);

		// // Loading Model
		// $model_data = [
		// 	'salt' => $encrypted['config']['salt'],
		// 	'nonce' => $encrypted['config']['nonce'],
		// 	'cipher' => $encrypted['encrypted'],
		// 	'user_id' => $this->session->user['id'],
		// 	'folder_id' => $this->hashids->decode($data['folder'])
		// ];
		
		// // Inserting data
		// $insert_id = $this->model->insert($model_data);
		// if($insert_id > 0) {
		// 	// Inserting category batch
		// 	return redirect()->route('dashboard_passwords')->with('alert', [
		// 		'status' => 'SUCCESS',
		// 		'message'=> 'Password Successfully created.'
		// 	]);
		// } else {
		// 	return redirect()->route('dashboard_passwords')->with('alert', [
		// 		'status' => 'FAIL',
		// 		'message'=> 'Operation Failed.'
		// 	]);
		// }		
		} else {
			echo json_encode(["message" => 'not ajax']);
		}
	}









































	public function show($hash_id) {
		$_hash_id = $this->hashids->decode($hash_id);
		// $categories = $this->category_model
		// 	->select('*')
		// 	->join('password_category', 'categories.id = password_category.category_id')
		// 	->where('password_id', $_hash_id)
		// 	->findAll();

		$password = $this->model->where('user_id', $this->session->user['id'])->where('hash_id', $hash_id)->first();
		$data = [
			'session' => $this->session,
			'password' => $password,
			// 'categories' => $categories
		];

		if(!empty($password)) {
			return view('dashboard/passwords/show', $data);
		} else {
			return redirect()->route('dashboard_passwords')->with('alert', [
				'status' => 'SUCCESS',
				'message' => 'Password successfully deleted'
			]);
		}

	}

	public function edit($hash_id) {
		$id = $this->hashids->decode($hash_id);
		$password = $this->model
			->where('id', $id)
			->where('user_id', $this->session->user['id'])->first();
		// Password Not Found
		if(empty($password)) {
			return $this->response->setStatusCode(404, "Password Not Found");
		}
		$data = [
			'session'  => $this->session,
			'password' => $password,
		];
		return view('dashboard/passwords/edit', $data);
	}


	public function update($hash_id) {
		// Decode ID
		$id = $this->hashids->decode($hash_id);

		// Incomming PUT Data
		$input_data = [
			'title' => $this->request->getPost('title'),
		];

		// Find Password
		$password = $this->model
			->where('id', $id)
			->where('user_id', $this->session->user['id'])->first();

		// Password Not Found
		if (empty($password)) {
			return redirect('dashboard_folders')->with('alert', [
				'status' => 0,
				'message' => lang('cyno.password_not_found')
			]);
		}

		// Update Password
		$updated_password = $this->model
			->where('id', $id)
			->where('user_id', $this->session->user['id'])
			->set($input_data)
			->update();

		if($updated_password) {
			return redirect()->back()->with('alert', [
				'status'  => 1,
				'message' => lang('cyno.password_updated')
			]);
		}

		// Update Operation Failed
		return redirect()->back()->with('alert', [
			'status'  => 0,
			'message' => lang('cyno.password_not_updated')
		]);
	}


	public function delete($hash_id) {
		// Decode ID
		$id = $this->hashids->decode($hash_id);

		// Find Password
		$password = $this->model
			->where('id', $id)
			->where('user_id', $this->session->user['id'])->first();
			
		// Password Not Found
		if(empty($password)) {
			return redirect('dashboard_folders')->with('alert', [
				'status' => 0,
				'message' => lang('cyno.password_not_found')
			]);
		}

		// Delete Password
		$deleted_password = $this->model->delete($id);
		
		// Successfully Deleted
		if($deleted_password) {
			return redirect('dashboard_folders')->with('alert', [
				'status' => 1,
				'message' => lang('cyno.password_deleted')
			]);
		}

		// Delete Operation Failed
		return redirect('dashboard_folders')->with('alert', [
			'status' => 0,
			'message' => lang('cyno.password_not_deleted')
		]);
	}






	public function get_bytes($hash_id) {
		if($this->request->isAjax()) {
			$id = $this->hashids->decode($hash_id);
			$bytes = $this->model->select(['nonce','salt','cipher'])->where('id', $id)->first();
			$response = [
				'salt' => $bytes->salt,
				'nonce' => $bytes->nonce,
				'cipher' => $bytes->cipher
			];
			return json_encode($response);
		} else {
			return json_encode(["message" => 'Not ajax']);
		}
	}




	// public function get_salt($hash_id) {
	// 	if($this->request->isAjax()) {
	// 		$password = $this->model
	// 			->select(['hash_id','salt'])
	// 			->where('hash_id', $hash_id)
	// 			->first();
	// 		if(!empty($password)) {
	// 			echo json_encode($password);
	// 		} else {
	// 			echo json_encode(["message" => 'password not found']);
	// 		}
	// 	} else {
	// 		echo json_encode(["message" => 'command not found']);
	// 	}
	// }

	public function decrypt($hash_id) {
		if($this->request->isAjax()) {
			$password = $this->model
				->select('*')
				->where('hash_id', $hash_id)
				->first();
			if(!empty($password)) {
				$data = $this->request->getJSON();
				$decrypted = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt(
					base64_decode($password->cipher),
					$data->masterkey_ad,
					base64_decode($password->nonce),
					base64_decode($data->key)
				);
				echo json_encode(['decrypted' => $decrypted]);
			} else {
				echo json_encode(["message" => 'password not found']);
			}

		} else {
			echo json_encode(["message" => 'command not found']);
		}
	} 







}