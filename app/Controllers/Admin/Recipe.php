<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Recipe extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");

            $recipe_model = model("RecipeModel");
            $recipe_category_model = model("RecipeCategoryModel");
            $data = $this->request->getPost();
            $data['user_id'] = user_id();
            $obj = new \App\Entities\Recipe();
            $obj->fill($data);
            $obj->date = date("Y-m-d H:i:s");
            $recipe_model->save($obj);
            $id = $recipe_model->getInsertID();
            /* CATEGORY */
            if (isset($data['category_list'])) {

                $array_add = $data['category_list'];
                foreach ($array_add as $row) {
                    $array = array(
                        'category_id' => $row,
                        'recipe_id' => $id
                    );
                    $recipe_category_model->insert($array);
                }
            }
            return redirect()->to(base_url("admin/" . $this->data['controller']));
        } else {
            //load_editor($this->data);

            $category_model = model("CategoryModel");
            $this->data['category'] = $category_model->where('group', "CATEGORY_RECIPE")
                ->orderBy('parent_id', 'ASC')->orderBy('sort', 'ASC')->asArray()->findAll();
            $this->data['category'] = html_product_category_nestable($this->data['category'], 'parent_id', 0);
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $recipe_model = model("RecipeModel");
            $recipe_category_model = model("RecipeCategoryModel");
            $recipe_product_model = model("RecipeProductModel");
            $data = $this->request->getPost();
            $related_new = array();
            if (isset($data['category_list'])) {
                $related_new = array_merge($related_new, $data['category_list']);
                unset($data['category_list']);
            }

            /* CATEGORY */
            $array = $recipe_category_model->where('recipe_id', $id)->findAll();
            $related_old = array_map(function ($item) {
                return $item['category_id'];
            }, (array) $array);
            $array_delete = array_diff($related_old, $related_new);
            $array_add = array_diff($related_new, $related_old);
            foreach ($array_add as $row) {
                $array = array(
                    'category_id' => $row,
                    'recipe_id' => $id
                );
                $recipe_category_model->insert($array);
            }
            foreach ($array_delete as $row) {
                $array = array(
                    'category_id' => $row,
                    'recipe_id' => $id
                );
                $recipe_category_model->where($array)->delete();
            }

            /* Product */
            if (isset($data['recipe_product'])) {
                foreach ($data['recipe_product'] as $key => $row) {
                    $data_up = array(
                        'order' => $key
                    );
                    $recipe_product_model->update($row, $data_up);
                }
            }

            // print_r($data);
            // die();
            $obj = $recipe_model->create_object($data);
            $recipe_model->update($id, $obj);
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            $recipe_model = model("RecipeModel");
            $recipe_category_model = model("RecipeCategoryModel");
            $recipe_product_model = model("RecipeProductModel");
            $product_model = model("ProductModel");
            $tin = $recipe_model->where(array('id' => $id))->asObject()->first();
            /*category*/
            $category = $recipe_category_model->where(array('recipe_id' => $id))->findAll();
            //print_r($category);
            //die();

            if (!empty($category)) {
                $cate_id = array();
                foreach ($category as $key => $cate) {
                    $cate_id[] = $cate['category_id'];
                }
                $tin->category_list = $cate_id;
            }
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();
            //load_editor($this->data);
            //            load_chossen($this->data);

            $category_model = model("CategoryModel");
            $this->data['category'] = $category_model->where('group', "CATEGORY_RECIPE")
                ->orderBy('parent_id', 'ASC')->orderBy('sort', 'ASC')->asArray()->findAll();
            $this->data['category'] = html_product_category_nestable($this->data['category'], 'parent_id', 0);


            $this->data['products'] = $recipe_product_model->recipe_by_product($id);
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

    public function remove($id)
    { /////// trang ca nhan
        $recipe_model = model("RecipeModel");
        $recipe_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $recipe_model = model("RecipeModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $recipe_model;

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;

        $where = $recipe_model;
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = '<a href="' . base_url("admin/recipe/edit/" . $post->id) . '">' . $post->id . '</a>';
                $nestedData['name_vi'] = $post->name_vi;
                $nestedData['image'] = "<img src='" . config('App')->simbaURL . "$post->image_url' width='100'/>";

                $nestedData['content_vi'] = split_string($post->content_vi, 100);
                // $image = isset($post->image->src) ? base_url() . $post->image->src : "";
                // $nestedData['image'] = "<img src='$image' width='100'/>";
                $nestedData['date'] =  date("d/m/Y", strtotime($post->date));
                $nestedData['action'] = '<a href="' . base_url("admin/recipe/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
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
    public function remove_product($id)
    { /////// trang ca nhan
        $RecipeProductModel = model("RecipeProductModel");
        $RecipeProductModel->where(array("id" => $id))->delete();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


    public function addproductrecipe()
    {
        $RecipeProductModel = model("RecipeProductModel");
        $data = json_decode($this->request->getVar('data'), true);
        $recipe_id = $this->request->getVar('recipe_id');

        $list = $RecipeProductModel->where(array("recipe_id" => $recipe_id))->asObject()->findAll();
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
                'recipe_id' => $recipe_id,
                'order' => $max_order
            );
            $RecipeProductModel->insert($array);
        }
        echo json_encode(1);
    }
}
