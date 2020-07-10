<?php namespace App\Controllers\Api\v1;

use CodeIgniter\Controller;
use \Firebase\JWT\JWT;

class ApiController extends Controller {

	protected $helpers = [];
	protected $secret;
	protected $user;
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
	    parent::initController($request, $response, $logger);
	    $this->secret = $_ENV['jwt.secret'];
		try {
			$token 			= explode(' ', $request->getHeaderLine('Authorization'))[1]; // JWT TOKEN
			$this->user 	= JWT::decode($token, $this->secret, array('HS256'));
		} catch (\Exception $e) {
			die(json_encode(['status' => 'failed', 'message' => 'not valid']));
		}
	}
}