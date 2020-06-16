<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use \Cloudder;

class ProfilesController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $users = User::all();
        return view('users')->with(['users' => $users]);
    }

    public function edit(User $user) {
        return view('edit')->with(['user' => $user]);
    }

    public function show() {
        return response(['data' => auth()->user(), 'message' => 'success'], 200);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => ['required', 'string', 'regex:/^[A-Za-z][A-Za-z0-9]{4,31}$/', 'max:20', 'min:5', 'alpha_num', 'unique:users,name,' . $user->id],
            'image' => 'sometimes|image|mimes:png,jpg,jpeg|between:1,5000',
        ]);
        if ($request->hasFile('image')) {
            $oldImage = $user->public_id;
            $image = $request->file('image');
            $realPath = $image->getRealPath();
            $public_id = 'users/' . $image->getBasename() . time();
            Cloudder::upload($realPath, 'users/' . $image->getBasename() . time());
            list($width, $height) = getimagesize($realPath);
            $imageUrl = Cloudder::show(Cloudder::getPublicId(), ['width' => $width / 3, 'height' => $height / 3]);
            $user->image = $imageUrl;
            $user->public_id = $public_id;
            if($oldImage != null) {
                Cloudder::destroyImage($oldImage);
            }
        }
        $user->name = $request->name;
        $user->save();
        return response(['data' => $user, 'message' => 'success']);
    }
}
