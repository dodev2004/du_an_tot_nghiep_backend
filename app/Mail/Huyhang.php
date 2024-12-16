<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class Huyhang extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $mesage;
    public function __construct(Order $order, $mesage)
    {
        $this->order = $order;
        $this->mesage = $mesage;
    }

    public function build()
    {
        return $this->subject('Đơn hàng của bạn đã được hủy')
                    ->view('auths.email.huyhang')
                    ->with([
                        'order' => $this->order,
                        'mesage' => $this->mesage
                    ]);
    }
}
