<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repository\CountryRepository;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public $countryRepository;
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $countries = $this->countryRepository->searchWithPagination(20, $keyword);
        }else{
            $countries = $this->countryRepository->paginate(20);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $countries
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $country = $this->countryRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $country
        ]);
    }

    /**
     * Store data into database
     */
    public function store(Request $request)
    {
        $formData = $request->except(['image']);
        $validator = \Validator::make($formData, [
            'name' => 'required|unique:countries',
            'code' => 'required|unique:countries',
            'phone_code' => 'required|unique:countries',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $country = $this->countryRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Country has been created successfully',
                'data'    => $country
            ]
        );
    }

    /**
     * Update data into database
     */
    public function update(Request $request)
    {
        $formData = $request->all();
        $validator = \Validator::make($formData, [
            'name' => 'required|unique:countries,name,'.$formData['id'],
            'code' => 'required|unique:countries,code,'.$formData['id'],
            'phone_code' => 'required|unique:countries,phone_code,'.$formData['id'],
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $country = $this->countryRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Country has been updated successfully',
                'data'    => $country
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $country = $this->countryRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Country has been deleted successfully',
                'data'    => $country
            ]
        );
    }
}
