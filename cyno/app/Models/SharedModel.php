<?php namespace App\Models;

use CodeIgniter\Model;
use Hashids\Hashids;

class SharedModel extends Model
{
    protected $table      = 'shared';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'hash_id', 
        'user_id', 
        'receiver_id', 
        'cipher', 
        'nonce', 
        'website_id', 
        'title', 
        'hash', 
        'inputs_hash', 
        'inputs_preimage_hash',
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

	protected $afterInsert = ['hashids'];

	protected function hashids(array $data) {
		$hashids = new Hashids($_ENV["hashids.salt"], $_ENV["hashids.padding"]);
		$hash_id = $hashids->encode($data['id']);
		return $this->update($data['id'], ['hash_id' => $hash_id]);
	}
}