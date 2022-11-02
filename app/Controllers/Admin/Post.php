<?php

namespace App\Controllers\Admin;

use App\Models\FileModel;

class Post extends BaseController
{

    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            helper("auth");

            $post_model = model("PostModel");
            $post_tag_model = model("PostTagModel");
            $data = $this->request->getPost();
            $data['user_id'] = user_id();
            $obj = new \App\Entities\Post();
            $obj->fill($data);
            $obj->date = date("Y-m-d H:i:s");
            $post_model->save($obj);
            $id = $post_model->getInsertID();
            /* CATEGORY */
            if (isset($data['tag_list'])) {

                $array_add = $data['tag_list'];
                foreach ($array_add as $row) {
                    $array = array(
                        'tag_id' => $row,
                        'post_id' => $id
                    );
                    $post_tag_model->insert($array);
                }
            }
            return redirect()->to(base_url("admin/" . $this->data['controller']));
        } else {
            //load_editor($this->data);

            $tag_model = model("TagModel");
            $this->data['category'] = $tag_model->findAll();
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $post_model = model("PostModel");
            $post_tag_model = model("PostTagModel");
            $data = $this->request->getPost();
            $related_new = array();
            if (isset($data['tag_list'])) {
                $related_new = array_merge($related_new, $data['tag_list']);
                unset($data['tag_list']);
            }
            //print_r($data);
            //die();

            /* CATEGORY */
            $array = $post_tag_model->where('post_id', $id)->findAll();
            $related_old = array_map(function ($item) {
                return $item['tag_id'];
            }, (array) $array);
            $array_delete = array_diff($related_old, $related_new);
            $array_add = array_diff($related_new, $related_old);
            foreach ($array_add as $row) {
                $array = array(
                    'tag_id' => $row,
                    'post_id' => $id
                );
                $post_tag_model->insert($array);
            }
            foreach ($array_delete as $row) {
                $array = array(
                    'tag_id' => $row,
                    'post_id' => $id
                );
                $post_tag_model->where($array)->delete();
            }



            $obj = $post_model->create_object($data);
            $post_model->update($id, $obj);
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            $post_model = model("PostModel");
            $tag_model = model("TagModel");
            $post_tag_model = model("PostTagModel");
            $tin = $post_model->where(array('id' => $id))->asObject()->first();
            /*TAG*/
            $category = $post_tag_model->where(array('post_id' => $id))->findAll();
            //print_r($category);
            //die();

            if (!empty($category)) {
                $cate_id = array();
                foreach ($category as $key => $cate) {
                    $cate_id[] = $cate['tag_id'];
                }
                $tin->tag_list = $cate_id;
            }
            $this->data['tin'] = $tin;
            //echo "<pre>";
            //print_r($tin);
            //die();
            //load_editor($this->data);
            //            load_chossen($this->data);

            $this->data['category'] = $tag_model->findAll();
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $post_model = model("PostModel");
        $post_model->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $post_model = model("PostModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $page = ($start / $limit) + 1;
        $where = $post_model;

        $totalData = $where->countAllResults();
        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;

        $where = $post_model;
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);
        //echo "<pre>";
        //print_r($posts);
        //die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] = $post->id;
                $nestedData['name_vi'] = $post->name_vi;
                $nestedData['image'] = "<img src='" . config('App')->simbaURL . "$post->image_url' width='100'/>";

                $nestedData['content_vi'] = split_string($post->content_vi, 100);
                // $image = isset($post->image->src) ? base_url() . $post->image->src : "";
                // $nestedData['image'] = "<img src='$image' width='100'/>";
                $nestedData['date'] =  date("d/m/Y", strtotime($post->date));
                $nestedData['action'] = '<a href="' . base_url("admin/post/edit/" . $post->id) . '" class="btn btn-warning btn-sm mr-2" title="edit">'
                    . '<i class="fas fa-pencil-alt">'
                    . '</i>'
                    . '</a>'
                    . '<a href="' . base_url("admin/post/remove/" . $post->id) . '" class="btn btn-danger btn-sm" data-type="confirm" title="remove">'
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
