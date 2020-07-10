<?php namespace App\Controllers;
// Core
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

// Models
use App\Models\WebsiteModel;
use App\Models\PasswordModel;

// Third-Party
use Hashids\Hashids;

class Websites extends BaseController {
	protected $model; // Website model
	protected $password_model; // Password model
	protected $hashids;

	public function __construct() {
		// Define models
		$this->model = new WebsiteModel();
		$this->password_model = new PasswordModel();
		$this->hashids = new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
	}

	public function index() {
		$websites = $this->model
			->where('user_id', $this->session->user['id'])
			->findAll();

		$data = [
			'session' => $this->session,
			'websites' => $websites,
			'password_model' => $this->password_model,
			'time' => new Time(),
		];
		// var_dump($websites);
		return view('dashboard/websites/index', $data);
	}

	public function passwords($hash_id) {
		$id = $this->hashids->decode($hash_id);
		$passwords = $this->password_model->where('user_id', $this->session->user['id'])
			->where('website_id', $id)
			->findAll();
		$data = [
			'session' => $this->session,
			'passwords' => $passwords,
			'time' => new Time(),
		];
		return view('dashboard/websites/passwords', $data);
	}


}