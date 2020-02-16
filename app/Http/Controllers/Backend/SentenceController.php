<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repository\ChapterRepository;
use App\Repository\LanguageRepository;
use App\Repository\SentenceRepository;
use Illuminate\Http\Request;

class SentenceController extends Controller
{
    public $sentenceRepository;
    public function __construct(SentenceRepository $sentenceRepository)
    {
        $this->sentenceRepository = $sentenceRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $sentences = $this->sentenceRepository->searchWithPagination(20, $keyword);
        } else {
            $sentences = $this->sentenceRepository->paginate(20);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $sentences
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $sentence = $this->sentenceRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $sentence
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

        $sentence = $this->sentenceRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Sentence has been created successfully',
                'data'    => $sentence
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

        $sentence = $this->sentenceRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Sentence has been updated successfully',
                'data'    => $sentence
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $sentence = $this->sentenceRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Sentence has been deleted successfully',
                'data'    => $sentence
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
