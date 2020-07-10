<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Authentication implements FilterInterface {
	public function before(RequestInterface $request) {
		$session = session();
		if (!$session->has('user')) {
			if (!$session->user['is_logged_in']) {
				return redirect('root')->with('alert', [
					'status' => 'FAIL',
					'message' => 'not authorized'
				]);
			}
		}
	}

	//--------------------------------------------------------------------

	public function after(RequestInterface $request, ResponseInterface $response) {

	}
}