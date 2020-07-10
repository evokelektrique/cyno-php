<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Profile extends BaseController {

	public function index() {
			
	}

	public function settings() {
		$user_model = new UserModel();
		$user = $user_model->find($this->session->user['id']);
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

		if(!$validation->run($settings_data, 'settings')) {
			$this->session->setFlashdata('errors', $validation->getErrors());
			return redirect()->back()->withInput()->with('alert', ['status' => 'FAIL', 'message' => 'failed']);
		}

		// Encrypt new password
		$encrypter = \Config\Services::encrypter();
		$user_data = [
			'password' => base64_encode($encrypter->encrypt($settings_data['password']))
		];
		$user_model = new UserModel();
		$user_id = $user_model->update($this->session->user['id'], $user_data);
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


	public function logout() {
		$this->session->remove('user');
		return redirect('root')->with('alert', ['status'=>'SUCCESS', 'message'=> 'Logged out']);
	}

}


