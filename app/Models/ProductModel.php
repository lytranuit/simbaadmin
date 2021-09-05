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

    protected $allowedFields = ['is_fresh', 'is_alcohol', 'region', 'image_url', 'name_vi', 'name_en', 'name_jp', 'description_vi', 'description_en', 'description_jp', 'volume_vi', 'volume_en', 'volume_jp', 'guide_vi', 'guide_en', 'guide_jp', 'detail_vi', 'detail_en', 'detail_jp', 'element_vi', 'element_en', 'element_jp', 'origin_country_id', 'preservation_id', 'sort'];


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
                $builder = $this->db->table('new_product_category')->join("pet_category", "new_product_category.cateogry_id = pet_category.id");
                $row_a->tags = $builder->where('product_id', $product_id)->orderBy("order", "ASC")->get()->getResult();
            }
            if (in_array("units", $relation)) {
                $product_id = $row_a->id;
                $builder = $this->db->table('tbl_unit');
                $row_a->units = $builder->where('product_id', $product_id)->get()->getResult();
            }
            if (in_array("pet", $relation)) {
                $product_code = $row_a->code;
                $builder = $this->db->table('new_product');
                $row_a->pet = $builder->where('code', $product_code)->get()->getFirstRow();
            }
            if (in_array("ProductExt", $relation)) {
                $product_id = $row_a->id;
                $builder = $this->db->table('new_product_ext');
                $row_a->ProductExt = $builder->where('product_id', $product_id)->get()->getFirstRow();
            }
        } else {
            if (in_array("image_other", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('new_product_image');
                $row_a['image_other'] = $builder->where('product_id', $product_id)->get()->getResult("array");
            }
            if (in_array("category", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('new_product_category')->join("pet_category", "new_product_category.cateogry_id = pet_category.id");
                $row_a['tags'] = $builder->where('product_id', $product_id)->orderBy("order", "ASC")->get()->getResult("array");
            }
            if (in_array("units", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('tbl_unit');
                $row_a['units'] = $builder->where('product_id', $product_id)->get()->getResult("array");
            }
            if (in_array("pet", $relation)) {
                $product_code = $row_a['code'];
                $builder = $this->db->table('new_product');
                $row_a['pet'] = $builder->where('code', $product_code)->get()->getFirstRow("array");
            }
            if (in_array("ProductExt", $relation)) {
                $product_id = $row_a['id'];
                $builder = $this->db->table('new_product_ext');
                $row_a['ProductExt'] = $builder->where('product_id', $product_id)->get()->getFirstRow("array");
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
    public function get_product_related($id, $categories)
    {
        if (empty($categories)) {
            return array();
        }
        $builder = $this->db->table("product");
        $builder->whereIn('id', function (BaseBuilder $builder) use ($categories) {
            return $builder->select('product_id')->from('new_product_category')->whereIn('category_id', $categories);
        });
        return $builder->where("status", 1)->where("is_pet", 1)->where('id !=', $id)->get()->getResult();
    }

    public function get_product($category_id = 0, $keyword = "", $offset = 0, $limit = 20)
    {
        $builder = $this->db->table("cf_product");

        if ($category_id > 0) {
            $builder->whereIn('id', function (BaseBuilder $builder) use ($category_id) {
                return $builder->select('product_id')->from('cf_product_category')->where('category_id', $category_id);
            });
        }
        if ($keyword != "") {
            $builder->groupStart();
            $builder->like('code', $keyword);
            $builder->orLike("name_" . current_language(), $keyword);
            $builder->groupEnd();
        }

        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }
        //print_r($builder->where("deleted_at", NULL)->where("deleted", 0)->orderBy("id", "DESC")->limit($limit, $offset)->getCompiledSelect());
        //die();
        return $builder->where("deleted_at", NULL)->where("deleted", 0)->orderBy("date", "DESC")->get()->getResult();
    }

    function get_product_by_category($category_id, $perPage = 20, $page = 1, $sort = "")
    {

        $offset = ($page - 1) * $perPage;
        $my_region = area_current();
        $builder = $this->db->table('product')->join("new_product_category", "new_product_category.product_id = product.id");
        $count = $builder->where("status = 1 and is_pet = 1 and FIND_IN_SET('$my_region',region) AND category_id = $category_id")->orderBy("new_product_category.order", "ASC")->countAllResults();

        $builder = $this->db->table('product')->join("new_product_category", "new_product_category.product_id = product.id")->select("product.*");
        if ($sort == "price-asc") {
            $builder->orderBy('product.retail_price', "ASC");
        } elseif ($sort == "price-desc") {
            $builder->orderBy('product.retail_price', "DESC");
        } else {
            $builder->orderBy("new_product_category.order", "ASC");
        }
        $products = $builder->where("status = 1 and is_pet = 1 and FIND_IN_SET('$my_region',region) AND category_id = $category_id")->limit($perPage, $offset)->get()->getResult();

        ////CateGory con
        $builder = $this->db->table('pet_category');
        $category = $builder->where("is_home = 1 and parent_id = $category_id")->orderBy("pet_category.date", "DESC")->get()->getResult();

        foreach ($products as &$product) {
            $this->format_product($product);
        }

        // echo "<pre>";
        // print_r($count);
        // die();
        $return = array(
            'count_product' => $count,
            'products' => $products,
            'child' => $category
        );
        return $return;
    }
    function get_product_promotion($perPage = 20, $page = 1, $sort = "")
    {

        $offset = ($page - 1) * $perPage;
        $my_region = area_current();
        $builder = $this->db->table('product')->join("new_product_price", "new_product_price.product_id = product.id");
        $count = $builder->where("status = 1 and is_pet = 1 and FIND_IN_SET('$my_region',region) and NOW() BETWEEN new_product_price.date_from AND new_product_price.date_to AND new_product_price.deleted_at IS NULL")->orderBy("product.sort", "DESC")->countAllResults();

        $builder = $this->db->table('product')->join("new_product_price", "new_product_price.product_id = product.id")->select("product.*");
        if ($sort == "price-asc") {
            $builder->orderBy('product.retail_price', "ASC");
        } elseif ($sort == "price-desc") {
            $builder->orderBy('product.retail_price', "DESC");
        } else {
            $builder->orderBy("product.sort", "DESC");
        }
        $products = $builder->where("status = 1 and is_pet = 1 and FIND_IN_SET('$my_region',region) and NOW() BETWEEN new_product_price.date_from AND new_product_price.date_to AND new_product_price.deleted_at IS NULL")->groupBy("product.id")->limit($perPage, $offset)->get()->getResult();


        foreach ($products as &$product) {
            $this->format_product($product);
        }

        // echo "<pre>";
        // print_r($count);
        // die();
        $return = array(
            'count_product' => $count,
            'products' => $products
        );
        return $return;
    }
    function format_product(&$product)
    {
        $product_id = $product->id;
        $product_code = $product->code;
        $builder = $this->db->table('tbl_unit');
        $product->units = $builder->where('product_id', $product_id)->orderBy("price", "ASC")->get()->getResult();
        // echo "<pre>";
        // print_r($product->units);
        // die();
        $builder = $this->db->table('new_product_price');
        $product->price_km = $builder->where('product_id', $product_id)->where('deleted_at', NULL)->get()->getResult();

        $builder = $this->db->table('new_product');
        $product->pet = $builder->where('code', $product_code)->get()->getFirstRow();


        $price_km = isset($product->price_km) ?  array_values((array) $product->price_km) : array();
        if (isset($product->pet)) {
            if ($product->pet->name_vi != "")
                $product->name_vi = $product->pet->name_vi;
            if ($product->pet->name_en != "")
                $product->name_en = $product->pet->name_en;
            if ($product->pet->name_jp != "")
                $product->name_jp = $product->pet->name_jp;

            if ($product->pet->volume_vi != "")
                $product->volume_vi = $product->pet->volume_vi;
            if ($product->pet->volume_en != "")
                $product->volume_en = $product->pet->volume_en;
            if ($product->pet->volume_jp != "")
                $product->volume_jp = $product->pet->volume_jp;

            if ($product->pet->description_vi != "")
                $product->description_vi = $product->pet->description_vi;

            if ($product->pet->description_en != "")
                $product->description_en = $product->pet->description_en;
            if ($product->pet->description_jp != "")
                $product->description_jp = $product->pet->description_jp;

            if ($product->pet->detail_vi != "")
                $product->detail_vi = $product->pet->detail_vi;
            if ($product->pet->detail_en != "")
                $product->detail_en = $product->pet->detail_en;
            if ($product->pet->detail_jp != "")
                $product->detail_jp = $product->pet->detail_jp;

            if ($product->pet->guide_vi != "")
                $product->guide_vi = $product->pet->guide_vi;
            if ($product->pet->guide_en != "")
                $product->guide_en = $product->pet->guide_en;
            if ($product->pet->guide_jp != "")
                $product->guide_jp = $product->pet->guide_jp;
            if ($product->pet->price != "")
                $product->retail_price = $product->pet->price;
        }


        $product->price = $product->retail_price;

        if (!empty($product->units)) {
            // $product->units = array_values((array) $product->units);
            // usort($product->units, function ($a, $b) {
            //     return $a->price > $b->price;
            // });
            foreach ($product->units as $key => &$unit) {
                // if ($unit->deleted == 1) {
                //     unset($product->units[$key]);
                //     break;
                // }
                $unit_id = $unit->id;

                $unit_km = array_values(array_filter($price_km, function ($item) use ($unit_id) {
                    return $item->unit_id == $unit_id;
                }));
                // print_r($price_km);
                if (!empty($unit_km)) {
                    $unit->km_price = $unit_km[0]->price;
                    $unit->prev_price = $unit->price;
                    $unit->price = $unit->km_price;
                    $unit->down_per = $unit->prev_price > 0 ? round(($unit->price - $unit->prev_price) * 100 / $unit->prev_price, 0) : 0;
                }

                // print_r($unit);
            }
            $product->units = array_values((array) $product->units);
            usort($product->units, function ($a, $b) {
                return $a->price > $b->price;
            });
        } else {

            $list_km = array();
            foreach ($price_km as $row1) {
                $now =  date("Y-m-d H:i:s");
                if ($row1->date_from <= $now && $row1->date_to >= $now)
                    $list_km[] = $row1;
            }
            if (isset($list_km[0]->price)) {
                $product->km_price = $list_km[0]->price;
                $product->prev_price = $product->price;
                $product->price = $product->km_price;
                $product->down_per = $product->prev_price > 0 ? round(($product->price - $product->prev_price) * 100 / $product->prev_price, 0) : 0;
            }
        }
        return $product;
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
