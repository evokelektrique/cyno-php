<?php namespace App\Controllers\Api\v1;

/////////////////////
// Status          //
// 0 = FASLE - BAD //
// 1 = TRUE - GOOD //
// 2 = WARNING     //
/////////////////////


use CodeIgniter\Controller;
use \Firebase\JWT\JWT;
use App\Models\UserModel;
use App\Models\JwtModel;

class Login extends Controller {

	protected $secret;
	protected $user_model;
	protected $jwt_model;

	function __construct() {
	    $this->secret = $_ENV['jwt.secret'];
		$this->user_model = new UserModel();
		$this->jwt_model  = new JwtModel();
	}

	public function index() {
		return json_encode(['index'=>'test']);
	}

	public function authenticate() {
		$input_data = $this->request->getJSON();

		// Find User
		$user = $this->user_model->where('email', $input_data->email)->first();

		// Check Empty
		if(empty($user)) {
			return json_encode(['status' => 0, 'message' => lang('cyno.user_notfound')]);
		}

		// Check User Activation
		if ((int)$user->is_activate === 0) {
			return json_encode(['status' => 0, 'message' => lang('cyno.profile_deactivated')]);
		}

		// $user_data = [
		// 	'id' => $user->id,
		// 	// 'email' => $user->email,
		// 	// 'is_admin' => $user->is_admin,
		// ];

		$encrypter = \Config\Services::encrypter();
		$decrypted_password = $encrypter->decrypt(base64_decode($user->password));
		if($decrypted_password == $input_data->password) {

			$jwt_id = $this->jwt_model->where('user_id', $user->id)->first();
			if(empty($jwt_id)) {
				$exp = date(strtotime('+1 year'));
				$payload = array(
					"iss" => base_url(),
					"exp" => $exp,
					"user_id" => $user->id
				);
				$jwt_token = JWT::encode($payload, $this->secret);
				$insert_id = $this->jwt_model->insert([
					'user_id' => $user->id,
					'token' 	=> $jwt_token,
					'expire' => $exp
				]);
				if($insert_id) {
					return json_encode(['status' => 1, 'jwt' => $jwt_token]);
				} else {
					die(json_encode(['status' => 0, 'message' => lang('cyno.operation_failed')]));
				}
			} else {
				return json_encode(['status' => 1, 'jwt' => $jwt_id->token]);
			}
			
		} else {
			return json_encode(['status' => 0, 'message' => lang('cyno.wrong_password')]);
		}


	}


}