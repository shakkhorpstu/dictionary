<?php

namespace App\Repository;

use App\Helpers\StringHelper;
use App\Models\Sentence;
use App\Models\Translation;

class SentenceRepository implements RepoInterface
{
    /**
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     * Return All data
     */
    public function all()
    {
        $sentences = Sentence::with(['chapter'])->get();
        return $sentences;
    }

    /**
     * @param int $perPage
     * @return mixed
     * Return data with pagination
     */
    public function paginate($perPage = 20)
    {
        $sentences = Sentence::with(['chapter', 'translations'])->paginate($perPage);
        return $sentences;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data with pagination
     */
    public function searchWithPagination($perPage = 20, $keyword)
    {
        $sentences = Sentence::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('chapter', function($query) use($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->with(['chapter', 'translations'])
            ->paginate($perPage);
        return $sentences;
    }

    /**
     * @param int $perPage
     * @param $keyword
     * @return mixed
     * Search data without pagination
     */
    public function searchWithoutPagination($keyword)
    {
        $sentences = Sentence::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('chapter', function($query) use($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->with(['chapter', 'translations'])
            ->get();
        return $sentences;
    }

    /**
     * @param $id
     * @return mixed
     * Search data with id
     */
    public function findById($id)
    {
        $sentence = Sentence::with(['chapter', 'translations'])->find($id);
        return $sentence;
    }

    /**
     * @param $slug
     * @return mixed
     * Search data with slug
     */
    public function findBySlug($slug)
    {
        $sentence = Sentence::with(['chapter', 'translations'])->where('slug', $slug);
        return $sentence;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     * Store data into database which passed from controller
     */
    public function store(array $data)
    {
        $sentence = Sentence::create($data);
        foreach ($data['language_id'] as $key => $value) {
            $translationData = array(
                'language_id' => $value,
                'value_1' => $data['value_1'][$key],
                'value_2' => $data['value_2'][$key],
                'model_name' => 'Sentence',
                'model_id' => $sentence->id,
            );
            Translation::create($translationData);
        }
        return $sentence;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * Update data into database which passed from controller
     */
    public function update($id, array $data)
    {
        $sentence = Sentence::find($id)->update($data);
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
                'model_name' => 'Sentence',
                'model_id' => $data['id'],
            );
            Translation::create($translationData);
        }
        return $sentence;
    }

    /**
     * @param $id
     * @return mixed
     * Delete data from database through id
     */
    public function delete($id)
    {
        $sentence = Sentence::find($id)->delete();
        return $sentence;
    }

    /**
     * @param $title
     * @return string|string[]|null
     * @throws \Exception
     * Generate unique slug for a row using helper
     */
    public function generateSlug($name)
    {
        return StringHelper::createSlug($name, 'Sentence', 'slug');
    }
}
