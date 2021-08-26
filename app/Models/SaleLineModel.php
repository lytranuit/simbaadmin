<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class SaleLineModel extends Model
{
    protected $table      = 'sale_order_line';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\SaleLine';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['order_id', 'product_id', 'quantity', 'unit_id', 'unit_price', 'subtotal', 'name', 'code', 'image_url', 'status', 'special_unit', 'volume_order', 'volume_order_en', 'volume_order_jp', 'volume'];



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
