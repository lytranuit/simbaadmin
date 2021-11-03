<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table      = 'settings';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['opt_key', 'name', 'name_en', 'name_vi', 'opt_value', 'opt_value_en', 'opt_value_jp', "group_name"];

    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
    function get_options_groups($group)
    {
        $builder = $this->db->table('settings');
        $rows = $builder->where('group_name', $group)->get()->getResult("array");
        $return = array();
        foreach ($rows as $row) {
            $return[$row['opt_key']] = $row;
        }
        return $return;
    }
}
