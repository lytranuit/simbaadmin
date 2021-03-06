<?php

namespace App\Models;

use CodeIgniter\Model;

class OriginModel extends Model
{
    protected $table      = 'origin_country';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Origin';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name_vi', 'name_en', 'name_jp', 'description_vi', 'description_en', 'description_jp'];

    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
}
