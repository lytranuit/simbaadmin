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
            // foreach ($tin->details as &$row) {
            //     $row->product = $product_model->where(array('id' => $row->product_id))->asObject()->first();
            //     $product_model->relation($row->product, array("image"));
            // }
            // echo "<pre>";
            // print_r($tin->details);
            // die();
            $this->data['tin'] = $tin;
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $SaleModel = model("SaleModel");
        $SaleModel->update($id, array("deleted" => 1));
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $sale_model = model("SaleModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $search_type = $this->request->getPost('search_type');
        $search_status = $this->request->getPost('search_status');
        $page = ($start / $limit) + 1;
        $where = $sale_model->where("deleted", 0);
        $totalData = $where->countAllResults(false);
        //echo "<pre>";
        //print_r($totalData);
        //die();
        if (empty($this->request->getPost('search')['value'])) {
            //            $max_page = ceil($totalFiltered / $limit);

            $totalFiltered = $totalData;
        } else {
            $search = $this->request->getPost('search')['value'];
            $where =  $where->like('code', $search);
            $totalFiltered = $where->countAllResults(false);
        }

        if ($search_type == "status" && $search_status != "") {
            $where->where("status", $search_status);
            $totalFiltered = $where->countAllResults(false);
        } elseif (empty($search)) {
            // $where = $Document_model;
            // echo "1";die();
        } elseif ($search_type == "code") {
            $where->like("code", $search, "after");
            $totalFiltered = $where->countAllResults(false);
        } elseif ($search_type == "") {
            $where->like("code", $search, "after");
            // $where->orLike("name_vi", $search);
            $totalFiltered = $where->countAllResults(false);
        } else {
            $where->like($search_type, $search);
            $totalFiltered = $where->countAllResults(false);
        }

        if (isset($orders)) {
            foreach ($orders as $order) {
                $data = $order['data'];
                $dir = $order['dir'];
                switch ($data) {
                    default:
                        $where->orderby($data, $dir);
                        break;
                    case 'status':
                        $where->orderby('status_id', $dir);
                        break;
                    case 'type':
                        $where->orderby('type_id', $dir);
                        break;
                }
            }
        }
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->code;
                $nestedData['order_date'] = $post->order_date;
                $nestedData['delivery_date'] = $post->delivery_date;
                $nestedData['customer_name'] = $post->customer_name;
                $nestedData['discount'] = $post->discount;
                $nestedData['total_amount'] = "<b>" . number_format($post->total_amount, 0, ".", ",") . "</b>";
                $nestedData['status'] = "M???i ?????t h??ng";
                switch ($post->status) {
                    case 1:
                        $nestedData['status'] = "M???i ?????t h??ng";
                        break;
                    case 2:
                        $nestedData['status'] = "???? x??c nh???n, ch??? giao";
                        break;
                    case 3:
                        $nestedData['status'] = "???? thanh to??n";
                        break;
                    case 4:
                        $nestedData['status'] = "Ho??n t???t giao h??ng";
                        break;
                    case 5:
                        $nestedData['status'] = "???? h???y";
                        break;
                    case 8:
                        $nestedData['status'] = "??ang giao h??ng";
                        break;
                }
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
