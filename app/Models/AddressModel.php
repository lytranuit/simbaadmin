<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table      = 'pet_address';
    protected $primaryKey = 'id';

    protected $returnType     = 'App\Entities\Address';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'address', 'phone', 'email', 'user_id', 'area_id'];

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

            if (in_array("area", $relation)) {
                $area_id = $row_a->area_id;
                $builder = $this->db->table('pet_area');
                $row_a->area = $builder->where('id', $area_id)->get()->getResult();
            }
        } else {
            if (in_array("area", $relation)) {
                $area_id = $row_a['area_id'];
                $builder = $this->db->table('pet_area_fee');
                $row_a['area'] = $builder->where('id', $area_id)->get()->getResult("array");
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
