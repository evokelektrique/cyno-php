<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Landing extends BaseController {
	public function index() {
		$data = [
			'session' => session()
		];
		return view('landing/index', $data);
	}
}