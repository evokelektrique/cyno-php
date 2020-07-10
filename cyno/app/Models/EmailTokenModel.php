<?php namespace App\Models;

use CodeIgniter\Model;

class EmailTokenModel extends Model
{
    protected $table      = 'emails_token';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['hash', 'user_id', 'status'];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    protected $skipValidation     = true;
}