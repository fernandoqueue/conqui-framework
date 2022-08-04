<?php

namespace App\Service;

use App\Model\User;
use Conqui\Authentication;
class UserServiceProvider 
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function allUsers()
    {
        return  $this->userModel->all()->getAll();
    }

    public function userById($id)
    {
        return $this->userModel->id($id)->get();
    }

    public function usersWhere($parameters)
    {
        $users = $this->userModel->where($parameters)->getAll();
        return $users;
    }

    public function create($data)
    {   
        $data['password'] = is_null($data['password']) ? null : password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->userModel->create($data)->get();
    }

    public function loginUser($request)
    {
        return Authentication::authenticate($request['email'],$request['password']);        
    }

    public function getPermissions($id)
    {
        return $this->userModel->getPermissions($id)->getAll();
    }
}