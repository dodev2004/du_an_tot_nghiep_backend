<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelOrderAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $status = request()->status;
        $subject = $status == 7 ? 'Đơn hàng của bạn đã được hủy' : 
                  ($status == 8 ? 'Đơn hàng của bạn đã được hoàn' : 'Trạng thái đơn hàng');  
        return $this->subject($subject)
                    ->view('auths.email.cancel')
                    ->with([
                        'order' => $this->order,
                    ]);
    }
}
