<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table      = 'pet_banner';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Banner';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['order', 'text', 'url', 'image_url'];


    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
}
