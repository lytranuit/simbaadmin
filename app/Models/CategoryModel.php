<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'new_category';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Category';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name_vi', 'name_en', 'name_jp', 'description_vi', 'description_en', 'description_jp', 'sort', 'parent_id', 'is_displayed', 'image_url', 'group', 'banner_img', 'banner_text_vi','banner_text_en','banner_text_jp'];



    public function relation(&$data, $relation = array())
    {
        $type = gettype($data);
        if ($type == "array" && !isset($data['id'])) {
            foreach ($data as &$row) {
                if (gettype($row) == "object") {
                    if (in_array("product", $relation)) {
                        $category_id = $row->id;
                        $builder = $this->db->table('cf_product_category')->join("cf_category", "cf_product_category.category_id = cf_category.id");
                        $row->products = $builder->where('category_id', $category_id)->get()->getResult();
                    }
                } else {

                    //if (in_array("image_other", $relation)) {
                    //    $news_id = $row['id'];
                    //    $builder = $this->db->table('cf_news_image')->join("cf_file", "cf_news_image.image_id = cf_file.id");
                    //    $row['image_other'] = $builder->where('news_id', $news_id)->get()->getResult("array");
                    //}
                    if (in_array("product", $relation)) {
                        $category_id = $row['id'];
                        $builder = $this->db->table('cf_product_category')->join("cf_category", "cf_product_category.category_id = cf_category.id");
                        $row['products'] = $builder->where('category_id', $category_id)->get()->getResult("array");
                    }
                }
            }
        } elseif ($type == "array" && isset($data['id'])) {

            //if (in_array("image_other", $relation)) {
            //    $news_id = $data['id'];
            //    $builder = $this->db->table('cf_news_image')->join("cf_file", "cf_news_image.image_id = cf_file.id");
            //    $data['image_other'] = $builder->where('news_id', $news_id)->get()->getResult("array");
            //}
            if (in_array("product", $relation)) {
                $category_id = $data['id'];
                $builder = $this->db->table('cf_product_category')->join("cf_category", "cf_product_category.category_id = cf_category.id");
                $data['products'] = $builder->where('category_id', $category_id)->get()->getResult("array");
            }
        } else {

            //if (in_array("image_other", $relation)) {
            //    $news_id = $data->id;
            //    $builder = $this->db->table('cf_news_image')->join("cf_file", "cf_news_image.image_id = cf_file.id");
            //    $data->image_other = $builder->where('news_id', $news_id)->get()->getResult();
            //}
            if (in_array("product", $relation)) {
                $category_id = $data->id;
                $builder = $this->db->table('cf_product_category')->join("cf_category", "cf_product_category.category_id = cf_category.id");
                $data->products = $builder->where('category_id', $category_id)->get()->getResult();
            }
        }
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
