<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use \App\Models\PasswordModel;
use \App\Models\WebsiteModel;
use Hashids\Hashids;

class Search extends BaseController {

	protected $password_model;
	protected $website_model;

	public function __construct() {
		$this->password_model = new PasswordModel();
		$this->website_model = new WebsiteModel();
	}

	public function index() {
		$search_type  = $this->request->getVar('type');
		$search_query = $this->request->getVar('q');

		// Query through types
		// returns $result
		switch ($search_type) {
			// Password mode
			case 'password':
				$passwords = $this->password_model
					->where('user_id', $this->session->user['id'])
					->like('title', $search_query)
					->findAll();
				$data = [
					'session' => $this->session,
					'passwords' => $passwords,
					'password_model' => $this->password_model,
					'time' => new Time(),
					'type' => $search_type,
					'query' => $search_query,
				];
				return view('dashboard/search/passwords', $data);
				break;			

			// Website mode
			case 'website':
				$websites = $this->website_model
					->where('user_id', $this->session->user['id'])
					->like('url', $search_query)
					->findAll();
				$data = [
					'session' => $this->session,
					'websites' => $websites,
					'password_model' => $this->password_model,
					'time' => new Time(),
					'type' => $search_type,
					'query' => $search_query,
				];
				return view('dashboard/search/websites', $data);
				break;

			default:
				$results = NULL;
				break;
		}

	}

}