<?php

namespace App\Repository;

use App\Models\Language;

class LanguageRepository implements RepoInterface
{
    public function all()
    {
        $languages = Language::all();
        return $languages;
    }

    public function paginate($perPage = 20)
    {
        $languages = Language::paginate($perPage);
        return $languages;
    }

    public function searchWithPagination($perPage = 20, $keyword)
    {
        $languages = Language::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('code', 'LIKE', '%' . $keyword . '%')
            ->paginate($perPage);
        return $languages;
    }

    public function searchWithoutPagination($keyword)
    {
        $languages = Language::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('code', 'LIKE', '%' . $keyword . '%')
            ->get();
        return $languages;
    }

    public function findById($id)
    {
        $language = Language::find($id);
        return $language;
    }

    public function findBySlug($slug)
    {
        $language = Language::where('id', $slug)->first();
        return $language;
    }

    public function store(array $data)
    {
        $language = Language::create($data);
        return $language;
    }

    public function update($id, array $data)
    {
        $language = Language::find($id)->update($data);
        return $language;
    }

    public function delete($id)
    {
        $language = Language::find($id)->delete();
        return $language;
    }
}
