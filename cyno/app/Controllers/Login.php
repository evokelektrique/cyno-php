<?php
namespace App\Controllers;

// Models
use App\Models\UserModel;
use App\Models\EmailTokenModel;

// Login Class
class Login extends BaseController {
	public function index() {
		$data = [
			'session' => session()
		];
		return view('landing/login', $data);
	}


	public function validation() {
		// Login inputs data
		$data = [
			'email'    => $this->request->getPost('user[email]'),
			'password' => $this->request->getPost('user[password]')
		];

		// Validate login inputs
		$validation = \Config\Services::validation();
		if(!$validation->run($data, 'login')) {
			return redirect()->back()->withInput()->with('validation', $validation);
		}

		// Validate password
		$user_model = new UserModel();
		
		// Find User
		$user       = $user_model->where('email', $data['email'])->first();

		// User Not Found
		if(empty($user)) {
			return redirect()->back()->withInput()->with('alert', ['status' => 0, 'message' => lang('cyno.user_notfound')]);
		}

		$user_data = [
			'id'          => $user->id,
			'email'       => $user->email,
			'is_admin'    => $user->is_admin,
			'is_activate' => (int)$user->is_activate,
		];

		// Decrypt Password
		$encrypter = \Config\Services::encrypter();
		$decrypted_password = $encrypter->decrypt(base64_decode($user->password));
		if($decrypted_password == $data['password']) {
			// Email Verified
			if($user->is_email_verified) {
				$user_data['is_logged_in'] = 1;
				$this->session->set(['user' => $user_data]);
				return redirect('dashboard')->with('alert', [
					'status' => 1, 
					'message' => lang('cyno.logged_in_message', [$this->session->user['email']])
				]);
			}
			
			// Email Not Verified
			$email_token_model = new EmailTokenModel();
			
			// Find Email
			$email             = $email_token_model->select('hash')->where('user_id', $user->id)->first();
			
			// Email Not Found
			if(empty($email)) {
				$email_data = [
					'user_id' => $user->id,
					'email'   => $user->email,
				];
				$email_event = \CodeIgniter\Events\Events::trigger('email_verification', $email_data);
				
				// Email Sent
				if($email_event) {
					return view('landing/email_sent', [
						'status'  => 1, // Success Code
						'session' => $this->session
					]);
				} 
				
				// Email Not Sent
				return view('landing/email_sent', [
					'status'  => 0, // Error Code
					'session' => $this->session
				]);
			}
			
			// Email Found But Not Verified
			return redirect('user_login')->with('email_not_verified', [
				'status'  => 1,
				'email'   => $data['email'],
				'message' => lang('cyno.email_not_verified'),
				'hash'    => $email->hash,
			]);
		} else {			
			// Wrong Password
			return redirect()->back()->withInput()->with('alert', ['status' => 0, 'message' => lang('cyno.wrong_password')]);
		}
	}
}