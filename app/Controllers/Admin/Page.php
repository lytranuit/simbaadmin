<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Page extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");

            $Page_model = model("PageModel");
            $data = $this->request->getPost();
            $data['user_id'] = user_id();
            $data['slug'] = str_slug($data['title_vi']);
            $obj = new \App\Entities\Page();
            $obj->fill($data);
            $obj->date = date("Y-m-d H:i:s");
            $Page_model->save($obj);
            return redirect()->to(base_url('admin/page'));
        } else {
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Page_model = model("PageModel");
            $data = $this->request->getPost();
            $obj = $Page_model->find($id);
            $obj->fill($data);
            $Page_model->save($obj);
            return redirect()->to(base_url('admin/page'));
        } else {
            $Page_model = model("PageModel");
            $tin = $Page_model->where(array('id' => $id))->asObject()->first();
            $Page_model->image($tin);
            //print_r($category);
            //die();
            $this->data['tin'] = $tin;
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $Page_model = model("PageModel");
        $Page_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $Page_model = model("PageModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $Page_model;

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;

        $where = $Page_model;
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();
        $Page_model->image($posts);
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['title_vi'] = $post->title_vi;
                $image = isset($post->image->src) ? base_url($post->image->src) : "";
                $nestedData['image'] = "<img src='$image' width='100'/>";
                // $image = isset($post->image->src) ? base_url() . $post->image->src : "";
                // $nestedData['image'] = "<img src='$image' width='100'/>";
                $nestedData['date'] =  date("d/m/Y", strtotime($post->date));
                $nestedData['action'] = '<a href="' . base_url("admin/page/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url("admin/page/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
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
