<?php

namespace App\Controllers\Admin;


class Categorymain extends BaseController
{
    function __construct()
    {
        $this->group = 'CATEGORY_MAIN';
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
            $product_category_model = model("ProductCategoryModel");
            $data = $this->request->getPost();

            $obj = $Category_model->create_object($data);
            // print_r($obj);die();
            $Category_model->update($id, $obj);
            if (isset($data['product_category'])) {
                foreach ($data['product_category'] as $key => $row) {
                    $data_up = array(
                        'order' => $key,
                        'category_id' => $id
                    );
                    $product_category_model->update($row, $data_up);
                }
            }
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            $Category_model = model("CategoryModel");
            $product_model = model("ProductModel");
            $product_category_model = model("ProductCategoryModel");
            $tin = $Category_model->where(array('id' => $id))->asObject()->first();
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();   
            $this->data['products'] = $product_category_model->product_by_category($id);
            // echo "<pre>";
            // print_r($this->data['products']);
            // die();
            $this->data['products_add'] = $product_model->where(array("status" => 1))->asObject()->findAll();

            $this->data['products_disable'] = array_map(function ($item) {
                return $item->product_id;
            }, (array) $this->data['products']);
            // echo "<pre>";
            // print_r($this->data['products_disable']);
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

    public function remove_product($id)
    { /////// trang ca nhan
        $ProductCategoryModel = model("ProductCategoryModel");
        $ProductCategoryModel->where(array("id" => $id))->delete();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


    public function addproductcategory()
    {
        $ProductCategoryModel = model("ProductCategoryModel");
        $data = json_decode($this->request->getVar('data'), true);
        $category_id = $this->request->getVar('category_id');

        $list = $ProductCategoryModel->where(array("category_id" => $category_id))->asObject()->findAll();
        $max_order = 0;
        foreach ($list as $row) {
            if ($max_order < $row->order) {
                $max_order = $row->order;
            }
        }
        $list_product = array_map(function ($item) {
            return $item->product_id;
        }, (array) $list);
        $data = array_diff($data, $list_product);
        $max_order++;
        foreach ($data as $key => $product_id) {

            $array = array(
                'product_id' => $product_id,
                'category_id' => $category_id,
                'order' => $max_order
            );
            $ProductCategoryModel->insert($array);
        }
        echo json_encode(1);
    }
}
