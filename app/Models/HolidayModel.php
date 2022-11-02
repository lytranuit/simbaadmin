<?php

namespace App\Models;

use CodeIgniter\Model;

class HolidayModel extends Model
{
    protected $table      = 'holiday';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Holiday';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['note', 'active', 'holiday'];


    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
}
