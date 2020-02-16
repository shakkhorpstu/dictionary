<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repository\ChapterRepository;
use App\Repository\LanguageRepository;
use App\Repository\WordRepository;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public $wordRepository;
    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $words = $this->wordRepository->searchWithPagination(20, $keyword);
        } else {
            $words = $this->wordRepository->paginate(20);
        }
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $words
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $word = $this->wordRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $word
        ]);
    }

    /**
     * Store data into database
     */
    public function store(Request $request)
    {
        $formData = $request->all();
        $validator = \Validator::make($formData, [
            'name' => 'required',
            'chapter_id' => 'required',
            'slug' => 'required|unique:words',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $word = $this->wordRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Word has been created successfully',
                'data'    => $word
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
            'chapter_id' => 'required',
            'slug' => 'required|unique:words,slug,'.$formData['id'],
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $word = $this->wordRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Word has been updated successfully',
                'data'    => $word
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $word = $this->wordRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Word has been deleted successfully',
                'data'    => $word
            ]
        );
    }

    /**
     * Get dependency data
     */
    public function dependency()
    {
        $chapterRepository = new ChapterRepository();
        $languageRepo = new LanguageRepository();
        $data['languages'] = $languageRepo->all();

        $data['chapters'] = $chapterRepository->all();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data Fetched',
                'data'    => $data
            ]
        );
    }
}
