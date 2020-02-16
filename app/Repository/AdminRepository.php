<?php

namespace App\Repository;

use App\Models\Admin;
use App\Models\User;
use Hash;

class AdminRepository implements RepoInterface
{
    public function all()
    {
        $users = User::with(['admin'])->get();
        return $users;
    }

    public function paginate($perPage = 20)
    {
        $users = User::with(['admin'])->where('is_admin', 1)->paginate($perPage);
        return $users;
    }

    public function searchWithPagination($perPage = 20, $keyword)
    {
        $users = User::where('first_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->with(['admin'])
            ->paginate($perPage);
        return $users;
    }

    public function searchWithoutPagination($keyword)
    {
        $users = User::where('first_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->with(['admin'])
            ->get();
        return $users;
    }

    public function findById($id)
    {
        $user = User::with(['admin'])->find($id);
        return $user;
    }

    public function findBySlug($slug)
    {
        $user = User::with(['admin'])->where('id', $slug)->first();
        return $user;
    }

    public function store(array $data)
    {
        $data['is_admin'] = 1;
        $data['password'] = Hash::make($data['password']);
        // create user
        $user = User::create($data);
        // create admin with permission & admin will get access of menus of that role
        $admin = Admin::create([
            'user_id' => $user->id,
            'admin_role_id' => $data['admin_role_id']
        ]);
        return $user;
    }

    public function update($id, array $data)
    {
        $user = User::find($id)->update($data);
        $admin = Admin::find($id)->update(['admin_role_id' => $data['admin_role_id']]);
        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id)->delete();
        return $user;
    }
}
