<?php

namespace App\Models;


use CodeIgniter\Model;

class RecipeProductModel extends Model
{
    protected $table      = 'new_recipe_product';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['recipe_id', 'product_id', 'order'];

    //protected $useTimestamps = false;
    //protected $createdField  = 'created_at';
    //protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = true;
    public function recipe_by_product($id)
    {
        $builder = $this->db->table('new_recipe_product');
        $builder->select('*,new_recipe_product.id as pc_id');
        return $builder->where(array('recipe_id' => $id))->orderby('new_recipe_product.order', "ASC")->join('product', 'product.id = new_recipe_product.product_id')->get()->getResult();
    }
}
