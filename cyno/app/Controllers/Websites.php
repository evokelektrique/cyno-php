<?php namespace App\Controllers;
// Core
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
		// Find Website
		$websites = $this->model
			->where('user_id', $this->session->user['id'])
			->findAll();

		$data = [
			'session' => $this->session,
			'websites' => $websites,
			'password_model' => $this->password_model,
			'time' => new Time(),
		];
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


	// Edit Website
	public function edit($hash_id) {
		// Decode ID
		$id = $this->hashids->decode($hash_id);
		
		// Find Website
		$website = $this->model
			->where('id', $id)
			->where('user_id', $this->session->user['id'])
			->first();
		
		// Password Not Found
		if(empty($website)) {
			return $this->response->setStatusCode(404, "Password Not Found");
		}

		$data = [
			'session' => $this->session,
			'website' => $website,
		];
		return view('dashboard/websites/edit', $data);
	}

	// Delete Website
	public function delete($hash_id)
	{
		// Decode ID
		$id = $this->hashids->decode($hash_id);

		// Find Website
		$website = $this->model
			->where('id', $id)
			->where('user_id', $this->session->user['id'])
			->first();

		// Password Not Found
		if(empty($website)) {
			return $this->response->setStatusCode(404, "Password Not Found");
		}

		// Delete Website
		$deleted_website = $this->model
			->where('id', $id)
			->delete();

		// Website Deleted Successfully
		if($deleted_website) {
			return redirect('dashboard_websites')->with('alert', [
				'status' => 1, 
				'message' => lang('cyno.website_deleted')
			]);
		}
		
		// Delete Operation Failed
		return redirect()->back()->with('alert', [
			'status' => 0, 
			'message' => lang('cyno.website_not_deleted')
		]);
	}

	// Update Website
	public function update($hash_id)
	{
		// Decode ID
		$id = $this->hashids->decode($hash_id);

		// Incomming PUT data
		$input_data = [
			'title' => $this->request->getPost('title'),
		];

		// Find Website
		$website = $this->model
			->where('id', $id)
			->where('user_id', $this->session->user['id'])
			->first();

		// Password Not Found
		if (empty($website)) {
			return $this->response->setStatusCode(404, "Password Not Found");
		}

		// Update Website
		$updated_website = $this->model
			->where('id', $id)
			->set($input_data)
			->update();

		// Website Updated Successfully
		if ($updated_website) {
			return redirect('dashboard_websites')->with('alert', [
				'status' => 1,
				'message' => lang('cyno.website_updated')
			]);
		}

		// update Operation Failed
		return redirect()->back()->with('alert', [
			'status' => 0,
			'message' => lang('cyno.website_not_updated')
		]);
	}
}