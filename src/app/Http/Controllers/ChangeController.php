<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class ChangeController extends Controller
{
    public function showMethod()
    {
        $user = auth()->user();
        $currentPaymentMethod = auth()->user()->paymentMethod;
        $paymentMethods = PaymentMethod::all();

        return view('change.method', compact('user', 'currentPaymentMethod', 'paymentMethods'));
    }

    public function updateMethod(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $user = auth()->user();
        $user->payment_method_id = $request->payment_method_id;
        $user->save();

        $itemId = session('item_id') ?? $user->last_purchased_item_id;

        return redirect()->route('purchase.show', ['id' => $itemId])->with('success', '支払方法を更新しました');
    }


    // 配送先変更ページ表示
    public function showPlace()
    {
        $user = auth()->user();
        $currentAddress = $user->postal_code . ' ' . $user->address . ' ' . $user->building_name;

        return view('change.place', compact('currentAddress'));
    }


    // 配送先更新処理
    public function updatePlace(Request $request)
    {
        $request->validate([
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building_name = $request->building;
        $user->save();

        return redirect()->route('purchase.show', ['id' => session('item_id')])->with('success', '配送先を更新しました');
    }

}
