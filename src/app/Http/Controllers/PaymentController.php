<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseConfirmationMail;

class PaymentController extends Controller
{
    public function cardProcess(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'buyer_id' => 'required|exists:users,id',
            'payment_method_id' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
        ]);

        $item = Item::findOrFail($request->input('item_id'));

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            \Log::info('Creating PaymentIntent for item ID: ' . $item->id);

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $item->price * 100,
                'currency' => 'jpy',
                'payment_method' => $request->input('payment_method'),
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            \Log::info('PaymentIntent created: ' . json_encode($paymentIntent));

            if ($paymentIntent->status === 'requires_action') {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret,
                ]);
            }

            // 購入情報を保存
            $item->update(['buyer_id' => $request->input('buyer_id')]);

            $request->user()->purchases()->create([
                'item_id' => $item->id,
                'buyer_id' => $request->input('buyer_id'),
                'payment_method_id' => $request->input('payment_method_id'),
                'postal_code' => $request->input('postal_code'),
                'address' => $request->input('address'),
                'building_name' => $request->input('building_name'),
                'payment_status' => '済',
                'purchased_at' => now(),
            ]);

            return redirect()->route('purchase.success.card');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function successCard()
    {
        return view('success.card');
    }


    public function nonCardProcess(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'buyer_id' => 'required|exists:users,id',
            'payment_method_id' => 'required|integer',
            'postal_code' => 'required',
            'address' => 'required',
        ]);

        $user = auth()->user();
        $item = Item::findOrFail($request->input('item_id'));
        $paymentMethod = $request->input('payment_method_id') == 1 ? '銀行振込' : 'コンビニ払い';

        Mail::to($user->email)->send(new PurchaseConfirmationMail($user, $item, $paymentMethod));

        $item->update(['buyer_id' => $request->input('buyer_id')]);

        $user->purchases()->create([
            'item_id' => $item->id,
            'buyer_id' => $request->input('buyer_id'),
            'payment_method_id' => $request->input('payment_method_id'),
            'postal_code' => $request->input('postal_code'),
            'address' => $request->input('address'),
            'building_name' => $request->input('building_name'),
            'payment_status' => '未',
            'purchased_at' => now(),
        ]);

        return redirect()->route('purchase.success.noncard');
        
    }

    public function successNonCard()
    {
        return view('success.noncard');
    }

}
