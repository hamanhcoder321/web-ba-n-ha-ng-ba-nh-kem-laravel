<?php
namespace App\Models;

namespace App\Models;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $user_id; // Thêm thuộc tính user_id

    public function __construct($oldCart = null, $user_id = null)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->user_id = $oldCart->user_id; // Lấy user_id từ giỏ hàng cũ nếu có
        }

        if ($user_id) {
            $this->user_id = $user_id; // Thiết lập user_id nếu có tham số
        }
    }

    // Add item to cart
    public function add($item, $id)
    {
        $giohang = ['qty' => 0, 'price' => $item->unit_price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $giohang = $this->items[$id];
            }
        }
        $giohang['qty']++;
        $giohang['price'] = $item->unit_price * $giohang['qty'];
        $this->items[$id] = $giohang;
        $this->totalQty++;
        $this->totalPrice += $item->unit_price;
    }

    // Reduce item by one
    public function reduceByOne($id)
    {
        if (empty($this->items) || !isset($this->items[$id])) {
            return;
        }

        $this->items[$id]['qty']--;
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['unit_price'];

        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }

        if (!empty($this->items)) {
            session()->put('cart', $this);
        } else {
            session()->forget('cart');
        }
    }

    // Remove item from cart
    public function removeItem($id)
    {
        if (isset($this->items[$id])) {
            $this->totalQty -= $this->items[$id]['qty'];
            $this->totalPrice -= $this->items[$id]['qty'] * $this->items[$id]['item']['unit_price'];
            unset($this->items[$id]);

            if (count($this->items) > 0) {
                session()->put('cart', $this);
            } else {
                session()->forget('cart');
            }
        }
    }
}


