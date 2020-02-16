<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Repository\LanguageRepository;
use App\Repository\PageRepository;
use Illuminate\Http\Request;
use Image;

class PageController extends Controller
{
    public $pageRepository;
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $pages = $this->pageRepository->searchWithPagination(20, $keyword);
        }else{
            $pages = $this->pageRepository->paginate(20);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $pages
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $page = $this->pageRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $page
        ]);
    }

    /**
     * Store data into database
     */
    public function store(Request $request)
    {
        $formData = $request->except(['image']);
        $validator = \Validator::make($formData, [
            'title' => 'required',
            'body' => 'required',
            'slug' => 'required|unique:pages',
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
            $fileName = 'pages/'.time().$image->getClientOriginalName();
            $originalImage = Image::make($image);
            $originalImage->save($fileName);
            $formData['image'] = env('APP_URL').$fileName;
        }
        $formData['language_id'] = json_decode($request->language_id);
        $formData['value_1'] = json_decode($request->value_1);
        $formData['value_2'] = json_decode($request->value_2);
        $page = $this->pageRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Page has been created successfully',
                'data'    => $page
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
            'title' => 'required',
            'body' => 'required',
            'slug' => 'required|unique:pages,slug,'.$formData['id'],
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $page = $this->pageRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Page has been updated successfully',
                'data'    => $page
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $page = $this->pageRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Page has been deleted successfully',
                'data'    => $page
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
            $fileName = 'pages/'.time().$image->getClientOriginalName();
            $originalImage = Image::make($image);
            $originalImage->save($fileName);
            $imageUrl = env('APP_DOMAIN').$fileName;
        }
        Page::find($id)->update(['featured_image' => $imageUrl]);
    }
}
