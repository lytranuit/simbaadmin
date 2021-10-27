<?php

namespace App\Controllers\Admin;


class Categoryrecipe extends BaseController
{
    function __construct()
    {
        $this->group = 'CATEGORY_RECIPE';
    }
    public function index()
    {

        // load_datatable($this->data);
        $category_model = model("CategoryModel");
        $categories = $category_model->where('group', $this->group)->orderby('sort', "ASC")->asArray()->findAll();
        //echo "<pre>";
        //print_r($category);
        //die();
        if (empty($categories))
            $categories = array();
        $this->data['html_nestable'] = html_nestable($categories, 'parent_id', 0,  $this->data['controller']);
        return view($this->data['content'], $this->data);
    }
    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");
            $Category_model = model("CategoryModel");
            $data = $this->request->getPost();
            $data['group'] =  $this->group;
            $obj = new \App\Entities\Category();
            $obj->fill($data);
            $Category_model->save($obj);
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            //load_editor($this->data);
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Category_model = model("CategoryModel");
            $recipe_category_model = model("RecipeCategoryModel");
            $data = $this->request->getPost();

            $obj = $Category_model->create_object($data);
            // print_r($obj);die();
            $Category_model->update($id, $obj);
            if (isset($data['recipe_category'])) {
                foreach ($data['recipe_category'] as $key => $row) {
                    $data_up = array(
                        'order' => $key,
                        'category_id' => $id
                    );
                    $recipe_category_model->update($row, $data_up);
                }
            }
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            $Category_model = model("CategoryModel");
            $recipe_model = model("RecipeModel");
            $recipe_category_model = model("RecipeCategoryModel");
            $tin = $Category_model->where(array('id' => $id))->asObject()->first();
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();   
            $this->data['recipes'] = $recipe_category_model->recipe_by_category($id);
            // echo "<pre>";
            // print_r($this->data['recipes']);
            // die();
            $this->data['recipes_add'] = $recipe_model->asObject()->findAll();

            $this->data['recipes_disable'] = array_map(function ($item) {
                return $item->recipe_id;
            }, (array) $this->data['recipes']);
            // echo "<pre>";
            // print_r($this->data['recipes_disable']);
            // die();


            return view($this->data['content'], $this->data);
        }
    }

    public function deletemenu()
    {
        $id = $this->request->getPost('id');
        $CategoryModel = model("CategoryModel");
        $CategoryModel->delete($id);
    }

    public function saveorder()
    {
        $CategoryModel = model("CategoryModel");
        $data = json_decode($this->request->getPost('data'), true);
        foreach ($data as $key => $row) {
            if (isset($row['id'])) {
                $id = $row['id'];
                $parent_id = isset($row['parent_id']) && $row['parent_id'] != "" ? $row['parent_id'] : 0;
                $array = array(
                    'parent_id' => $parent_id,
                    'sort' => $key
                );
                $CategoryModel->update($id, $array);
            }
        }
    }

    public function remove_recipe($id)
    { /////// trang ca nhan
        $RecipeCategoryModel = model("RecipeCategoryModel");
        $RecipeCategoryModel->where(array("id" => $id))->delete();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


    public function addrecipecategory()
    {
        $RecipeCategoryModel = model("RecipeCategoryModel");
        $data = json_decode($this->request->getVar('data'), true);
        $category_id = $this->request->getVar('category_id');

        $list = $RecipeCategoryModel->where(array("category_id" => $category_id))->asObject()->findAll();
        $max_order = 0;
        foreach ($list as $row) {
            if ($max_order < $row->order) {
                $max_order = $row->order;
            }
        }
        $list_recipe = array_map(function ($item) {
            return $item->recipe_id;
        }, (array) $list);
        $data = array_diff($data, $list_recipe);
        $max_order++;
        foreach ($data as $key => $recipe_id) {

            $array = array(
                'recipe_id' => $recipe_id,
                'category_id' => $category_id,
                'order' => $max_order
            );
            $RecipeCategoryModel->insert($array);
        }
        echo json_encode(1);
    }
}
