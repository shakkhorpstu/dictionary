<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Sentence;
use App\Models\User;
use App\Models\Word;
use Illuminate\Http\Request;
use Auth;
use Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $data['chapters'] = Chapter::count();
        $data['words'] = Word::count();
        $data['sentences'] = Sentence::count();
        $data['users'] = User::where('is_admin', 0)->count();

        return response()->json([
           'success' => true,
           'messgae' => 'Data Fetched',
           'data'    => $data
        ]);
    }

    public function changePassword(Request $request)
    {
        $formData = $request->all();
        $validator = \Validator::make($formData, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->getMessageBag()->first()
                ]
            );
        };

        $admin = Auth::user();

        if(Hash::check($request->old_password, $admin->password)){
            $admin->password = Hash::make($request->password);
            $admin->save();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Password changed successfully',
                    'data'    => $admin
                ]
            );
        }
        else{
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Old password does not match',
                    'data'    => $admin
                ]
            );
        }
    }
}
