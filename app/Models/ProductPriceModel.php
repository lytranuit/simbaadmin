<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPriceModel extends Model
{
    protected $table      = 'pet_product_price';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\ProductPrice';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['product_id', 'price', 'date_from', 'date_to', 'unit_id'];


    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
    public function relation(&$data, $relation = array())
    {
        $type = gettype($data);
        if ($type == "array" && !isset($data['id'])) {
            foreach ($data as &$row) {
                $row = $this->format_row($row, $relation);
            }
        } else {
            $data = $this->format_row($data, $relation);
        }

        return $data;
    }
    function format_row($row_a, $relation)
    {
        if (gettype($row_a) == "object") {

            if (in_array("product", $relation)) {
                $product_id = $row_a->product_id;
                $builder = $this->db->table('product');
                $row_a->product = $builder->where('id', $product_id)->get()->getFirstRow();
            }

            if (in_array("unit", $relation)) {
                $unit_id = $row_a->unit_id;
                $builder = $this->db->table('tbl_unit');
                $row_a->unit = $builder->where('id', $unit_id)->get()->getFirstRow();
            }
        } else {
            if (in_array("product", $relation)) {
                $product_id = $row_a['product_id'];
                $builder = $this->db->table('product');
                $row_a['product'] = $builder->where('id', $product_id)->get()->getFirstRow("array");
            }
            if (in_array("unit", $relation)) {
                $unit_id = $row_a['unit_id'];
                $builder = $this->db->table('tbl_unit');
                $row_a['unit'] = $builder->where('id', $unit_id)->get()->getFirstRow("array");
            }
        }
        return $row_a;
    }
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
