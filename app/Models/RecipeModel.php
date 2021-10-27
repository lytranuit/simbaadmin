<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class RecipeModel extends Model
{
    protected $table      = 'new_recipe';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Recipe';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name_vi', 'name_en', 'name_jp', 'content_vi', 'content_en', 'content_jp', 'element_vi', 'element_en', 'element_jp', 'date', 'user_id', 'image_url', 'prepare_time', 'cook_time', 'ready_to_eat', 'number_of_eat', 'energy', 'star'];



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
            if (in_array("tag", $relation)) {
                $post_id = $row_a->id;
                $builder = $this->db->table('new_post_tag')->join("new_tag", "new_post_tag.cateogry_id = new_tag.id");
                $row_a->tags = $builder->where('post_id', $post_id)->orderBy("order", "ASC")->get()->getResult();
            }
        } else {
            if (in_array("tag", $relation)) {
                $post_id = $row_a['id'];
                $builder = $this->db->table('new_post_tag')->join("new_tag", "new_post_tag.cateogry_id = new_tag.id");
                $row_a['tags'] = $builder->where('post_id', $post_id)->orderBy("order", "ASC")->get()->getResult("array");
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
    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    protected $skipValidation     = true;
}
