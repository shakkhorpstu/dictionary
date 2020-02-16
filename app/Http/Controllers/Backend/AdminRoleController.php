<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repository\AdminMenuRepository;
use App\Repository\AdminRoleRepository;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    public $adminRoleRepository;
    public function __construct(AdminRoleRepository $adminRoleRepository)
    {
        $this->adminRoleRepository = $adminRoleRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $adminRoles = $this->adminRoleRepository->searchWithPagination(20, $keyword);
        }else{
            $adminRoles = $this->adminRoleRepository->paginate(20);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $adminRoles
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $adminRole = $this->adminRoleRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $adminRole
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
            'admin_permissions.*' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $adminRole = $this->adminRoleRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Admin Role has been created successfully',
                'data'    => $adminRole
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
            'admin_permissions.*' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $adminRole = $this->adminRoleRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Admin Role has been updated successfully',
                'data'    => $adminRole
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $adminRole = $this->adminRoleRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Admin Role has been deleted successfully',
                'data'    => $adminRole
            ]
        );
    }

    /**
     * Get dependency data
     */
    public function dependency()
    {
        $adminMenuRepo = new AdminMenuRepository();
        $data['menus'] = $adminMenuRepo->all();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data Fetched',
                'data'    => $data
            ]
        );
    }
}
