<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Customer extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }


    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Customer_model = model("CustomerModel");
            $ProductPrivate_model = model("ProductPrivateModel");
            $data = $this->request->getPost();
            // echo "<pre>";
            // print_r($data);
            // die();
            $obj = $Customer_model->create_object($data);
            $Customer_model->update($id, $obj);

            /*Private*/

            $related_new = array();
            if (isset($data['product_list'])) {
                $related_new = array_merge($related_new, $data['product_list']);
                unset($data['product_list']);
            }
            $ProductPrivate_model->where('customer_id', $id)->delete();
            foreach ($related_new as $row) {
                $array = array(
                    'customer_id' => $id,
                    'product_id' => $row
                );
                $ProductPrivate_model->insert($array);
            }

            return redirect()->to(base_url('admin/customer'));
        } else {
            $Customer_model = model("CustomerModel");
            $tin = $Customer_model->where(array('id' => $id))->asObject()->first();
            $Customer_model->relation($tin, array('products'));

            if (!empty($tin->products)) {
                $product_id = array();
                foreach ($tin->products as $key => $product) {
                    $product_id[] = $product->id;
                }
                $tin->product_list = $product_id;
            }
            // echo "<pre>";
            // print_r($tin);
            // die();
            $this->data['products'] = $tin->products;
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();
            return view($this->data['content'], $this->data);
        }
    }
    public function productlist()
    {
        $Product_model = model("ProductModel");
        $data = $this->request->getPost('data');
        $search = $data['q'];
        $data = $Product_model->where("(code like '%$search%' OR name_vi like '%$search%')")->asArray()->paginate(1000, '', 0);
        //        } else {
        //            $data = $this->productsimba_model->where("(code like '%$search%' OR name_vi like '%$search%') AND id IN (SELECT DISTINCT product_id FROM product_order WHERE order_date > DATE_SUB(now(), INTERVAL 6 MONTH))", NULL, NULL, FALSE, FALSE, TRUE)->limit(20)->as_array()->get_all();
        //        }
        $results = array();
        foreach ($data as $row) {
            $results[] = array("id" => $row['id'], 'text' => $row['code'] . ' - ' . $row['name_vi']);
        }
        echo json_encode(array('q' => $search, 'results' => $results));
        die();
    }

    public function table()
    {
        $Customer_model = model("CustomerModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $Customer_model->where('deleted', 0);

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;
        if (empty($this->request->getPost('search')['value'])) {
            //            $max_page = ceil($totalFiltered / $limit);

            $where = $Customer_model->where(array("deleted" => 0));
        } else {
            $search = $this->request->getPost('search')['value'];
            $sWhere = "deleted = 0 AND (LOWER(code) LIKE LOWER('%$search%') OR name like '%" . $search . "%')";
            $where =  $Customer_model->where($sWhere);
            $totalFiltered = $where->countAllResults();
            $where = $Customer_model->where($sWhere);
        }

        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        // echo "<pre>";
        // print_r($posts);
        // die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = '<a href="' . base_url("admin/customer/edit/" . $post->id) . '" title="edit">'
                    . '<i class="fas fa-pencil-alt mr-2">'
                    . '</i>'
                    . $post->id
                    . '</a>';
                $nestedData['code'] = $post->code;
                $nestedData['name'] = $post->name;
                $nestedData['phone'] = $post->phone;
                $nestedData['email'] = $post->email;
                // $image = isset($post->image->src) ? base_url() . $post->image->src : "";
                // $nestedData['image'] = "<img src='$image' width='100'/>";
                // $nestedData['action'] = '<a href="' . base_url("admin/product/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                //     . '<i class="fas fa-pencil-alt">'
                //     . '</i>'
                //     . '</a>';

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
