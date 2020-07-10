<?php namespace App\Models;

use CodeIgniter\Model;

class InputModel extends Model
{
    protected $table      = 'inputs';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['form_id', 'name', 'type', 'value', 'website_id', 'id_name', 'class_name', 'password_id'];

    protected $useTimestamps = true;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}