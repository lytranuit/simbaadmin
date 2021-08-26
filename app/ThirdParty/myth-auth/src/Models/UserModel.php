<?php

namespace Myth\Auth\Models;

use CodeIgniter\Model;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Entities\User;

class UserModel extends Model
{
    protected $table = 'pet_auth_users';
    protected $primaryKey = 'id';

    protected $returnType = User::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
        'name', 'address', 'description', 'phone', 'image_id'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'email'         => 'valid_email|is_unique[users.email,id,{id}]',
        'username'      => 'required|alpha_numeric_punct|min_length[3]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $afterInsert = ['addToGroup'];

    /**
     * The id of a group to assign.
     * Set internally by withGroup.
     * @var int
     */
    protected $assignGroup;

    /**
     * Logs a password reset attempt for posterity sake.
     *
     * @param string      $email
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logResetAttempt(string $email, string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('pet_auth_reset_attempts')->insert([
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Logs an activation attempt for posterity sake.
     *
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logActivationAttempt(string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('pet_auth_activation_attempts')->insert([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Sets the group to assign any users created.
     *
     * @param string $groupName
     *
     * @return $this
     */
    public function withGroup(string $groupName)
    {
        $group = $this->db->table('pet_auth_groups')->where('name', $groupName)->get()->getFirstRow();

        $this->assignGroup = $group->id;

        return $this;
    }

    /**
     * Clears the group to assign to newly created users.
     *
     * @return $this
     */
    public function clearGroup()
    {
        $this->assignGroup = null;

        return $this;
    }

    /**
     * If a default role is assigned in Config\Auth, will
     * add this user to that group. Will do nothing
     * if the group cannot be found.
     *
     * @param $data
     *
     * @return mixed
     */
    protected function addToGroup($data)
    {
        if (is_numeric($this->assignGroup)) {
            $groupModel = model(GroupModel::class);
            $groupModel->addUserToGroup($data['id'], $this->assignGroup);
        }

        return $data;
    }
    public function relation(&$data, $relation = array())
    {
        $type = gettype($data);

        if ($type == "array" && !isset($data['id'])) {
            foreach ($data as &$row) {
                if (gettype($row) == "object") {
                    if (in_array("image", $relation)) {
                        $image_id = $row->image_id;
                        $builder = $this->db->table('cf_file');
                        $row->image = $builder->where('id', $image_id)->limit(1)->get()->getFirstRow();
                    }
                    if (in_array("groups", $relation)) {
                        $user_id = $row->id;
                        $groups = model(GroupModel::class)->getGroupsForUser($user_id);
                        $row->groups = $groups;
                        $row->groups_string = array_map(function ($item) {
                            return $item['description'];
                        }, $groups);
                    }
                } else {
                    if (in_array("image", $relation)) {
                        $image_id = $row['image_id'];
                        $builder = $this->db->table('cf_file');
                        $row['image'] = $builder->where('id', $image_id)->limit(1)->get()->getFirstRow("array");
                    }

                    if (in_array("groups", $relation)) {
                        $user_id = $data['id'];
                        $groups = model(GroupModel::class)->getGroupsForUser($user_id);
                        $data['groups'] = $groups;
                        $row['groups_string'] = array_map(function ($item) {
                            return $item['description'];
                        }, $groups);
                    }
                }
            }
        } elseif ($type == "array" && isset($data['id'])) {
            if (in_array("image", $relation)) {
                $image_id = $data['image_id'];
                $builder = $this->db->table('cf_file');
                $data['image'] = $builder->where('id', $image_id)->limit(1)->get()->getFirstRow('array');
            }
            if (in_array("groups", $relation)) {
                $user_id = $data['id'];
                $groups = model(GroupModel::class)->getGroupsForUser($user_id);
                $data['groups'] = $groups;

                $data['groups_string'] = array_map(function ($item) {
                    return $item['description'];
                }, $groups);
            }
        } else {
            if (in_array("image", $relation)) {
                $image_id = $data->image_id;
                $builder = $this->db->table('cf_file');
                $data->image = $builder->where('id', $image_id)->limit(1)->get()->getFirstRow();
            }
            if (in_array("groups", $relation)) {
                $user_id = $data->id;
                $groups = model(GroupModel::class)->getGroupsForUser($user_id);
                $data->groups = $groups;
                $data->groups_string = array_map(function ($item) {
                    return $item['description'];
                }, $groups);
            }
        }
        return $data;
    }
    public function setAssignGroup($group_id)
    {
        $this->assignGroup = $group_id;
    }
}
