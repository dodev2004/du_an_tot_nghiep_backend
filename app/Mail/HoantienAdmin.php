<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class HoantienAdmin extends Mailable
{
    public $order;
    public $mesage;
    public function __construct(Order $order, $mesage)
    {
        $this->order = $order;
        $this->mesage = $mesage;
    }

    public function build()
    {
        $status = request()->status;
        $subject = $status == 7 ? 'Đơn hàng của bạn đã được hủy' : 
                  ($status == 8 ? 'Đơn hàng của bạn đã được hoàn' : 'Trạng thái đơn hàng');  
        return $this->subject($subject)
                    ->view('auths.email.hoantien')
                    ->with([
                        'order' => $this->order,
                        'mesage' => $this->mesage
                    ]);
    }
}
