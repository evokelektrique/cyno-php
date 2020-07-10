<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends BaseController {
	public function index() {
		$data = [
			'session' => session()
		];
		return view('landing/login', $data);
	}


	public function validation() {
		$session = session();

		// Login inputs data
		$data = [
			'email' => $this->request->getPost('user[email]'),
			'password' => $this->request->getPost('user[password]')
		];

		// Validate login inputs
		$validation = \Config\Services::validation();
		if(!$validation->run($data, 'login')) {
			return redirect()->back()->withInput()->with('validation', $validation);
		}

		// Validate password
		$user_model = new UserModel();
		$user = $user_model->where('email', $data['email'])->first();
		if(empty($user)) {
			return redirect()->back()->withInput()->with('alert', ['status' => 0, 'message' => lang('cyno.user_notfound')]);
		}
		$user_data = [
			'id' => $user->id,
			'email' => $user->email,
			'is_admin' => $user->is_admin,
		];

		$encrypter = \Config\Services::encrypter();
		$decrypted_password = $encrypter->decrypt(base64_decode($user->password));
		if($decrypted_password == $data['password']) {
			$user_data['is_logged_in'] = 1;
			$this->session->set(['user' => $user_data]);
			return redirect('dashboard')->with('alert', [
				'status' => 1, 
				'message' => lang('cyno.logged_in_message', [$this->session->user['email']])
			]);
		} else {
			return redirect()->back()->withInput()->with('alert', ['status' => 0, 'message' => lang('cyno.wrong_password')]);
		}


	}
}

