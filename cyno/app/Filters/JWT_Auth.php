<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use \App\Models\JwtModel;

class JWT_Auth implements FilterInterface {
	public function before(RequestInterface $request) {
		if($request->hasHeader('Authorization')) {
			try {
				$token = explode(' ', $request->getHeaderLine('Authorization'))[1];
				// $jwt_model = new JwtModel();
				// $jwt = $jwt_model->where('token', $token)->first();
			} catch (\Exception $e) {
				die(json_encode(['message' => 'No jwt-token included']));
			}
		} else {
			die(json_encode(['message' => 'No Authorization included']));
		}
	}

	//--------------------------------------------------------------------

	public function after(RequestInterface $request, ResponseInterface $response) {

	}
}