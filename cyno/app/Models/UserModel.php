<?php

namespace App\Models;
use CodeIgniter\Model;
use Hashids\Hashids;

class UserModel extends Model {

	protected $table 			= 'users';
	protected $primaryKey 		= 'id';

	protected $returnType 		= 'object';
	protected $useSoftDeletes 	= true;

	protected $allowedFields 	= ['email', 'password', 'hash_id', 'is_email_verified', 'key_id'];

	protected $useTimestamps 	= true;
    // protected $createdField  	= 'created_at';
    // protected $updatedField  	= 'updated_at';
	// protected $deletedField  	= 'deleted_at';
	protected $validationRules  = 'register';
	protected $skipValidation   = false;

	protected $afterInsert = ['hashids'];

	protected function hashids(array $data) {
		$hashids = new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
		$hash_id = $hashids->encode($data['id']);
		return $this->update($data['id'], ['hash_id' => $hash_id]);
	}

}