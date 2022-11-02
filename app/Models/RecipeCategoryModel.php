<?php

namespace App\Models;


use CodeIgniter\Model;

class RecipeCategoryModel extends Model
{
    protected $table      = 'new_recipe_category';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['recipe_id', 'category_id', 'order'];

    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
    public function recipe_by_category($id)
    {

        $builder = $this->db->table('new_recipe_category');
        $builder->select('*,new_recipe_category.id as pc_id');
        return $builder->where(array('category_id' => $id))->orderby('new_recipe_category.order', "ASC")->join('new_recipe', 'new_recipe.id = new_recipe_category.recipe_id')->get()->getResult();
    }
}
