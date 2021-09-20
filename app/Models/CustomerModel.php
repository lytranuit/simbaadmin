<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customer';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['code', 'name', 'phone', 'email', 'tax_code', 'customer_type', 'region'];

    function create_object($data)
    {
        $db = $this->db;
        $array = $db->getFieldNames($this->table);
        $obj = array();
        foreach ($array as $key) {
            if (isset($data[$key])) {
                $obj[$key] = $data[$key];
            } else
                continue;
        }

        return $obj;
    }

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
            if (in_array("products", $relation)) {
                $customer_id = $row_a->id;
                $builder = $this->db->table('product_private')->join("product", "product_private.product_id = product.id");
                $row_a->products = $builder->where('customer_id', $customer_id)->where('product_private.deleted', 0)->select('product.*', false)->get()->getResult();
            }
        } else {
            if (in_array("products", $relation)) {
                $customer_id = $row_a['id'];
                $builder = $this->db->table('product_private')->join("product", "product_private.product_id = product.id");
                $row_a['products'] = $builder->where('customer_id', $customer_id)->where('product_private.deleted', 0)->select('product.*', false)->get()->getResult('array');
            }
        }
        return $row_a;
    }
    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    protected $skipValidation     = true;
}
