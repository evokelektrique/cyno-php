<?php 
namespace App\Controllers;

// Core 
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

// Models
use App\Models\KeysModel;
use App\Models\UserModel;
use App\Models\SharedModel;
use App\Models\PasswordModel;
use App\Models\WebsiteModel;
// Third-Party
use Hashids\Hashids;

class Shared extends BaseController {

	protected $keys_model;
	protected $user_model;
	protected $password_model;
	protected $website_model;

	public function __construct() {
		$this->keys_model 		= new KeysModel();
		$this->user_model 		= new UserModel();
		$this->password_model 	= new PasswordModel();
		$this->website_model 	= new WebsiteModel();
		$this->model 	  		= new SharedModel();
		$this->hashids 	  		= new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
	}

	public function index($type) {
		switch ($type) {
			case 'me':
				$passwords = $this->model
					->where('receiver_id', $this->session->user['id'])
					->findAll();
				$data = [
					'session' 	=> $this->session,
					'passwords'	=> $passwords,
					'title' 	=> lang('cyno.dashboard_shared_me'),
					'time' => new Time(),
				];
				return view('dashboard/shared/index', $data);
				break;
			case 'others':
				$passwords = $this->model->where('user_id', $this->session->user['id'])->findAll();
				$data = [
					'session' 	=> $this->session,
					'passwords'	=> $passwords,
					'title' 	=> lang('cyno.dashboard_shared_others'),
					'time' => new Time(),
				];
				// var_dump($passwords);
				return view('dashboard/shared/index', $data);
				break;

			default:
				break;
		}
	}


	public function show_me($hash_id) {
		$id = $this->hashids->decode($hash_id);
		if(!empty($id)) {
			$password = $this->model->where('id', $id)->first();
			if($password) {
				// Sender user for Decryption (Fetching Public-Key)
				$sender_user = $this->user_model->where('id', $password->user_id)->first();
				// Get Website
				$website = $this->website_model
					->where('id', $password->website_id)
					->first();
				// Response Data
				$data = [
					'session' 		=> $this->session,
					'password' 		=> $password,
					'sender_user'	=> $sender_user,
					'website' 		=> $website,
				];
				return view('dashboard/shared/show', $data);
			} else {
				echo "not found";
			}
		} else {
			echo "not found";
		}
	}


	public function create() {
		try {	
			if($this->request->isAjax()) {
				// Input data
				$input_data 	= $this->request->getJSON();

				// Receiver user
				$receiver_user 	= $this->user_model
					->where('email', $input_data->user_email)
					->first();

				// Finding Password
				$password = $this->password_model
					->where('user_id', $this->session->user['id'])
					->where('id', $this->hashids->decode($input_data->password_id))
					->first();

				// Validate password(if it's empty)
				if(empty($password)) {
					return json_encode(['status' => 'fail', 'message' => 'Password not found']);
				}

				// Insertion Data
				$model_data = [
					'cipher' 				=> $input_data->cipher,
					'nonce' 				=> $input_data->nonce,
					'user_id' 				=> $this->session->user['id'],
					'receiver_id' 			=> $receiver_user->id,
					'website_id'  			=> $password->website_id,
					'title'  				=> $password->title,
					'hash' 					=> $password->hash,
					'inputs_hash'  			=> $password->inputs_hash,
					'inputs_preimage_hash'  => $password->inputs_preimage_hash,
				];

				// Insertion ID
				$insert_id = $this->model->insert($model_data);

				if($insert_id) {
					// Sending Response
					$response   = [
						'cipher' 		=> $input_data->cipher,
						'nonce' 		=> $input_data->nonce,
						'user_id' 		=> $this->session->user['id'],
						'receiver_id' 	=> $receiver_user->id,
						'csrf' 			=> csrf_hash()
	 				];
					return json_encode($response);
				} else { // Fail condition
					return json_encode(['status' => 'fail', 'message' => 'operation failed']);
				}
			} else { // Fail condition
				return json_encode(['status' => 'fail', 'message' => 'not ajax!']);
			}
		} catch (\Exception $e) {
			var_dump($this->hashids->decode($input_data->password_id));
			var_dump($password);
			die($e->getMessage()); // DEBUG
		}
	}



	public function get_bytes() {
		if($this->request->isAjax()) {
			try {	
				$input_data = $this->request->getJSON();
				$receiver_user = $this->user_model->where('email', $input_data->user_email)->first();
				$receiver_keys = $this->keys_model->where('user_id', $receiver_user->id)->first();
				if(empty($receiver_keys)) {
					return json_encode(['error' => 'keys not found']);
				}
				$sender_user = $this->user_model->where('id', $this->session->user['id'])->first();
				$sender_keys = $this->keys_model->where('user_id', $sender_user->id)->first();
				if(empty($sender_keys)) {
					return json_encode(['error' => 'keys not found']);
				}
				$response = [
					'pk' => $receiver_keys->public_key,
					'cipher' => $sender_keys->secret_key,
					'salt' => $sender_keys->salt,
					'nonce' => $sender_keys->nonce,
					'difficulty' => $sender_keys->difficulty,
				];
				return json_encode($response);
			} catch (\Exception $e) {
				var_dump($sender_keys, $receiver_keys);
				die($e->getMessage());
			}
		} else {
			return json_encode(['status' => 'fail', 'message' => 'not ajax']);
		}
	}

	public function decryption_bytes() {
		if($this->request->isAjax()) {
			try {	
				$input_data = $this->request->getJSON();
				$receiver_user = $this->user_model->where('email', $input_data->user_email)->first();
				$receiver_keys = $this->keys_model->where('user_id', $receiver_user->id)->first();
				if(empty($receiver_keys)) {
					return json_encode(['error' => 'keys not found']);
				}
				$sender_user = $this->user_model->where('id', $this->session->user['id'])->first();
				$sender_keys = $this->keys_model->where('user_id', $sender_user->id)->first();
				if(empty($sender_keys)) {
					return json_encode(['error' => 'keys not found']);
				}
				$shared 	 = $this->model->where('cipher', $input_data->cipher)->first();
				$response = [
					'pk' => $receiver_keys->public_key,
					'cipher' => $sender_keys->secret_key,
					'salt' => $sender_keys->salt,
					'nonce' => $sender_keys->nonce,
					'box_nonce' => $shared->nonce,
					'difficulty' => $sender_keys->difficulty,
				];
				return json_encode($response);
			} catch (\Exception $e) {
				var_dump($sender_keys, $receiver_keys);
				die($e->getMessage());
			}
		} else {
			return json_encode(['status' => 'fail', 'message' => 'not ajax']);
		}
	}

}



