<?php namespace App\Models;

use CodeIgniter\Model;
use Hashids\Hashids;

class PasswordModel extends Model {
	
	protected $table      = 'passwords';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['hash_id', 'nonce', 'salt', 'user_id', 'cipher', 'folder_id', 'website_id', 'hash' , 'inputs_hash', 'inputs_preimage_hash', 'difficulty'];

	protected $useTimestamps = true;
	// protected $createdField  = 'created_at';
	// protected $updatedField  = 'updated_at';
	// protected $deletedField  = 'deleted_at';
	// protected $validationRules    = 'password_create';
	protected $skipValidation     = true;

	protected $afterInsert = ['hashids'];

	protected function hashids(array $data) {
		$hashids = new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
		$hash_id = $hashids->encode($data['id']);
		return $this->update($data['id'], ['hash_id' => $hash_id]);
	}

}