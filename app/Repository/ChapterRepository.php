<?php

namespace App\Repository;

use App\Models\Chapter;
use App\Models\Translation;

class ChapterRepository implements RepoInterface
{
    /**
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     * Return All data
     */
    public function all()
    {
        $chapters = Chapter::with(['parentChapter'])->get();
        return $chapters;
    }

    /**
     * @param int $perPage
     * @return mixed
     * Return data with pagination
     */
    public function paginate($perPage = 20)
    {
        $chapters = Chapter::with(['parentChapter', 'translations'])->paginate($perPage);
        return $chapters;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data with pagination
     */
    public function searchWithPagination($perPage = 20, $keyword)
    {
        $chapters = Chapter::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('keywords', 'LIKE', '%' . $keyword . '%')
            ->with(['parentChapter', 'translations'])
            ->paginate($perPage);
        return $chapters;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data without pagination
     */
    public function searchWithoutPagination($keyword)
    {
        $chapters = Chapter::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('keywords', 'LIKE', '%' . $keyword . '%')
            ->with(['parentChapter', 'translations'])
            ->get();
        return $chapters;
    }

    /**
     * @param $id
     * @return mixed
     * Search data with id
     */
    public function findById($id)
    {
        $chapter = Chapter::with(['parentChapter', 'translations'])->find($id);
        return $chapter;
    }

    /**
     * @param $slug
     * @return mixed
     * Search data with slug
     */
    public function findBySlug($slug)
    {
        $chapter = Chapter::with(['parentChapter', 'translations'])->where('id', $slug)->first();
        return $chapter;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     * Store data into database which passed from controller
     */
    public function store(array $data)
    {
        $chapter = Chapter::create($data);
        if($data['language_id']) {
            foreach ($data['language_id'] as $key => $value) {
                $translationData = array(
                    'language_id' => $value,
                    'value_1' => $data['value_1'][$key],
                    'value_2' => $data['value_2'][$key],
                    'model_name' => 'Chapter',
                    'model_id' => $chapter->id,
                );
                Translation::create($translationData);
            }
        }
        return $chapter;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * Update data into database which passed from controller
     */
    public function update($id, array $data)
    {
        $chapter = Chapter::find($id)->update($data);
        // Update previous languages
        foreach ($data['translations'] as $key => $value) {
            $translationData = array(
                'language_id' => $value['language_id'],
                'value_1' => $value['value_1'],
                'value_2' => $value['value_2']
            );
            Translation::find($value['id'])->update($translationData);
        }
        // Insert new language data
        if($data['newLanguages']['language_id']) {
            foreach ($data['newLanguages']['language_id'] as $key => $value) {
                $translationData = array(
                    'language_id' => $value,
                    'value_1' => $data['newLanguages']['value_1'][$key],
                    'value_2' => $data['newLanguages']['value_2'][$key],
                    'model_name' => 'Chapter',
                    'model_id' => $data['id'],
                );
                Translation::create($translationData);
            }
        }
        return $chapter;
    }

    /**
     * @param $id
     * @return mixed
     * Delete data from database through id
     */
    public function delete($id)
    {
        $chapter = Chapter::find($id)->delete();
        return $chapter;
    }
}
