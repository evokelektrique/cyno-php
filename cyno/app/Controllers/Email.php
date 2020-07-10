<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\EmailTokenModel;



class Email extends BaseController {

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