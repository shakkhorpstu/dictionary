<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Repository\ChapterRepository;
use App\Repository\LanguageRepository;
use Illuminate\Http\Request;
use Image;

class ChapterController extends Controller
{
    public $chapterRepository;
    public function __construct(ChapterRepository $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $chapters = $this->chapterRepository->searchWithPagination(20, $keyword);
        }else{
            $chapters = $this->chapterRepository->paginate(20);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $chapters
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $chapter = $this->chapterRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $chapter
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
            'slug' => 'required|unique:chapters',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        if ($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = 'chapters/'.time().$image->getClientOriginalName();
            $originalImage = Image::make($image);
            $originalImage->save($fileName);
            $formData['image'] = env('APP_DOMAIN').$fileName;
        }
        $formData['language_id'] = json_decode($request->language_id);
        $formData['value_1'] = json_decode($request->value_1);
        $formData['value_2'] = json_decode($request->value_2);
        $chapter = $this->chapterRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Chapter has been created successfully',
                'data'    => $chapter
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
            'slug' => 'required|unique:chapters,slug,'.$formData['id'],
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $chapter = $this->chapterRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Chapter has been updated successfully',
                'data'    => $chapter
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $chapter = $this->chapterRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Chapter has been deleted successfully',
                'data'    => $chapter
            ]
        );
    }

    /**
     * Get dependency data
     */
    public function dependency()
    {
        $languageRepo = new LanguageRepository();
        $data['languages'] = $languageRepo->all();
        $data['chapters'] = $this->chapterRepository->all();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data Fetched',
                'data'    => $data
            ]
        );
    }

    public function updateImage(Request $request, $id)
    {
        if ($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = 'chapters/'.time().$image->getClientOriginalName();
            $originalImage = Image::make($image);
            $originalImage->save($fileName);
            $imageUrl = env('APP_DOMAIN').$fileName;
        }
        Chapter::find($id)->update(['image' => $imageUrl]);
    }
}
