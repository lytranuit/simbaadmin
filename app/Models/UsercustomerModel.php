<?php

namespace App\Models;

use CodeIgniter\Model;

class UsercustomerModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Usercustomer';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['username', 'password', 'role', 'fullname', 'created_date', 'active', 'customer_id', 'token_login'];

    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
}
