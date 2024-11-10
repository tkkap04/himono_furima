<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class MypageController extends Controller
{
        public function index()
    {
        $user = Auth::user();
        $sellingItems = Item::where('seller_id', $user->id)->get();

        return view('mypage', [
            'user' => $user,
            'items' => $sellingItems,
            'activeTab' => 'selling',
        ]);
    }

    public function selling()
    {
        $user = Auth::user();
        $sellingItems = Item::where('seller_id', $user->id)->get();

        return view('mypage', [
            'user' => $user,
            'items' => $sellingItems,
            'activeTab' => 'selling',
        ]);
    }

    public function purchased()
    {
        $user = Auth::user();
        $purchasedItems = Item::where('buyer_id', $user->id)->get();

        return view('mypage', [
            'user' => $user,
            'items' => $purchasedItems,
            'activeTab' => 'purchased',
        ]);
    }

}
