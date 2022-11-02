<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;
use phpDocumentor\Reflection\Types\Null_;

class ProductModel extends Model
{
    protected $table      = 'product';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Product';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['is_b2b', 'is_b2c', 'is_fresh', 'is_alcohol', 'region', 'image_url', 'name_vi', 'name_en', 'name_jp', 'description_vi', 'description_en', 'description_jp', 'volume_vi', 'volume_en', 'volume_jp', 'guide_vi', 'guide_en', 'guide_jp', 'detail_vi', 'detail_en', 'detail_jp', 'element_vi', 'element_en', 'element_jp', 'origin_country_id', 'preservation_id', 'sort'];


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
            if (in_array("image_other", $relation)) {
                $product_id = $row_a->id;
                $builder = $this->db->table('new_product_image');
                $row_a->image_other = $builder->where('product_id', $product_id)->get()->getResult();
            }
            if (in_array("category", $relation)) {
                $product_id = $row_a->id;
                $builder = $this->db->table('new_product_category')->join("new_category", "new_product_category.cateogry_id = new_category.id");
                $row_a->tags = $builder->where('product_id', $product_id)->orderBy("order", "ASC")->get()->getResult();
            }

            if (in_array("product_replace", $relation)) {
                $product_id = $row_a->id;
                $builder = $this->db->table('new_product_replace')->join("product", "new_product_replace.replace_id = product.id");
                $row_a->product_replace = $builder->where('product_id', $product_id)->get()->getResult();
            }
            if (in_array("units", $relation)) {
                $product_id = $row_a->id;
                $builder = $this->db->table('tbl_unit');
                $row_a->units = $builder->where('product_id', $product_id)->get()->getResult();
            }
            if (in_array("new", $relation)) {
                $product_code = $row_a->code;
                $builder = $this->db->table('new_product');
                $row_a->new = $builder->where('code', $product_code)->get()->getFirstRow();
            }
            if (in_array("ProductExt", $relation)) {
                $product_id = $row_a->id;
                $builder = $this->db->table('new_product_ext');
                $row_a->ProductExt = $builder->where('product_id', $product_id)->get()->getFirstRow();
            }
            if (in_array("forCustomers", $relation)) {
                $product_id = $row_a->id;
                $builder = $this->db->table('product_private')->join("customer", "product_private.customer_id = customer.id");
                $row_a->forCustomers = $builder->where('product_id', $product_id)->where('product_private.deleted', 0)->select('customer.*', false)->get()->getResult();
            }
        } else {
            if (in_array("image_other", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('new_product_image');
                $row_a['image_other'] = $builder->where('product_id', $product_id)->get()->getResult("array");
            }
            if (in_array("category", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('new_product_category')->join("new_category", "new_product_category.cateogry_id = new_category.id");
                $row_a['tags'] = $builder->where('product_id', $product_id)->orderBy("order", "ASC")->get()->getResult("array");
            }

            if (in_array("product_replace", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('new_product_replace')->join("product", "new_product_replace.replace_id = product.id");
                $row_a['product_replace'] = $builder->where('product_id', $product_id)->get()->getResult("array");
            }
            if (in_array("units", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('tbl_unit');
                $row_a['units'] = $builder->where('product_id', $product_id)->get()->getResult("array");
            }
            if (in_array("new", $relation)) {
                $product_code = $row_a['code'];
                $builder = $this->db->table('new_product');
                $row_a['new'] = $builder->where('code', $product_code)->get()->getFirstRow("array");
            }
            if (in_array("ProductExt", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('new_product_ext');
                $row_a['ProductExt'] = $builder->where('product_id', $product_id)->get()->getFirstRow("array");
            }
            if (in_array("forCustomers", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('product_private')->join("customer", "product_private.customer_id = customer.id");
                $row_a['forCustomers'] = $builder->where('product_id', $product_id)->where('product_private.deleted', 0)->select('customer.*', false)->get()->getResult('array');
            }
        }
        return $row_a;
    }
    function get_max_order()
    {
        $result = $this->db->table('product')->select('MAX(sort) as max', false)->get()->getFirstRow();
        // print_r($result);
        // die();
        if (empty($result)) {
            $data = 1;
        } else {
            $data = (int) $result->max + 1;
        }
        // print_r($data);
        // die();
        return $data;
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
    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    protected $skipValidation     = true;
}
