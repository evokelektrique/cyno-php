<?php namespace App\Controllers\Api\v1;

use CodeIgniter\Controller;
use App\Models\PasswordModel;
use App\Models\SharedModel;
use App\Models\WebsiteModel;
use App\Models\InputModel;
use App\Models\FolderModel;
use App\Models\UserModel;
use App\Models\KeysModel;
use Hashids\Hashids;


class Passwords extends ApiController {
	protected $password_model;
	protected $shared_model;
	protected $website_model;
	protected $form_model;
	protected $input_model;
	protected $user_model;
	protected $hashids;
	protected $keys_model;

	public function __construct() {
		$this->keys_model 		= new KeysModel();
		$this->password_model 	= new PasswordModel();
		$this->shared_model 	= new SharedModel();
		$this->website_model 	= new WebsiteModel();
		$this->input_model		= new InputModel();
		$this->folder_model		= new FolderModel();
		$this->user_model		= new UserModel();
		$this->hashids = new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
	}

	public function index() {
	}











	public function search() {
		try {
			$input_data = $this->request->getJSON();
			$passwords = [];

			// Get domain
			$website = $this->get_domain($input_data->url);
			if(empty($website) || $website === NULL) {
				return json_encode(['status' => 0, 'message' => 'website not found']);
			}
			$single_passwords = $this->password_model
				->select(['id', 'hash_id', 'hash', 'difficulty', 'folder_id', 'nonce', 'salt', 'cipher', 'created_at'])
				->where('user_id', $this->user->user_id)
				->where('inputs_preimage_hash', $input_data->inputs_preimage_hash)
				->where('website_id', $website->id)
				->findAll();

			$shared_passwords = $this->shared_model
				->select(['id', 'user_id', 'hash_id', 'hash', 'inputs_hash', 'inputs_preimage_hash', 'nonce', 'cipher', 'created_at'])
				->where('receiver_id', $this->user->user_id)
				->where('website_id', $website->id)
				->findAll();

			foreach($single_passwords as &$single_password) {
				$passwords[] = [
					'type' 		=> 'single',
					'password' 	=> $single_password,
					'inputs'   	=> $this->input_model->where('password_id', $single_password->id)->findAll(),
					'website' 	=> $website
				];
			}
			foreach($shared_passwords as &$shared_password) {
				$temp_password_shared_from = $this->password_model
					->where('hash', $shared_password->hash)
					->where('inputs_hash', $shared_password->inputs_hash)
					->where('inputs_preimage_hash', $shared_password->inputs_preimage_hash)
					->first();
				$passwords[] = [
					'type' 		=> 'shared',
					'password' 	=> $shared_password,
					'inputs'   	=> $this->input_model->where('password_id', $temp_password_shared_from->id)->findAll(),
					'website' 	=> $website,
					'sender'	=> $this->user_model->select(['hash_id', 'email'])->where('id', $shared_password->user_id)->first(),
				];
			}
			return json_encode($passwords);
		} catch(\Exception $e) {
			die($e);
		}
	}











	public function save_encrypted() {
		// if($this->request->isAjax()) {
			try {
				// Inputs data
				$input_data = $this->request->getJSON(true);
				
				// Decode folder ID
				if(is_integer($input_data['folder_id'])) {
					$folder_id = $input_data['folder_id'];
				} else {
					$folder_id = $this->hashids->decode($input_data['folder_id']);
				}

				// Check if folder is deleted
				$folder = $this->folder_model->find($folder_id);
				if(empty($folder)) {
					// Set folder ID to root
					$folder_id = 0;
				}
				$password_model_data = [
					'cipher' 				=> $input_data['cipher'],
					'folder_id' 			=> $folder_id,
					'user_id' 				=> $this->user->user_id,
					'nonce' 				=> $input_data['nonce'],
					'salt' 					=> $input_data['salt'],
					'hash' 					=> $input_data['hash'],
					'inputs_hash' 			=> $input_data['inputs_hash'],
					'inputs_preimage_hash' 	=> $input_data['inputs_preimage_hash'],
					'difficulty' 			=> $input_data['difficulty'],
				];

				// Check Website
				$tab = $input_data['analytics']['tab'];
				$website_data_check = [
					'user_id' 		=> $this->user->user_id,
					'url' 			=> $tab['sender_url'],
				];
				$website_data_insert = $website_data_check;
				$website_data_insert['title'] = $tab['title'];

				if(isset($tab['pending_url'])) {
					$website_data_insert['pending_url'] = $tab['pending_url'];
				}
				if(isset($tab['fav_icon_url'])) {
					$website_data_insert['fav_icon_url'] = $tab['fav_icon_url'];
				}
				$website = $this->website_model
					->select('id')
					->where($website_data_check)
					->first();
				if(empty($website) || $website == null) {
					$website_id = $this->website_model->insert($website_data_insert);
				} else {
					$website_id = $website->id;
				}
				$password_model_data['website_id'] = $website_id;

				// Check Password
				// $password = $this->password_model
				// ->where([
				// 	// 'hash' => $input_data['hash'],
				// 	'website_id' => $website_id,
				// 	'user_id' => $this->user->user_id
				// ])
				// ->first();
				// if(empty($password)) {
					// Insert Password
					$password_id = $this->password_model->insert($password_model_data);
				// } else {
				// 	$password_id = $password->id;
				// }
				// Insert Inputs
				if(!empty($input_data['form']['inputs'])) {
					foreach($input_data['form']['inputs'] as &$input) {
						$data = [
							'website_id' 	=> (int)$website_id,
							'name' 			=> $input['input_name'],
							'type' 			=> $input['input_type'],
							'value' 		=> $input['input_value'],
							'id_name' 		=> $input['input_id'],
							'class_name' 	=> $input['input_class'],
							'password_id' 	=> $password_id,
						];
						// $temp_input = $this->input_model->where($data)->first();
						// if(empty($temp_input)) {
							$this->input_model->insert($data);
						// }

						// } else {
						// 	$this->input_model->where('id', $temp_input->id)->update([
						// 		'website_id' 	=> (int)$password_model_data['website_id'],
						// 		'name' 			=> $input['input_name'],
						// 		'type' 			=> $input['input_type'],
						// 		'value' 		=> $input['input_value'],
						// 		'id_name' 		=> $input['input_id'],
						// 		'class_name' 	=> $input['input_class']
						// 	]);
					}
				}
				return json_encode(['message' => "success"]);
			} catch (\Exception $e) {
				die($e->getMessage());
			}
		// } else {
		// 	return json_encode(["message" => 'not ajax']);
		// }
	}



	public function exists() {
		$input_data = $this->request->getJSON();
		$website  = $this->get_domain($input_data->url);
		if(empty($website)) {
			return json_encode(['status' => TRUE]);
		} else {
			$password = $this->password_model->where([
				'hash' 					=> $input_data->password_hash,
				'inputs_hash' 			=> $input_data->inputs_hash,
				'inputs_preimage_hash' 	=> $input_data->inputs_preimage_hash,
				'website_id' 			=> $website->id,
			])->first();
			if(empty($password)) {
				return json_encode(['status' => TRUE]);
			} else {
				return json_encode(['status' => FALSE]);
			}
		}
	}


	public function shared_decryption_bytes() {
		try {	
			$input_data = $this->request->getJSON();
			$receiver_user = $this->user_model->where('id', $this->user->user_id)->first();
			$receiver_keys = $this->keys_model->where('user_id', $receiver_user->id)->first();
			if(empty($receiver_keys)) {
				return json_encode(['error' => 'keys not found']);
			}
			$sender_user_id = $this->hashids->decode($input_data->sender_hash_id);
			$sender_user 	= $this->user_model->where('id', $sender_user_id)->first();
			$sender_keys 	= $this->keys_model->where('user_id', $sender_user->id)->first();
			if(empty($sender_keys)) {
				return json_encode(['error' => 'keys not found']);
			}
			$shared = $this->shared_model->where('cipher', $input_data->cipher)->first();
			$response = [
				'pk' 			=> $receiver_keys->public_key,
				'cipher' 		=> $sender_keys->secret_key,
				'salt' 			=> $sender_keys->salt,
				'nonce' 		=> $sender_keys->nonce,
				'box_nonce' 	=> $shared->nonce,
				'difficulty' 	=> $sender_keys->difficulty,
			];
			return json_encode($response);
		} catch (\Exception $e) {
			// var_dump($sender_keys, $receiver_keys);
			die($e);
		}
	}



	// Get domain
	private function get_domain($url) {
		$website_url_input = $url;
		$website_url_input = trim($website_url_input, '/');
		if (!preg_match('#^http(s)?://#', $website_url_input)) {
		    $website_url_input = 'http://' . $website_url_input;
		}
		$urlParts = parse_url($website_url_input);
		$domain = preg_replace('/^www\./', '', $urlParts['host']);

		// Find website
		$website = $this->website_model->where('user_id', $this->user->user_id)->like('url', $domain)->first();
		return $website;
	}




} 