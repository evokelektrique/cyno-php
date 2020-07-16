<?php namespace App\Controllers;

use \App\Models\FolderModel;
use \App\Models\PasswordModel;
use Hashids\Hashids;
use CodeIgniter\I18n\Time;

class Dashboard extends BaseController {

	protected $model;
	protected $hashids;
	protected $password_model;

	public function __construct() {
		$this->model          = new FolderModel();
		$this->password_model = new PasswordModel();
		$this->hashids        = new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
	}

	public function index() {
		// Find Folders
		$folders = $this->model
			->select('*')
			->where('parent_id', 0)
			->where('user_id', $this->session->user['id'])
			->findAll();

		// Find Passwords
		$passwords = $this->password_model
			->select('*')
			->where('user_id', $this->session->user['id'])
			// ->where('folder_id', 0) // ! Only shows the root passwords
			->limit(3)
			->orderBy('updated_at', 'DESC')
			->orderBy('id', 'DESC')
			->find();

		// Folders for 'select' element
		$multiselect_folders 		= array_column($folders, 'title', 'hash_id');
		$multiselect_folders[0] 	= 'root'; // Root folder
		$default_folder 		 	= 0;

		// Difficulties for 'select' element
		$difficulty_options = [
			'0' => lang('cyno.difficulty_interactive'),
			'1' => lang('cyno.difficulty_moderate'),
			'2' => lang('cyno.difficulty_sensitive'),
		];

		$data = [
			'session'             => $this->session,
			'folders'             => $folders,
			'multiselect_folders' => $multiselect_folders,
			'default_folder'      => $default_folder,
			'passwords'           => $passwords,
			'difficulty_options'  => $difficulty_options,
			'time' => new Time(),
		];
		return view('dashboard/index', $data);
	}

}