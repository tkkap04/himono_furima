<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $item;
    public $user;
    public $paymentMethod;

    public function __construct($user, $item, $paymentMethod)
    {
        $this->user = $user;
        $this->item = $item;
        $this->paymentMethod = $paymentMethod;
    }

    public function build()
    {
        $view = match ($this->paymentMethod) {
            '銀行振込' => 'emails.bank',
            'コンビニ払い' => 'emails.convenience', 
            default => throw new \Exception('不明な支払い方法です。'), 
        };

        return $this->view($view)
                    ->subject('【フリマアプリ】注文確定メール')
                    ->with([
                        'user' => $this->user,
                        'item' => $this->item,
                    ]);
    }
}