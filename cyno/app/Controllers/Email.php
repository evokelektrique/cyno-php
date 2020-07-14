<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\EmailTokenModel;



class Email extends BaseController {

	public function resend_email() {
		helper('text');
		$hash              = $this->request->getPost('hash');
		$email_token_model = new EmailTokenModel();
		$user_model        = new UserModel();
		$email             = $email_token_model->where('hash', $hash)->first();
		if(empty($email)) {
			return $this->response->setStatusCode(404, 'Email not found');
		}
		$new_hash          = random_string('crypto', getenv('email.bytes_length'));
		$updated_email     = $email_token_model->update($email->id, ['hash' => $new_hash]);
		$data              = [
			'user_id' => $email->user_id,
			'email'   => $user_model->select('email')->where('id', $email->user_id)->first()->email,
			'hash'    => $new_hash,
		];
		$email_event = \CodeIgniter\Events\Events::trigger('email_verification', $data);
		$view_data = [
			'session' => $this->session,
			'email'   => $data['email'],
			'status'  => 0,
		];
		// Email sent
		if($email_event) {
			$view_data['status'] = 1;			
		}
		return view('landing/email_sent', $view_data);
	}

	public function validate_email($hash) {
		// Loading models
		$user_model = new UserModel();
		$email_token_model = new EmailTokenModel();
		
		// Find email
		$email = $email_token_model
			->where('hash', $hash)
			->where('status', 0)
			->first();

		if($email) {
			// Update Data
			$user_data = ['is_email_verified' => 1 ];
			$email_data = ['status' => 1 ];
			$updated_email = $email_token_model->update($email->id, $email_data);
			$updated_user  = $user_model->update($email->user_id, $user_data);
			if($updated_user && $updated_email) {
				return redirect('user_login')->with('alert', [
					'status' => 1,
					'message' => 'Email verified'
				]);
			}
		} else {
			// Fail
			return redirect('user_login')->with('alert', [
				'status' => 0,
				'message' => 'Email not verified'
			]);
		}
	}

}