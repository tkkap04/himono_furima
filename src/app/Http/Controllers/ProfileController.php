<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // プロフィール画像の保存処理
        if ($request->hasFile('profile_image')) {
            // 古い画像の削除
            if ($user->profile_image) {
                Storage::delete(str_replace('storage/', 'public/', $user->profile_image));
            }

            // 新しい画像を保存
            $path = $request->file('profile_image')->store('public/profile_images');
            $user->profile_image = str_replace('public/', 'storage/', $path); // パスを調整
        }

        // プロフィール情報の更新
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'プロフィールが更新されました。');
    }
}
