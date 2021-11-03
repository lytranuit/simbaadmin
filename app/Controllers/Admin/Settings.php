<?php

namespace App\Controllers\Admin;


class Settings extends BaseController
{
    public function index()
    {
        if (isset($_POST['post'])) {
            $data = $_POST;
            $SettingsModel = model("SettingsModel");
            foreach ($data['id'] as $key => $id) {
                $opt_value = $data['opt_value'][$key];
                $opt_value_en = $data['opt_value_en'][$key];
                $opt_value_jp = $data['opt_value_jp'][$key];
                $SettingsModel->update($id, array('opt_value' => $opt_value, 'opt_value_en' => $opt_value_en, 'opt_value_jp' => $opt_value_jp));
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            $SettingsModel = model("SettingsModel");
            $commons = $SettingsModel->get_options_groups("common");
            // echo "<pre>";
            // print_r($commons);
            // die();
            $this->data['commons'] = $commons;

            return view($this->data['content'], $this->data);
        }
    }
}
