<?php

namespace App\Models;

use CodeIgniter\Model;

class UserapiModel extends Model
{
    protected $table      = 'user_api';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Userapi';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['api_key', 'api_token'];

    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
}
