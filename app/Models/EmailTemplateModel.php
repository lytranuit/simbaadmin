<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailTemplate extends Model
{
    protected $table      = 'email_template';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\EmailTemplate';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name', 'type', 'subject', 'content'];

    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
}
