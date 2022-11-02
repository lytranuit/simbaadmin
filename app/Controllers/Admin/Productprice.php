<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Productprice extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function get_units($id)
    {
        $ProductUnit_model = model("ProductUnitModel");
        $json_data = $ProductUnit_model->where(array('product_id' => $id))->asArray()->findAll();
        echo json_encode($json_data);
    }
    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            $data = $_POST;
            $date = explode(" - ", $data['daterange']);
            $data['date_from'] = date("Y-m-d", strtotime($date[0]));
            $data['date_to'] = date("Y-m-d", strtotime($date[1]));
            $ProductPrice_model = model("ProductPriceModel");
            $data_up = $ProductPrice_model->create_object($data);
            $id = $ProductPrice_model->insert($data_up);
            return redirect()->to(base_url('admin/productprice'));
        } else {
            load_daterangepicker($this->data);
            load_chossen($this->data);
            $Product_model = model("ProductModel");
            $this->data['products'] = $Product_model->where(array("status" => 1, 'is_pet' => 1))->findAll();
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            $ProductPrice_model = model("ProductPriceModel");
            $data = $_POST;

            $date = explode(" - ", $data['daterange']);
            $data['date_from'] = date("Y-m-d", strtotime($date[0]));
            $data['date_to'] = date("Y-m-d", strtotime($date[1]));
            $data_up = $ProductPrice_model->create_object($data);
            $ProductPrice_model->update($id, $data_up);
            return redirect()->to(base_url('admin/productprice'));
        } else {
            $ProductPrice_model = model("ProductPriceModel");
            $Product_model = model("ProductModel");
            $ProductUnit_model = model("ProductUnitModel");
            $tin = $ProductPrice_model->where(array('id' => $id))->asObject()->first();

            $this->data['products'] = $Product_model->where(array("status" => 1, 'is_pet' => 1))->findAll();
            $this->data['units'] = $ProductUnit_model->where("product_id", $tin->product_id)->findAll();
            $this->data['tin'] = $tin;

            load_daterangepicker($this->data);
            load_chossen($this->data);
            // echo "<pre>";
            // print_r($this->data);
            // die();
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $ProductPriceModel = model("ProductPriceModel");
        $ProductPriceModel->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    public function table()
    { /////// trang ca nhan
        $ProductPrice_model = model("ProductPriceModel");
        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $page = ($start / $limit) + 1;
        $where = $ProductPrice_model;

        $totalData = $where->countAllResults();
        $totalFiltered = $totalData;
        $where = $ProductPrice_model;


        $posts = $where->asObject()->orderBy("id", "DESC")->paginate($limit, '', $page);
        $ProductPrice_model->relation($posts, array('unit', 'product'));

        //        echo "<pre>";
        //        print_r($posts);
        //        die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['code'] = isset($post->product->code) ? $post->product->code : "";
                $nestedData['name_vi'] = isset($post->product->name_vi) ? $post->product->name_vi : "";
                $nestedData['unit_name'] = isset($post->unit->name_vi) ? $post->unit->name_vi : "";
                $nestedData['price'] = number_format($post->price, 0, ",", ".") . " VND";
                $nestedData['date_from'] = date("d/m/Y", strtotime($post->date_from));
                $nestedData['date_to'] = date("d/m/Y", strtotime($post->date_to));
                // $nestedData['date'] =  date("d/m/Y", strtotime($post->date));
                $nestedData['action'] = '<a href="' . base_url() . '/admin/productprice/edit/' . $post->id . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url() . '/admin/productprice/remove/' . $post->id . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
                    . '<i class="far fa-trash-alt">'
                    . '</i>'
                    . '</a>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
}
