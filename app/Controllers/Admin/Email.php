<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Email extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");

            $Origin_model = model("EmailTemplateModel");
            $data = $this->request->getPost();
            $data['user_id'] = user_id();
            $obj = new \App\Entities\EmailTemplate();
            $obj->fill($data);
            $obj->date = date("Y-m-d H:i:s");
            $Origin_model->save($obj);
            return redirect()->to(base_url('admin/email'));
        } else {
            //load_editor($this->data);
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Origin_model = model("EmailTemplateModel");
            $data = $this->request->getPost();
            $obj = $Origin_model->find($id);
            //echo "<pre>";
            //print_r($obj);
            //die();
            $obj->fill($data);
            $Origin_model->save($obj);
            return redirect()->to(base_url('admin/email'));
        } else {
            $Origin_model = model("EmailTemplateModel");
            $tin = $Origin_model->where(array('id' => $id))->asObject()->first();
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();
            //load_editor($this->data);
            //            load_chossen($this->data);
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $Origin_model = model("EmailTemplateModel");
        $Origin_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $Origin_model = model("EmailTemplateModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $Origin_model;

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;

        $where = $Origin_model;
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['subject'] = $post->subject;
                $nestedData['action'] = '<a href="' . base_url("admin/email/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url("admin/email/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
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
