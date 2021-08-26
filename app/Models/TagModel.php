<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends Model
{
    protected $table      = 'pet_tag';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Tag';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name_vi', 'name_en', 'name_jp', 'description_vi', 'description_en', 'description_jp', 'date', 'user_id', 'image_url'];



    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
}
