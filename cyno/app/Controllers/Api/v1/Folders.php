<?php namespace App\Controllers\Api\v1;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\FolderModel;
use Hashids\Hashids;

class Folders extends ApiController {

	protected $folder_model;
	protected $user_model;
	protected $hashids;

	public function __construct() {
		$this->folder_model = new FolderModel();
		$this->user_model 	= new UserModel();
		$this->hashids 		= new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
	}

	public function index() {
		$input_data = $this->request->getJSON();
		$folders = $this->folder_model
			->where('user_id', $this->user->user_id)
			->orderBy('updated_at', 'DESC')
			->orderBy('id', 'DESC')
			->findAll();
		if(empty($folders)) {
			return json_encode([]);
		}
		return json_encode($folders);
	}






} 