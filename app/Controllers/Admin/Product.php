<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Product extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }


    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Product_model = model("ProductModel");
            $ProductPet_model = model("ProductPetModel");
            $ProductUnit_model = model("ProductUnitModel");
            $ProductRelated_model = model("ProductRelatedModel");
            $Product_category_model = model("ProductCategoryModel");
            $Product_image_model = model("ProductImageModel");
            $data = $this->request->getPost();

            $code = $data['code'];
            $data_pet = array('code' => $code);
            foreach ($data as $key => $val) {
                if (substr($key, 0, 4) == "pet_") {
                    $key_pet = substr($key, 4);
                    $data_pet[$key_pet] = $val;
                }
            }
            if (isset($data['region'])) {
                $data['region'] = implode(",", $data['region']);
            }

            /* Update */

            // echo "<pre>";
            // print_r($data);
            // die();
            $obj = $Product_model->create_object($data);
            $Product_model->update($id, $obj);
            /* Update Pet */
            $data_up = $ProductPet_model->create_object($data_pet);

            $check =  $ProductPet_model->where(array('code' => $code))->first();
            if (empty($check)) {
                //Update
                $ProductPet_model->insert($data_up);
            } else {
                $ProductPet_model->where('code', $code)->set($data_up)->update();
            }

            /* CATEGORY */
            $related_new = array();
            if (isset($data['category_list'])) {
                $related_new = array_merge($related_new, $data['category_list']);
                unset($data['category_list']);
            }
            //print_r($data);
            //die();

            $array = $Product_category_model->where('product_id', $id)->findAll();
            $related_old = array_map(function ($item) {
                return $item['category_id'];
            }, (array) $array);
            $array_delete = array_diff($related_old, $related_new);
            $array_add = array_diff($related_new, $related_old);
            foreach ($array_add as $row) {
                $array = array(
                    'category_id' => $row,
                    'product_id' => $id
                );
                $Product_category_model->insert($array);
            }
            foreach ($array_delete as $row) {
                $array = array(
                    'category_id' => $row,
                    'product_id' => $id
                );
                $Product_category_model->where($array)->delete();
            }

            /* SP lien quan */
            $array = $ProductRelated_model->where('product_id', $id)->asArray()->findAll();
            $related_old = array_map(function ($item) {
                return $item['product_related_id'];
            }, (array) $array);
            $related_new = array();
            if (isset($data['related'])) {
                $related_new = array_merge($related_new, $data['related']);
            }
            $array_delete = array_diff($related_old, $related_new);
            $array_add = array_diff($related_new, $related_old);
            foreach ($array_add as $row) {
                $array = array(
                    'product_related_id' => $row,
                    'product_id' => $id
                );
                $ProductRelated_model->insert($array);
            }
            foreach ($array_delete as $row) {
                $array = array(
                    'product_related_id' => $row,
                    'product_id' => $id
                );
                $ProductRelated_model->where($array)->delete();
            }
            /*
             * DVT
             */

            // print_r($data['dvt']);
            // die();
            if (isset($data['dvt'])) {
                foreach ($data['dvt'] as $row) {
                    $array = array(
                        'product_id' => $id
                    );
                    $ProductUnit_model->update($row, $array);
                }
            }
            /*
             * Image_other
             */
            // print_r($data['image_other']);
            // die();
            $Product_image_model->where(array('product_id' => $id))->delete();
            if (isset($data['image_other'])) {
                foreach ($data['image_other'] as $row) {
                    $array = array(
                        'product_id' => $id,
                        'image_url' => $row
                    );
                    $Product_image_model->insert($array);
                }
                // die();
            }


            return redirect()->to(base_url('admin/product'));
        } else {
            $Product_model = model("ProductModel");
            $category_model = model("CategoryModel");
            $origin_model = model("OriginModel");
            $preservation_model = model("PreservationModel");
            $Product_category_model = model("ProductCategoryModel");
            $Product_related_model = model("ProductRelatedModel");
            $tin = $Product_model->where(array('id' => $id))->asObject()->first();
            $Product_model->relation($tin, array('image_other', 'units'));
            // echo "<pre>";
            // print_r($tin);
            // die();
            /*Releated*/
            // $product_related = $Product_related_model->where(array('product_id' => $id))->findAll();

            /*category*/
            $category = $Product_category_model->where(array('product_id' => $id))->findAll();
            //print_r($category);
            //die();

            if (!empty($category)) {
                $cate_id = array();
                foreach ($category as $key => $cate) {
                    $cate_id[] = $cate['category_id'];
                }
                $tin->category_list = $cate_id;
            }
            // echo "<pre>";
            // print_r($tin);
            // die();
            // if (!empty($product_related)) {
            //     $related_id = array();
            //     foreach ($product_related as $key => $related) {
            //         $related_id[] = $related->product_related_id;
            //     }
            //     $tin->related = $related_id;
            // }
            if (!empty($tin->region)) {
                $tin->region = explode(",", $tin->region);
            }
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();
            //load_editor($this->data);
            //            load_chossen($this->data);

            // $this->data['product'] = $Product_model->where(array("status" => 1))->findAll();
            $this->data['category'] = $category_model->where('group', "CATEGORY_MAIN")->findAll();
            $this->data['category1'] = $category_model->where('group', "CATEGORY_ZONE")->findAll();
            $this->data['origin'] = $origin_model->findAll();
            $this->data['preservation'] = $preservation_model->findAll();
            $this->data['max_order'] = $Product_model->get_max_order();
            // $this->data['max_order'] = 0;
            return view($this->data['content'], $this->data);
        }
    }

    public function up($id)
    { /////// trang ca nhan
        $Product_model = model("ProductModel");
        $data['date'] = date("Y-m-d H:i:s");
        $obj = $Product_model->create_object($data);
        $Product_model->update($id, $obj);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function save_dvt()
    {
        if (isset($_POST['cap_nhat'])) {
            $data = $_POST;
            $id = $data['id'];

            $ProductUnit_model = model("ProductUnitModel");
            $data_up = $ProductUnit_model->create_object($data);
            if ($id > 0) {
                unset($data_up['id']);
                $ProductUnit_model->update($id, $data_up);
            } else {
                if (isset($data_up['id']))
                    unset($data_up['id']);
                $id = $ProductUnit_model->insert($data_up);
            }
            $unit =  $ProductUnit_model->find($id);
            echo json_encode($unit);
        }
    }
    public function table()
    {
        $Product_model = model("ProductModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $Product_model->where('status', 1);

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;
        if (empty($this->request->getPost('search')['value'])) {
            //            $max_page = ceil($totalFiltered / $limit);

            $where = $Product_model->where(array("status" => 1));
        } else {
            $search = $this->request->getPost('search')['value'];
            $sWhere = "status = 1 AND (LOWER(code) LIKE LOWER('%$search%') OR name_vi like '%" . $search . "%')";
            $where =  $Product_model->where($sWhere);
            $totalFiltered = $where->countAllResults();
            $where = $Product_model->where($sWhere);
        }

        $where = $Product_model;
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        // echo "<pre>";
        // print_r($posts);
        // die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['code'] = $post->code;
                $nestedData['name_vi'] = $post->name_vi;
                $image = "https://simbaeshop.com/$post->image_url";
                $nestedData['image'] = "<img src='$image' width='100'/>";
                $nestedData['active'] = $post->status == 1 ? '<i class="text-success far fa-check-circle"></i>' : '<i class="text-danger far fa-times-circle"></i>';
                $nestedData['active'] = '<div class="text-center">' . $nestedData['active'] . '</div>';
                $nestedData['price'] =  isset($post->pet->price) && $post->pet->price != "" ? number_format($post->pet->price, 0, ",", ".") . " VND" : number_format($post->retail_price, 0, ",", ".") . " VND";
                // $image = isset($post->image->src) ? base_url() . $post->image->src : "";
                // $nestedData['image'] = "<img src='$image' width='100'/>";
                $nestedData['action'] = '<a href="' . base_url("admin/product/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
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
}
