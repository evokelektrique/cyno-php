<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\KeysModel;
use App\Models\UserModel;

class Setup extends BaseController
{
	protected $user_model;
	protected $keys_model;

	public function __construct() {
		$this->user_model = new UserModel();
		$this->keys_model = new KeysModel();
	}

	public function index()
	{
		$difficulty_options = [
			'0' => lang('cyno.difficulty_interactive'), 
			'1' => lang('cyno.difficulty_moderate'), 
			'2' => lang('cyno.difficulty_sensitive'), 
		];
		$data = [
			'session' => $this->session,
			'difficulty_options' => $difficulty_options
		];
		return view('dashboard/setup/index', $data);
	}

	public function validation() {
		if($this->request->isAjax()) {
			try {
					
				$input_data = $this->request->getJSON();
				$model_data = [
					'public_key' 	=> $input_data->pk,
					'secret_key' 	=> $input_data->sk_encrypted,
					'salt' 			=> $input_data->salt,
					'nonce' 		=> $input_data->nonce,
					'difficulty'	=> $input_data->difficulty,
					'user_id' 		=> $this->session->user['id']

				];
				if(empty($this->keys_model->where('user_id', $this->session->user['id'])->findAll())) {
					$key_id = $this->keys_model->insert($model_data);
					if($key_id) {
						$user_id = $this->user_model->update($this->session->user['id'], ['key_id' => $key_id]);
						return json_encode(['status' => 'SUCCESS', 'message' => 'keys generated successfully']);
					} else {
						return json_encode(['status' => 'fail', 'message' => 'operation failed']);
					}
				} else {
					return json_encode(['status' => 'warning', 'message' => 'duplicate']);
				}

			} catch (\Exception $e) {
				var_dump($input_data);
				die($e->getMessage());
			}



		// // Saving keys
		// $data = [
		// 	'public_key' 	=> $keys['public_key'],
		// 	'secret_key' 	=> base64_encode($cipher_text),
		// 	'nonce' 		=> base64_encode($config['nonce']),
		// 	'salt' 			=> base64_encode($config['salt']),
		// 	'user_id' 		=> $this->session->user['id']
		// ];

		// $key_id = $this->keys_model->insert($data);
		// $user_id = $this->user_model->update($this->session->user['id'], ['key_id' => $key_id]);
		// if($user_id > 0) {
		// 	return redirect()->route('dashboard')->with('alert', [
		// 		'status' => 'SUCCESS',
		// 		'message' => [base64_encode($key), base64_encode($keys['secret_key'])]
		// 		// M9RTjURrscea+9y4mJwuD/QlSKsodAfdDQ3IFlBQj+0=
		// 	]);
		// }

		} else {
			return json_encode(['status' => 'fail', 'message' => 'not Ajax']);
		}

	}

}