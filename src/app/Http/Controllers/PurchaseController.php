<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($id)
    {
        $item = Item::findOrFail($id);
        $user = auth()->user();

        $currentPaymentMethod = auth()->user()->paymentMethod;
        $currentAddress = $user->postal_code . ' ' . $user->address . ' ' . $user->building_name;
        $totalPayment = $item->price;

        session(['item_id' => $item->id]);

        return view('purchase', [
            'item' => $item,
            'currentPaymentMethod' => $currentPaymentMethod,
            'currentAddress' => $currentAddress,
            'totalPayment' => $totalPayment,
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    public function confirm(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        return view('confirm', [
            'item' => $item,
            'user' => auth()->user(),
        ]);
    }
}
