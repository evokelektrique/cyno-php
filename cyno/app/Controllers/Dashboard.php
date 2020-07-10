<?php namespace App\Controllers;

use CodeIgniter\Controller;
use \App\Models\FolderModel;
use \App\Models\PasswordModel;
use Hashids\Hashids;

class Dashboard extends BaseController {

	protected $model;
	protected $hashids;
	protected $password_model;

	public function __construct() {
		$this->model = new FolderModel();
		$this->password_model = new PasswordModel();
		$this->hashids = new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
	}

	public function index() {
		$folders = $this->model
			->select('*')
			->where('parent_id', 0)
			->where('user_id', $this->session->user['id'])
			->findAll();

		$passwords = $this->password_model
			->select('*')
			->where('user_id', $this->session->user['id'])
			->where('folder_id', 0)
			->limit(3)
			->find();

		$multiselect_folders 		= array_column($folders, 'title', 'hash_id');
		$multiselect_folders[0] 	= 'root'; // Root folder
		$default_folder 		 	= 0;

		$difficulty_options = [
			'0' => 'interactive', 
			'1' => 'moderate', 
			'2' => 'sensitive' 
		];

		$data = [
			'session' => $this->session,
			'folders' => $folders,
			'multiselect_folders' => $multiselect_folders,
			'default_folder' => $default_folder,
			'passwords' => $passwords,
			'difficulty_options' => $difficulty_options,
		];
		return view('dashboard/index', $data);
	}

}