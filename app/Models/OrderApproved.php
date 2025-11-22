<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Bill;

class OrderApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $bill; // khai báo thuộc tính $bill để truyền vào view

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    public function build()
   {
    return $this->subject('Đơn hàng đã được duyệt')
                ->view('emails.order_approved');
    // KHÔNG cần ->with() vì đã có $this->bill là biến public
}
}
