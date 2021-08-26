<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table      = 'new_slider';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Slider';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['order', 'text', 'url', 'image_url', 'active'];


    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    protected $skipValidation     = true;
}
