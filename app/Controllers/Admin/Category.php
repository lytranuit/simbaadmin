<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Category extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");

            $Category_model = model("CategoryModel");
            $data = $this->request->getPost();
            $data['user_id'] = user_id();
            $data['slug'] = str_slug($data['name_vi']);
            $obj = new \App\Entities\Category();
            $obj->fill($data);
            $obj->date = date("Y-m-d H:i:s");
            $Category_model->save($obj);
            return redirect()->to(base_url('admin/category'));
        } else {
            //load_editor($this->data);
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Category_model = model("CategoryModel");
            $data = $this->request->getPost();
            $obj = $Category_model->find($id);
            //echo "<pre>";
            //print_r($obj);
            //die();
            $obj->fill($data);
            $Category_model->save($obj);
            return redirect()->to(base_url('admin/category'));
        } else {
            $Category_model = model("CategoryModel");
            $product_model = model("ProductModel");
            $product_category_model = model("ProductCategoryModel");
            $tin = $Category_model->where(array('id' => $id))->asObject()->first();
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();   
            // $this->data['products'] = $product_category_model->where(array('category_id' => $id))->orderby('order', "ASC")->asObject()->findAll();

            $this->data['products'] = $product_category_model->product_by_category($id);
            // echo "<pre>";
            // print_r($this->data['products']);
            // die();
            $this->data['products_add'] = $product_model->where(array("status" => 1, 'is_foodzone' => 1))->asObject()->findAll();



            return view($this->data['content'], $this->data);
        }
    }

    public function up($id)
    { /////// trang ca nhan
        $CategoryModel = model("CategoryModel");
        $data['date'] = date("Y-m-d H:i:s");
        $obj = $CategoryModel->create_object($data);
        $CategoryModel->update($id, $obj);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function remove($id)
    { /////// trang ca nhan
        $Category_model = model("CategoryModel");
        $Category_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function remove_product($id)
    { /////// trang ca nhan
        $ProductCategoryModel = model("ProductCategoryModel");
        $ProductCategoryModel->where(array("id" => $id))->delete();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $Category_model = model("CategoryModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $Category_model;

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;

        $where = $Category_model;

        $posts = $where->asObject()->orderby("date", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['name_vi'] = $post->name_vi;
                $nestedData['description_vi'] = split_string($post->description_vi, 100);
                $nestedData['image'] = "<img src='$post->image_url' width='100'/>";
                $nestedData['action'] = '<a href="' . base_url("admin/category/up/" . $post->id) . '" class="btn btn-primary btn-sm mr-2" data-type="confirm" title="Up to Top">'
                    . '<i class="fas fa-arrow-alt-circle-up"></i>'
                    . '</i>'
                    . '</a><a href="' . base_url("admin/category/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url("admin/category/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
                    . '<i class="far fa-trash-alt">'
                    . '</i>'
                    . '</a>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->request->getVar('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
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
