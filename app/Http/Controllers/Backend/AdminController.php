<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repository\AdminRepository;
use App\Repository\AdminRoleRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public $adminRepository;
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $admins = $this->adminRepository->searchWithPagination(20, $keyword);
        }else{
            $admins = $this->adminRepository->paginate(20);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $admins
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $admin = $this->adminRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $admin
        ]);
    }

    /**
     * Store data into database
     */
    public function store(Request $request)
    {
        $formData = $request->except(['image']);
        $validator = \Validator::make($formData, [
            'first_name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'admin_role_id' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $admin = $this->adminRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Admin has been created successfully',
                'data'    => $admin
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
            'first_name' => 'required',
            'email' => 'required|unique:users,email,'.$formData['id'],
            'admin_role_id' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $admin = $this->adminRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'Admin has been updated successfully',
                'data'    => $admin
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $admin = $this->adminRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'Admin has been deleted successfully',
                'data'    => $admin
            ]
        );
    }

    /**
     * Get dependency data
     */
    public function dependency()
    {
        $adminRoleRepo = new AdminRoleRepository();
        $data['roles'] = $adminRoleRepo->all();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data Fetched',
                'data'    => $data
            ]
        );
    }
}
