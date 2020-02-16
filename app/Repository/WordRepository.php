<?php

namespace App\Repository;

use App\Helpers\StringHelper;
use App\Models\Translation;
use App\Models\Word;

class WordRepository implements RepoInterface
{
    /**
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     * Return All data
     */
    public function all()
    {
        $words = Word::with(['chapter'])->get();
        return $words;
    }

    /**
     * @param int $perPage
     * @return mixed
     * Return data with pagination
     */
    public function paginate($perPage = 20)
    {
        $words = Word::with(['chapter', 'translations'])->paginate($perPage);
        return $words;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data with pagination
     */
    public function searchWithPagination($perPage = 20, $keyword)
    {
        $words = Word::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('chapter', function($query) use($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->with(['chapter', 'translations'])
            ->paginate($perPage);
        return $words;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data without pagination
     */
    public function searchWithoutPagination($keyword)
    {
        $words = Word::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('chapter', function($query) use($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->with(['chapter', 'translations'])
            ->get();
        return $words;
    }

    /**
     * @param $id
     * @return mixed
     * Search data with id
     */
    public function findById($id)
    {
        $word = Word::with(['chapter', 'translations'])->find($id);
        return $word;
    }

    /**
     * @param $slug
     * @return mixed
     * Search data with slug
     */
    public function findBySlug($slug)
    {
        $word = Word::with(['chapter', 'translations'])->where('slug', $slug);
        return $word;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     * Store data into database which passed from controller
     */
    public function store(array $data)
    {
        $word = Word::create($data);
        foreach ($data['language_id'] as $key => $value) {
            $translationData = array(
                'language_id' => $value,
                'value_1' => $data['value_1'][$key],
                'value_2' => $data['value_2'][$key],
                'model_name' => 'Word',
                'model_id' => $word->id,
            );
            Translation::create($translationData);
        }
        return $word;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * Update data into database which passed from controller
     */
    public function update($id, array $data)
    {
        $word = Word::find($id)->update($data);
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
                'model_name' => 'Word',
                'model_id' => $data['id'],
            );
            Translation::create($translationData);
        }
        return $word;
    }

    /**
     * @param $id
     * @return mixed
     * Delete data from database through id
     */
    public function delete($id)
    {
        $word = Word::find($id)->delete();
        return $word;
    }

    /**
     * @param $title
     * @return string|string[]|null
     * @throws \Exception
     * Generate unique slug for a row using helper
     */
    public function generateSlug($name)
    {
        return StringHelper::createSlug($name, 'Word', 'slug');
    }
}
