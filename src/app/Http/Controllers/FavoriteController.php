<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $item = Item::findOrFail($request->item_id);

        // 重複登録の防止
        if (!Auth::user()->favorites()->where('item_id', $item->id)->exists()) {
            Auth::user()->favorites()->create(['item_id' => $item->id]);
        }

        return back()->with('success', 'アイテムをお気に入りに追加しました。');
    }

    public function destroy(Item $item)
    {
        $favorite = Auth::user()->favorites()->where('item_id', $item->id)->first();

        if ($favorite) {
            $favorite->delete();
        }

        return back()->with('success', 'お気に入りから削除しました。');
    }
}
