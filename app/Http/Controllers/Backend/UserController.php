<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repository\CountryRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Return table all data with response to corresponding component
     */
    public function index()
    {
        if(request()->get('searchKeyword')) {
            $keyword = request()->get('searchKeyword');
            $users = $this->userRepository->searchWithPagination(20, $keyword);
        }else{
            $users = $this->userRepository->paginate(20);
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $users
        ]);
    }

    /**
     * Return table single data with response to corresponding component
     */
    public function show($id)
    {
        $user = $this->userRepository->findById($id);
        return response()->json([
            'success' => true,
            'message' => 'Fetched data',
            'data'    => $user
        ]);
    }

    /**
     * Store data into database
     */
    public function store(Request $request)
    {
        $formData = $request->all();
        $validator = \Validator::make($formData, [
            'first_name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $user = $this->userRepository->store($formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'User has been created successfully',
                'data'    => $user
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
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $user = $this->userRepository->update($formData['id'], $formData);
        return response()->json(
            [
                'success' => true,
                'message' => 'User has been updated successfully',
                'data'    => $user
            ]
        );
    }

    /**
     * Delete data from database
     */
    public function destroy($id)
    {
        $user = $this->userRepository->delete($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'User has been deleted successfully',
                'data'    => $user
            ]
        );
    }

    /**
     * Get dependency data
     */
    public function dependency()
    {
        $countryRepo = new CountryRepository();
        $data['countries'] = $countryRepo->all();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data Fetched',
                'data'    => $data
            ]
        );
    }
}
