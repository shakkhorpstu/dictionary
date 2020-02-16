<?php

namespace App\Repository;

use App\Helpers\StringHelper;
use App\Models\Page;
use App\Models\Translation;

class PageRepository implements RepoInterface
{
    /**
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     * Return All data
     */
    public function all()
    {
        $pages = Page::all();
        return $pages;
    }

    /**
     * @param int $perPage
     * @return mixed
     * Return data with pagination
     */
    public function paginate($perPage = 20)
    {
        $pages = Page::with(['translations'])->paginate($perPage);
        return $pages;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data with pagination
     */
    public function searchWithPagination($perPage = 20, $keyword)
    {
        $pages = Page::where('title', 'LIKE', '%' . $keyword . '%')
            ->with(['translations'])
            ->paginate($perPage);
        return $pages;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data without pagination
     */
    public function searchWithoutPagination($keyword)
    {
        $pages = Page::where('title', 'LIKE', '%' . $keyword . '%')
            ->with(['translations'])
            ->get();
        return $pages;
    }

    /**
     * @param $id
     * @return mixed
     * Search data with id
     */
    public function findById($id)
    {
        $page = Page::with(['translations'])->find($id);
        return $page;
    }

    /**
     * @param $slug
     * @return mixed
     * Search data with slug
     */
    public function findBySlug($slug)
    {
        $page = Page::with(['translations'])->where('slug', $slug);
        return $page;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     * Store data into database which passed from controller
     */
    public function store(array $data)
    {
        $page = Page::create($data);
        foreach ($data['language_id'] as $key => $value) {
            $translationData = array(
                'language_id' => $value,
                'value_1' => $data['value_1'][$key],
                'value_2' => $data['value_2'][$key],
                'model_name' => 'Page',
                'model_id' => $page->id,
            );
            Translation::create($translationData);
        }
        return $page;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * Update data into database which passed from controller
     */
    public function update($id, array $data)
    {
        $page = Page::find($id)->update($data);
        foreach ($data['translations'] as $key => $value) {
            $translationData = array(
                'language_id' => $value['language_id'],
                'value_1' => $value['value_1'],
                'value_2' => $value['value_2']
            );
            Translation::find($value['id'])->update($translationData);
        }
        // Insert new language data
        foreach ($data['newLanguages']['language_id'] as $key => $value) {
            $translationData = array(
                'language_id' => $value,
                'value_1' => $data['newLanguages']['value_1'][$key],
                'value_2' => $data['newLanguages']['value_2'][$key],
                'model_name' => 'Page',
                'model_id' => $data['id'],
            );
            Translation::create($translationData);
        }
        return $page;
    }

    /**
     * @param $id
     * @return mixed
     * Delete data from database through id
     */
    public function delete($id)
    {
        $page = Page::find($id)->delete();
        return $page;
    }

    /**
     * @param $title
     * @return string|string[]|null
     * @throws \Exception
     * Generate unique slug for a row using helper
     */
    public function generateSlug($title)
    {
        return StringHelper::createSlug($title, 'Page', 'slug');
    }
}
