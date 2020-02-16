<?php

namespace App\Repository;

use App\Models\Country;

class CountryRepository implements RepoInterface
{
    public function all()
    {
        $countries = Country::all();
        return $countries;
    }

    public function paginate($perPage = 20)
    {
        $countries = Country::paginate($perPage);
        return $countries;
    }

    public function searchWithPagination($perPage = 20, $keyword)
    {
        $countries = Country::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('code', 'LIKE', '%' . $keyword . '%')
            ->orWhere('phone_code', 'LIKE', '%' . $keyword . '%')
            ->paginate($perPage);
        return $countries;
    }

    public function searchWithoutPagination($keyword)
    {
        $countries = Country::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('code', 'LIKE', '%' . $keyword . '%')
            ->orWhere('phone_code', 'LIKE', '%' . $keyword . '%')
            ->get();
        return $countries;
    }

    public function findById($id)
    {
        $country = Country::find($id);
        return $country;
    }

    public function findBySlug($slug)
    {
        $country = Country::where('id', $slug)->first();
        return $country;
    }

    public function store(array $data)
    {
        $country = Country::create($data);
        return $country;
    }

    public function update($id, array $data)
    {
        $country = Country::find($id)->update($data);
        return $country;
    }

    public function delete($id)
    {
        $country = Country::find($id)->delete();
        return $country;
    }
}
