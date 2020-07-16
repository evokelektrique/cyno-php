<?php namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController {

	protected $model;
	
	public function __construct() {
		$this->model = new UserModel();	
	}
	

	public function index() { /* ... */ }

	public function settings() {
		$user = $this->model->find($this->session->user['id']);
		$data = [
			'session' => $this->session,
			'user' => $user
		];
		return view('dashboard/profile/settings', $data);
	}
	
	
	
	public function validate_settings() {
		$validation = \Config\Services::validation();

		// Inputs data
		$settings_data = [
			'password' => $this->request->getPost('user[password]'),
			'password_confirm' => $this->request->getPost('user[password_confirm]'),
		];

		// Validate input data
		if(!$validation->run($settings_data, 'settings')) {
			$this->session->setFlashdata('errors', $validation->getErrors());
			return redirect()->back()->withInput()->with('alert', ['status' => 0, 'message' => lang('cyno.empty_fields_error')]);
		}

		// Encrypt new password
		$encrypter = \Config\Services::encrypter();
		$user_data = [
			'password' => base64_encode($encrypter->encrypt($settings_data['password']))
		];
		// $user_model = new UserModel();
		$user_id = $this->model->update($this->session->user['id'], $user_data);
		if($user_id > 0) {
			return redirect()->back()->with('alert', [
				'status' => 'success',
				'message' => 'Profile settings has changed.'
			]);
		} else {
			return redirect()->back()->with('alert', [
				'status' => 'FAIL',
				'message' => 'Something went wrong.'
			]);
		}
	}

	public function deactive() {
		$user = $this->model->find($this->session->user['id']);
		$data = [
			'session' => $this->session,
			'user' => $user
		];
		return view('dashboard/profile/deactive', $data);
	}
	
	public function validate_deactive() {
		// Find User
		$user = $this->model
			->find($this->session->user['id']);

		// User Not Found
		if(empty($user)) {
			return redirect('root');
		}
		
		// Deactive User
		$deactivated_user = $this->model
			->set(['is_activate' => FALSE])
			->where('id', $user->id)
			->update();
			
		if($deactivated_user) {
			return redirect('user_login');
		}
		return redirect('dashboard');
	}



	public function logout() {
		$this->session->remove('user');
		return redirect('root')->with('alert', ['status'=>'SUCCESS', 'message'=> 'Logged out']);
	}

}


