<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Usercustomer extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");

            $Usercustomer_model = model("UsercustomerModel");
            $data = $this->request->getPost();
            $data['password'] = md5($data['password']);
            $obj = new \App\Entities\Usercustomer();
            $obj->fill($data);
            $obj->date = date("Y-m-d H:i:s");
            $Usercustomer_model->save($obj);
            return redirect()->to(base_url('admin/usercustomer'));
        } else {
            //load_editor($this->data);

            $CustomerModel = model("CustomerModel");
            $this->data['customers'] = $CustomerModel->findAll();
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Usercustomer_model = model("UsercustomerModel");
            $data = $this->request->getPost();
            $obj = $Usercustomer_model->find($id);
            //echo "<pre>";
            //print_r($obj);
            //die();
            $obj->fill($data);
            $Usercustomer_model->save($obj);
            return redirect()->to(base_url('admin/usercustomer'));
        } else {
            $Usercustomer_model = model("UsercustomerModel");
            $tin = $Usercustomer_model->where(array('id' => $id))->asObject()->first();
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();
            //load_editor($this->data);
            //            load_chossen($this->data);
            $CustomerModel = model("CustomerModel");
            $this->data['customers'] = $CustomerModel->findAll();
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $Usercustomer_model = model("UsercustomerModel");
        $Usercustomer_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $Usercustomer_model = model("UsercustomerModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $Usercustomer_model;

        $totalData = $where->countAllResults(false);
        //echo "<pre>";
        //print_r($totalData);
        //die();
        if (empty($this->request->getPost('search')['value'])) {
            //            $max_page = ceil($totalFiltered / $limit);

            $totalFiltered = $totalData;
        } else {
            $search = $this->request->getPost('search')['value'];
            $where =  $where->like('username', $search)->orLike("fullname", $search);
            $totalFiltered = $where->countAllResults(false);
        }

        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['username'] = $post->username;
                $nestedData['fullname'] = $post->fullname;
                $nestedData['role'] = $post->role == 1 ? "Admin" : ($post->role == 2 ? "Manager" : ($post->role == 3 ?  "Customer" : "SIMBA USER"));
                $nestedData['active'] = $post->active == '1' ? '<i class="text-success far fa-check-circle"></i>' : '<i class="far fa-times-circle"></i>';
                $nestedData['action'] = '<a href="' . base_url("admin/usercustomer/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url("admin/usercustomer/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
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
