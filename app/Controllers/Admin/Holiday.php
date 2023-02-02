<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Holiday extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");

            $Holiday_model = model("HolidayModel");
            $data = $this->request->getPost();
            $data['user_id'] = user_id();
            if (isset($data['branchs'])) {
                $data['branch_id'] = implode(",", $data['branchs']);
            }
            // echo "<pre>";
            // print_r($data);
            // die();
            $obj = new \App\Entities\Holiday();
            $obj->fill($data);
            $obj->date = date("Y-m-d H:i:s");
            $Holiday_model->save($obj);
            return redirect()->to(base_url('admin/holiday'));
        } else {
            //load_editor($this->data);

            $BranchModel = model("BranchModel");
            $this->data['branchs'] = $BranchModel->where('deleted', 0)->asArray()->findAll();

            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $Holiday_model = model("HolidayModel");
            $data = $this->request->getPost();
            
            if (isset($data['branchs'])) {
                $data['branch_id'] = implode(",", $data['branchs']);
            }else{
                $data['branch_id'] = null;
            }
            
            // echo "<pre>";
            // print_r($data);
            // die();
            $obj = $Holiday_model->find($id);
            //echo "<pre>";
            //print_r($obj);
            //die();
            $obj->fill($data);
            $Holiday_model->save($obj);
            return redirect()->to(base_url('admin/holiday'));
        } else {
            $Holiday_model = model("HolidayModel");
            $tin = $Holiday_model->where(array('id' => $id))->asObject()->first();
            $tin->branchs = explode(",", $tin->branch_id);
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();
            //load_editor($this->data);
            //            load_chossen($this->data);

            $BranchModel = model("BranchModel");
            $this->data['branchs'] = $BranchModel->where('deleted', 0)->asArray()->findAll();
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $Holiday_model = model("HolidayModel");
        $Holiday_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $Holiday_model = model("HolidayModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $Holiday_model;

        $totalData = $where->countAllResults(false);
        //echo "<pre>";
        //print_r($totalData);
        //die();
        if (empty($this->request->getPost('search')['value'])) {
            //            $max_page = ceil($totalFiltered / $limit);

            $totalFiltered = $totalData;
        } else {
            $search = $this->request->getPost('search')['value'];
            $where =  $where->like('note', $search);
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
                $nestedData['note'] = $post->note;
                $nestedData['holiday'] = $post->holiday;
                $nestedData['action'] = '<a href="' . base_url("admin/holiday/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url("admin/holiday/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
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
