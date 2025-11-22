<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $bill; // 🟢 THÊM DÒNG NÀY

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bill) // 🟢 TRUYỀN $bill VÀO HÀM KHỞI TẠO
    {
        $this->bill = $bill;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Đơn hàng đã được duyệt')
                    ->view('emails.order_approved');
        // KHÔNG CẦN ->with(), Laravel sẽ tự truyền $bill cho view vì là biến public
    }
}
