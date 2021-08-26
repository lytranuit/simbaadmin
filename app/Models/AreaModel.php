<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table      = 'pet_area';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\News';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'order', 'parrent_id', 'region'];

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

            if (in_array("fee", $relation)) {
                $area_id = $row_a->id;
                $builder = $this->db->table('pet_area_fee');
                $row_a->fee = $builder->where('area_id', $area_id)->get()->getResult();
            }
        } else {
            if (in_array("fee", $relation)) {
                $area_id = $row_a['id'];
                $builder = $this->db->table('pet_area_fee');
                $row_a['fee'] = $builder->where('area_id', $area_id)->get()->getResult("array");
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
