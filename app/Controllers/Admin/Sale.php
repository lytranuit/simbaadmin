<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Sale extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }


    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $sale_model = model("SaleModel");
            $data = $this->request->getPost();
            $obj = $sale_model->find($id);
            $obj->fill($data);
            $sale_model->save($obj);
            return redirect()->to(base_url('admin/sale'));
        } else {
            $sale_model = model("SaleModel");
            $sale_line_model = model("SaleLineModel");
            $product_model = model("ProductModel");
            $tin = $sale_model->where(array('id' => $id))->asObject()->first();
            $tin->details = $sale_line_model->where(array('order_id' => $tin->id))->asObject()->findAll();
            foreach ($tin->details as &$row) {
                $row->product = $product_model->where(array('id' => $row->product_id))->asObject()->first();
                $product_model->relation($row->product, array("image"));
            }
            //echo "<pre>";
            //print_r($tin);
            //die();
            $this->data['tin'] = $tin;
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $sale_model = model("SaleModel");
        $sale_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $sale_model = model("SaleModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $sale_model;

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;

        $where = $sale_model;
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->code;
                $nestedData['order_date'] = $post->order_date;
                $nestedData['customer_name'] = $post->name;
                $nestedData['customer_phone'] = $post->phone;
                $nestedData['customer_address'] = $post->address;
                $nestedData['total_amount'] = number_format($post->total_amount, 0, ".", ",");
                $nestedData['action'] = '<a href="' . base_url("admin/sale/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url("admin/sale/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
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
}
