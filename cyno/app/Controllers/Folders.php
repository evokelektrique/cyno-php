<?php namespace App\Controllers;

use \App\Models\FolderModel;
use \App\Models\PasswordModel;
use Hashids\Hashids;
use CodeIgniter\I18n\Time;

class Folders extends BaseController {

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
			->findAll();

		$multiselect_folders 		= array_column($folders, 'title', 'hash_id');
		$multiselect_folders[0] 	= 'root'; // Root folder
		$default_folder 		 	= 0;

		$difficulty_options = [
			'0' => lang('cyno.difficulty_interactive'), 
			'1' => lang('cyno.difficulty_moderate'), 
			'2' => lang('cyno.difficulty_sensitive'), 
		];

		$data = [
			'session' => $this->session,
			'folders' => $folders,
			'multiselect_folders' => $multiselect_folders,
			'default_folder' => $default_folder,
			'passwords' => $passwords,
			'difficulty_options' => $difficulty_options,
			'password_model' => $this->password_model,
			'time' => new Time()
		];

		// var_dump($default_folder, $multiselect_folders);
		return view('dashboard/folders/index', $data);
	}


	public function new() {

		$data = [
			'session' => $this->session
		];

		return view('dashboard/folders/new', $data);

	}



	public function create() {

		if($this->request->isAjax()) {
			$input_data = $this->request->getJSON();
			$model_data = [
				'title' 	=> $input_data->title,
				'folder' 	=> $input_data->folder,
				'user_id'  	=> $this->session->user['id'],
			];
			if(strlen($model_data['folder']) == 1) {
				if($model_data['folder'] == 0) {
					$model_data['parent_id'] = 0;
				} else {
					return json_encode(['status' => 'Fail', 'message' => 'Something went wrong']);
				}
			} else {
				$model_data['parent_id'] = $this->hashids->decode($model_data['folder']);
			}

			$insert_id = $this->model->insert($model_data);
			$response = [];
			if($insert_id) {
				$response['message'] = 'Folder successfully created';
				$response['request'] = json_encode($input_data);
			} else {
				$response['message'] = 'failed';
			}
			$response['csrf'] = csrf_hash();


			return json_encode($response);



		} else {
			return json_encode(['status' => 'fail', 'message' => 'not ajax']);
		}



		// // Input data
		// $data = [
		// 	'title' => $this->request->getPost('title'),
		// 	'folder' => $this->request->getPost('folder')
		// ];
		// // Validation
		// $validation = \Config\Services::validation();
		// if(!$validation->run($data, 'folder_create')) {
		// 	$this->session->setFlashdata('errors', $validation->getErrors());
		// 	return redirect()->back()->with('alert', [
		// 		'status' => 'FAIL',
		// 		'message' => 'validation_failed'
		// 	]);
		// }
		// $data['user_id'] = (int)$this->session->user['id'];
		// 	if(strlen($data['folder']) == 1) {
		// 		if($data['folder'] == 0) {
		// 			$data['parent_id'] = 0;
		// 		} else {
		// 			return redirect()->back()->with('alert', [
		// 				'status' => 'Fail',
		// 				'message' => 'Something went wrong'
		// 			]);
		// 		}
		// 	} else {
		// 		$data['parent_id'] = $this->hashids->decode($data['folder']);
		// 	}
		// // Insert data
		// $insert_id = $this->model->insert($data);
		// if($insert_id) {
		// 	return redirect()->route('dashboard_folders')->with('alert', [
		// 		'status' => 'SUCCESS',
		// 		'message' => 'Folder created successfully.'
		// 	]);
		// } else {
		// 	// In case if somethings went wrong
		// 	return redirect()->back()->withInput()->with('alert', [
		// 		'status' => 'FAIL',
		// 		'message' => 'Operation failed'
		// 	]);
		// }


	}

	public function show($hash_id) {
		$id = $this->hashids->decode($hash_id);
		$folder = $this->model
			->select('*')
			->where('user_id', $this->session->user['id'])
			->where('id', $id)
			->first();

		$folders = (array)$this->model
			->select('*')
			->where('parent_id', $id)
			->where('user_id', $this->session->user['id'])
			->findAll();

		$multiselect_folders 	= array_column($folders, 'title', 'hash_id');
		$multiselect_folders[0] = 'Root'; // Root folder
		$multiselect_folders["$hash_id"] = $folder->title; // Root folder
		$default_folder 		= $hash_id;
		$passwords = $this->password_model
			->select('*')
			->where('folder_id', $folder->id)
			->where('user_id', $this->session->user['id'])
			->findAll();

		$breadcrumb = [];
		$temp_folder_id = $folder->parent_id;
		$i = 0;
		while(true) { 
			if($temp_folder_id == 0) {
				$breadcrumb[] = $folder;
				break;
			} else {
				$temp_folder 	= $this->model->where('id', (int)$temp_folder_id)->first();
				$temp_folder_id = $temp_folder->parent_id;
				$breadcrumb[] = $temp_folder;
				$i++;
			}
		}


		$ids = array_column((array)$breadcrumb, 'id');
		array_multisort($ids, SORT_ASC, $breadcrumb);


		$difficulty_options = [
			'0' => lang('cyno.difficulty_interactive'), 
			'1' => lang('cyno.difficulty_moderate'), 
			'2' => lang('cyno.difficulty_sensitive'), 
		];

		$data = [
			'session' => $this->session,
			'folder' => $folder,
			'folders' => (object)$folders,
			'passwords' => $passwords,
			'multiselect_folders' => $multiselect_folders,
			'default_folder' => $default_folder,
			'breadcrumb' => $breadcrumb,
			'difficulty_options' => $difficulty_options,
			'password_model' => $this->password_model,
			'time' => new Time(),
		];
		return view('dashboard/folders/show', $data);

	}


	public function edit($hash_id) {
		$id = $this->hashids->decode($hash_id);
		$folder = $this->model
			->select('*')
			->where('user_id', $this->session->user['id'])
			->where('id', $id)
			->first();

		$data = [
			'session' => $this->session,
			'folder' => $folder,
		];
		return view('dashboard/folders/edit', $data);

	}

	public function update($hash_id) {
		$id = $this->hashids->decode($hash_id);
		$folder = $this->model
			->select('*')
			->where('user_id', $this->session->user['id'])
			->where('id', $id)
			->first();

		// Input data
		$data = [
			'title' => $this->request->getPost('title')
		];
		// Validation
		$validation = \Config\Services::validation();
		if(!$validation->run($data, 'folder_create')) {
			$this->session->setFlashdata('errors', $validation->getErrors());
			return redirect()->back()->with('alert', [
				'status' => 'FAIL',
				'message' => 'validation_failed'
			]);
		}
		// $data['user_id'] = $this->session->user['id'];
		// $data['is_default'] = 0;
		// $data['parent_id'] = 0;
		// Insert data
		$insert_id = $this->model->update($folder->id, $data);
		if($insert_id) {
			return redirect()->route('dashboard_folders')->with('alert', [
				'status' => 1,
				'message' => 'Folder created successfully.'
			]);
		} else {
			// In case if somethings went wrong
			return redirect()->back()->withInput()->with('alert', [
				'status' => 0,
				'message' => 'Operation failed'
			]);
		}

	}

	public function delete($hash_id) {
		$id = $this->hashids->decode($hash_id);

		// Delete all folder passwords
		foreach($this->password_model->where('folder_id', $id)->findAll() as &$password) {
			$this->password_model->delete($password->id);
		}

		// Delete Folder
		$deleted_folder = $this->model->delete($id);

		if($deleted_folder) {
			return redirect()->route('dashboard_folders')->with('alert', [
					'status' => 1,
					'message' => 'Folder deleted successfully.'
			]);
		} else {
			return redirect()->route('dashboard_folders')->with('alert', [
					'status' => 0,
					'message' => 'Delete operation failed'
			]);
		}
	}


}