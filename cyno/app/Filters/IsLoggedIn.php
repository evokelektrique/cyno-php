<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsLoggedIn implements FilterInterface {
	public function before(RequestInterface $request) {
		$session = session();
		$router = service('router');
		if($router->controllerName() === "\App\Controllers\Login" || $router->controllerName() === "\App\Controllers\Register") {
			if(!empty($session->user) && $session->user['is_activate'] && $session->user['is_logged_in']) {
				return redirect('dashboard');
			}
		}
	}

	//--------------------------------------------------------------------

	public function after(RequestInterface $request, ResponseInterface $response) {}
}