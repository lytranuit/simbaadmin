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
                $opt_value = $data['opt_value'][$id];
                $array = array(
                    'opt_value' => $opt_value
                );
                if (isset($data['opt_value_en'][$id])) {
                    $array['opt_value_en'] = $data['opt_value_en'][$id];
                }
                if (isset($data['opt_value_jp'][$id])) {
                    $array['opt_value_jp'] = $data['opt_value_jp'][$id];
                }
                $SettingsModel->update($id, $array);
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            $SettingsModel = model("SettingsModel");
            $this->data['commons']  = $SettingsModel->get_options_groups("common");
            $this->data['system_phone']  = $SettingsModel->get_options_groups("system_phone");
            $this->data['system_popup'] = $SettingsModel->get_options_groups("system_popup");
            $this->data['time'] = $SettingsModel->get_options_groups("time");




            $this->data['system_email'] = $SettingsModel->get_options_groups("system_email");
            $this->data['system_email_pet'] = $SettingsModel->get_options_groups("system_email_pet");
            $this->data['system_email_foodzone'] = $SettingsModel->get_options_groups("system_email_foodzone");
            $this->data['system_fresh_email'] = $SettingsModel->get_options_groups("system_email_pet");
            $this->data['system_simba_email'] = $SettingsModel->get_options_groups("system_simba_email");
            $this->data['system_simba_order_email'] = $SettingsModel->get_options_groups("system_simba_order_email");
            $this->data['system_simba_report_email'] = $SettingsModel->get_options_groups("system_simba_report_email");
            $this->data['system_simba_quote_email'] = $SettingsModel->get_options_groups("system_simba_quote_email");
            $this->data['system_totrinh_email'] = $SettingsModel->get_options_groups("system_totrinh_email");
            $this->data['system_totrinh2_email'] = $SettingsModel->get_options_groups("system_totrinh2_email");
            $this->data['system_tonkho_email'] = $SettingsModel->get_options_groups("system_tonkho_email");
            $this->data['system_gopy'] = $SettingsModel->get_options_groups("system_gopy");

            return view($this->data['content'], $this->data);
        }
    }
}
