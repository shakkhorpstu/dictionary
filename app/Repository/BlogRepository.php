<?php

namespace App\Repository;

use App\Helpers\StringHelper;
use App\Models\Translation;
use App\Models\Blog;

class BlogRepository implements RepoInterface
{
    /**
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     * Return All data
     */
    public function all()
    {
        $blogs = Blog::all();
        return $blogs;
    }

    /**
     * @param int $perPage
     * @return mixed
     * Return data with pagination
     */
    public function paginate($perPage = 20)
    {
        $blogs = Blog::paginate($perPage);
        return $blogs;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data with pagination
     */
    public function searchWithPagination($perPage = 20, $keyword)
    {
        $blogs = Blog::where('title', 'LIKE', '%' . $keyword . '%')
            ->paginate($perPage);
        return $blogs;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data without pagination
     */
    public function searchWithoutPagination($keyword)
    {
        $blogs = Blog::where('title', 'LIKE', '%' . $keyword . '%')
            ->get();
        return $blogs;
    }

    /**
     * @param $id
     * @return mixed
     * Search data with id
     */
    public function findById($id)
    {
        $blog = Blog::find($id);
        return $blog;
    }

    /**
     * @param $slug
     * @return mixed
     * Search data with slug
     */
    public function findBySlug($slug)
    {
        $blog = Blog::where('slug', $slug);
        return $blog;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     * Store data into database which passed from controller
     */
    public function store(array $data)
    {
        $blog = Blog::create($data);
        return $blog;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * Update data into database which passed from controller
     */
    public function update($id, array $data)
    {
        $blog = Blog::find($id)->update($data);
        return $blog;
    }

    /**
     * @param $id
     * @return mixed
     * Delete data from database through id
     */
    public function delete($id)
    {
        $blog = Blog::find($id)->delete();
        return $blog;
    }

    /**
     * @param $title
     * @return string|string[]|null
     * @throws \Exception
     * Generate unique slug for a row using helper
     */
    public function generateSlug($title)
    {
        return StringHelper::createSlug($title, 'Blog', 'slug');
    }
}
