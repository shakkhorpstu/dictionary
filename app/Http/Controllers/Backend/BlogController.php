<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repository\BlogRepository;
use Illuminate\Http\Request;
use Image;

class BlogController extends Controller
{
    public $blogRepository;
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $blogs = $this->blogRepository->searchWithPagination(20, $keyword);
        } else {
            $blogs = $this->blogRepository->paginate(20);
        }
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $blogs
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $blog = $this->blogRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $blog
        ]);
    }

    /**
     * Store data into database
     */
    public function store(Request $request)
    {
        $formData = $request->all();
        $validator = \Validator::make($formData, [
            'title' => 'required',
            'body' => 'required',
            'slug' => 'required|unique:blogs',
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
            $fileName = 'blogs/'.time().$image->getClientOriginalName();
            $originalImage = Image::make($image);
            $originalImage->save($fileName);
            $formData['featured_image'] = env('APP_URL').$fileName;
        }

        $blog = $this->blogRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Blog has been created successfully',
                'data'    => $blog
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
            'slug' => 'required|unique:blogs,slug,'.$formData['id'],
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
            $fileName = 'blogs/'.time().$image->getClientOriginalName();
            $originalImage = Image::make($image);
            $originalImage->save($fileName);
            $formData['image'] = env('APP_DOMAIN').$fileName;
        }

        $blog = $this->blogRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Blog has been updated successfully',
                'data'    => $blog
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $blog = $this->blogRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Blog has been deleted successfully',
                'data'    => $blog
            ]
        );
    }
}
