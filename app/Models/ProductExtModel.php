<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;
use phpDocumentor\Reflection\Types\Null_;

class ProductExtModel extends Model
{
    protected $table      = 'new_product_ext';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['product_id', 'alcohol_content', 'rice_polishing_ratio', 'smv', 'acidity', 'amino_acid_level', 'tastes', 'best_matching_food', 'enjoy_guide', 'category_vi', 'category_en', 'name_jp', 'ingredients_vi', 'ingredients_en', 'ingredients_jp', 'region_vi', 'region_en', 'region_jp', 'brewery_vi', 'brewery_en', 'brewery_jp', 'profile_vi', 'profile_en', 'profile_jp', 'tasting_note_vi', 'tasting_note_en', 'tasting_note_jp', 'food_pairings_vi', 'food_pairings_en', 'food_pairings_jp', 'created_at'];


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
    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    protected $skipValidation     = true;
}
