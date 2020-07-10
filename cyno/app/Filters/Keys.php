<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use \App\Models\KeysModel;

class Keys implements FilterInterface
{
    public function before(RequestInterface $request)
    {
    	$keys_model 		= new KeysModel();
    	$session 	= session();
    	$keys = $keys_model
    		->select('*')
    		->where('user_id', $session->user['id'])
    		->findAll();
    	if(empty($keys)) {
    		return redirect('dashboard_setup');
    	}
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
    }
}			