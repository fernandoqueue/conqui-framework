<?php

namespace App\Model;

use App\Model\BaseModel;

class User extends BaseModel
{ 
    public $table = 'users';

    public function getPermissions($id)
    {
        $query = "SELECT roles.title as role, permissions.*
        FROM   users
        INNER JOIN role_user ON users.id = role_user.user_id
        LEFT JOIN roles ON roles.id = role_user.role_id
        INNER JOIN permission_role ON roles.id = permission_role.role_id
        LEFT JOIN permissions ON permissions.id = permission_role.permission_id
        WHERE  users.id = :id";

        return $this->rawQuery($query, ['id' => $id]);
    }

}