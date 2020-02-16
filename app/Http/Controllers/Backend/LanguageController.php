<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repository\LanguageRepository;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public $languageRepository;
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $languages = $this->languageRepository->searchWithPagination(20, $keyword);
        }else{
            $languages = $this->languageRepository->paginate(20);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $languages
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $language = $this->languageRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $language
        ]);
    }

    /**
     * Store data into database
     */
    public function store(Request $request)
    {
        $formData = $request->except(['image']);
        $validator = \Validator::make($formData, [
            'name' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $language = $this->languageRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Language has been created successfully',
                'data'    => $language
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
            'name' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $language = $this->languageRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Language has been updated successfully',
                'data'    => $language
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $language = $this->languageRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Language has been deleted successfully',
                'data'    => $language
            ]
        );
    }
}
