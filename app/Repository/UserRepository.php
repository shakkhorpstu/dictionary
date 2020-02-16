<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserProfile;
use Hash;

class UserRepository implements RepoInterface
{
    public function all()
    {
        $users = User::with(['profile', 'country'])->where('is_admin', 0)->get();
        return $users;
    }

    public function paginate($perPage = 20)
    {
        $users = User::with(['profile', 'country'])->where('is_admin', 0)->paginate($perPage);
        return $users;
    }

    public function searchWithPagination($perPage = 20, $keyword)
    {
        $users = User::where('first_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->orWhere('phone_no', 'LIKE', '%' . $keyword . '%')
            ->orWhere('city', 'LIKE', '%' . $keyword . '%')
            ->orWhere('zip_code', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('country', function($query) use($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')->orWhere('code', 'LIKE', '%' . $keyword . '%');
            })
            ->where('is_admin', 0)
            ->with(['profile', 'country'])
            ->paginate($perPage);
        return $users;
    }

    public function searchWithoutPagination($keyword)
    {
        $users = User::where('first_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->orWhere('phone_no', 'LIKE', '%' . $keyword . '%')
            ->orWhere('city', 'LIKE', '%' . $keyword . '%')
            ->orWhere('zip_code', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('country', function($query) use($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')->orWhere('code', 'LIKE', '%' . $keyword . '%');
            })
            ->where('is_admin', 0)
            ->with(['profile', 'country'])
            ->get();
        return $users;
    }

    public function findById($id)
    {
        $user = User::with(['profile', 'country'])->find($id);
        return $user;
    }

    public function findBySlug($slug)
    {
        $user = User::with(['profile', 'country'])->where('id', $slug)->first();
        return $user;
    }

    public function store(array $data)
    {
        $data['is_admin'] = 0;
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $data['user_id'] = $user->id;
        UserProfile::create($data);
        return $user;
    }

    public function update($id, array $data)
    {
        $user = User::find($id)->update($data);
        $profileData = array(
            'facebook_link' => $data['facebook_link'],
            'github_link' => $data['github_link'],
            'website' => $data['website'],
        );
        UserProfile::where('user_id', $id)->update($profileData);
        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id)->delete();
        return $user;
    }
}
