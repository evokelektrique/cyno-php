<?php namespace App\Models;

use CodeIgniter\Model;

class KeysModel extends Model
{
    protected $table      = 'user_keys';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'public_key', 'secret_key', 'salt', 'nonce', 'difficulty'];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}