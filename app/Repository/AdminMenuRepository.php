<?php

namespace App\Repository;

use App\Models\AdminMenu;

class AdminMenuRepository implements RepoInterface
{
    public function all()
    {
        $menus = AdminMenu::all();
        return $menus;
    }

    public function paginate($perPage = 20)
    {
        // TODO: Implement paginate() method.
    }

    public function searchWithPagination($perPage = 20, $keyword)
    {
        // TODO: Implement searchWithPagination() method.
    }

    public function searchWithoutPagination($keyword)
    {
        // TODO: Implement searchWithoutPagination() method.
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function findBySlug($slug)
    {
        // TODO: Implement findBySlug() method.
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
