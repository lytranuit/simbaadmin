<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Slider extends BaseController
{

    public function index()
    { // load_datatable($this->data);
        $SliderModel = model("SliderModel");
        $this->data['slider'] = $SliderModel->orderby('order', "ASC")->findAll();
        return view($this->data['content'], $this->data);
    }

    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");

            $Slider_model = model("SliderModel");
            $data = $this->request->getPost();
            $data['user_id'] = user_id();
            $obj = new \App\Entities\Slider();
            $obj->fill($data);
            $obj->date = date("Y-m-d H:i:s");
            $Slider_model->save($obj);
            return redirect()->to(base_url('admin/slider'));
        } else {
            //load_editor($this->data);
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Slider_model = model("SliderModel");
            $data = $this->request->getPost();
            $obj = $Slider_model->find($id);
            //echo "<pre>";
            //print_r($obj);
            //die();
            $obj->fill($data);
            $Slider_model->save($obj);
            return redirect()->to(base_url('admin/slider'));
        } else {
            $Slider_model = model("SliderModel");
            $tin = $Slider_model->where(array('id' => $id))->asObject()->first();
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
        $Slider_model = model("SliderModel");
        $Slider_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $Slider_model = model("SliderModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $Slider_model;

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;

        $where = $Slider_model;
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['order'] = $post->order;
                $nestedData['image'] = "<img src='http://simbaeshop.com$post->image_url' width='100'/>";
                $nestedData['action'] = '<a href="' . base_url("admin/slider/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url("admin/slider/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
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
    public function saveorder()
    {
        $SliderModel = model("SliderModel");
        $data = json_decode($this->request->getPost('data'), true);
        foreach ($data as $key => $row) {
            if (isset($row['id'])) {
                $id = $row['id'];
                $array = array(
                    'order' => $key
                );
                $SliderModel->update($id, $array);
            }
        }
    }
}
