<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class HuyhangClient extends Mailable
{
    use Queueable, SerializesModels;
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;

    }

    public function build()
    {
        return $this->subject('Đơn hàng của bạn đã được hủy')
                    ->view('auths.email.huyhang')
                    ->with([
                        'order' => $this->order,
                    ]);
    }
}
