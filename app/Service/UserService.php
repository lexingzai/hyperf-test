<?php
/**
 * Created by PhpStorm.
 * User: lele
 * Date: 20-3-17
 * Time: 下午4:39
 */

namespace App\Service;


use App\Model\User;

class UserService
{
    public function info($id)
    {
        $res = User::findFromCache($id);
        return $res;
    }

    public function create($data)
    {
        $res = User::query()->create($data);
        return $res;
    }

    public function update($data)
    {
        $res = User::query()->update($data);
        return $res;
    }

    public function delete($id)
    {
        $res = User::destroy($id);
        return $res;
    }

    public function userList()
    {
        $res = User::query()->paginate();
        return $res;
    }
}