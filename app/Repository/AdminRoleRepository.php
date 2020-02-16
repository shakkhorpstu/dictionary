<?php

namespace App\Repository;

use App\Models\AdminPermission;
use App\Models\AdminRole;

class AdminRoleRepository implements RepoInterface
{
    public function all()
    {
        $roles = AdminRole::all();
        return $roles;
    }

    public function paginate($perPage = 20)
    {
        $roles = AdminRole::paginate($perPage);
        return $roles;
    }

    public function searchWithPagination($perPage = 20, $keyword)
    {
        $roles = User::where('title', 'LIKE', '%' . $keyword . '%')
            ->paginate($perPage);
        return $roles;
    }

    public function searchWithoutPagination($keyword)
    {
        $roles = User::where('title', 'LIKE', '%' . $keyword . '%')
            ->get();
        return $roles;
    }

    public function findById($id)
    {
        $role = AdminRole::find($id);
        return $role;
    }

    public function findBySlug($slug)
    {
        $role = AdminRole::where('id', $slug)->first();
        return $role;
    }

    public function store(array $data)
    {
        // create role
        $role = AdminRole::create($data);
        // create role with menu permission & admin will get access of menus of this role
        foreach ($data['admin_permissions'] as $key => $value) {
            $adminPermissionData = array(
                'admin_role_id' => $role->id,
                'admin_menu_id' => $value
            );
            AdminPermission::create($adminPermissionData);
        }
        return $role;
    }

    public function update($id, array $data)
    {
        $role = AdminRole::find($id)->update($data);
        // delete all the permissions & insert new data
        AdminPermission::where('admin_role_id', $id)->delete();

        foreach ($data['admin_permissions'] as $key => $value) {
            $adminPermissionData = array(
                'admin_role_id' => $id,
                'admin_menu_id' => $value
            );
            AdminPermission::create($adminPermissionData);
        }
        return $role;
    }

    public function delete($id)
    {
        $role = AdminRole::find($id)->delete();
        return $role;
    }
}
