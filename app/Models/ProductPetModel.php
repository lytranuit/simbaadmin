<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPetModel extends Model
{
    protected $table      = 'pet_product';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['code', 'price', 'name_vi', 'name_en', 'name_jp', 'description_vi', 'description_en', 'description_jp', 'volume_vi', 'volume_en', 'volume_jp', 'guide_vi', 'guide_en', 'guide_jp', 'detail_vi', 'detail_en', 'detail_jp', 'element_vi', 'element_en', 'element_jp','search_vi', 'search_en', 'search_jp', 'special_unit'];


    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;


    function create_object($data)
    {
        $db = $this->db;
        $array = $db->getFieldNames($this->table);
        $obj = array();
        foreach ($array as $key) {
            if (isset($data[$key])) {
                if ($key == "price" || $key == "quantity" || $key == "retail_price" || $key == "min" || $key == "max" || $key == "fee") {
                    $obj[$key] = str_replace(",", "", $data[$key]);
                    $obj[$key] = (float) str_replace(" VND", "", $obj[$key]);
                } else
                    $obj[$key] = $data[$key];
            } else
                continue;
        }

        return $obj;
    }
}
