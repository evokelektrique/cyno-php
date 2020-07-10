<?php namespace App\Models;

use CodeIgniter\Model;

class JwtModel extends Model {
    protected $table                = 'jwt_tokens';
    protected $primaryKey           = 'id';
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;
    protected $allowedFields        = ['hash_id', 'user_id', 'token', 'expire', 'last_login'];
    protected $useTimestamps        = true;
    protected $skipValidation       = true;
}