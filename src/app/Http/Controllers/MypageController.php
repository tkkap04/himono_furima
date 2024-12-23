<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->get('tab', 'selling');

        if ($tab === 'selling') {
            $items = Item::where('seller_id', $user->id)->with('images')->get();
        } elseif ($tab === 'purchased') {
            $items = Item::where('buyer_id', $user->id)->with('images')->get();
        } else {
            $items = collect(); 
        }

        return view('mypage', [
            'user' => $user,
            'items' => $items,
            'activeTab' => $tab,
        ]);
    }
}
