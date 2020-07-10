<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\KeysModel;

class Register extends BaseController {


	protected $model;
	protected $keys_model;

	public function __construct() {
		$this->model = new UserModel();
		$this->keys_model = new KeysModel();
	}

	public function index() {
		$data = [
			'session' => session()
		];
		return view('landing/register', $data);
	}

	public function create() {
		// Loading services
		$validation = service('validation');
		$encrypter 	= service('encrypter');

		// Incomming data
		$request_data = [
			'email' 	=> $this->request->getVar('user[email]'),
			'password' 	=> $this->request->getVar('user[password]'),
		];
		$data = [
			'email' 	=> $request_data['email'],
			'password' 	=> base64_encode($encrypter->encrypt($request_data['password']))
		];
		// Validate data
		if(!$validation->run($request_data, 'register')) {
			return redirect()->back()->withInput()->with('validation', $validation);
		}
		$save = $this->model->insert($data);
		if($save > 0) {
			// Send email
			$data['user_id'] = $save;

			// Events
			$email = \CodeIgniter\Events\Events::trigger('user_registration', $data);

			// Validate email
			if($email) {
				return redirect('user_login')->with('alert', [
					'status' => 1,
					'message' => 'email sent, yay. (Check your email or span folder)'
				]);
			} else {
				return redirect()->back()->with('alert', [
					'status' => 0,
					'message' => 'cannot send email'
				]);
			}
		} else {
			return redirect()->back()->withInput();
		}
	
	}
	
}