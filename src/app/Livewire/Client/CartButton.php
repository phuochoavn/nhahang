<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;

class CartButton extends Component
{
    public $cart = [];
    public $showCart = false;
    public $tableId;

    public function getListeners()
    {
        return [
            'cart-updated' => 'refreshCart',
        ];
    }

    public function mount()
    {
        $this->tableId = session('table_id');
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cart = session()->get('cart', []);
    }

    public function toggleCart()
    {
        $this->showCart = !$this->showCart;
    }

    public function updateQuantity($productId, $change)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += $change;
            
            if ($this->cart[$productId]['quantity'] <= 0) {
                unset($this->cart[$productId]);
            }
            
            session()->put('cart', $this->cart);
            $this->refreshCart();
            $this->dispatch('cart-updated'); // Notify other components if needed
        }
    }

    public function removeItem($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            session()->put('cart', $this->cart);
            $this->refreshCart();
            $this->dispatch('cart-updated');
        }
    }

    public function checkout()
    {
        if (empty($this->cart)) return;

        $totalAmount = 0;
        foreach ($this->cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Create Order
        $order = Order::create([
            'table_id' => $this->tableId,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'note' => '',
        ]);

        // Create Order Items
        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'note' => '',
            ]);
        }

        // Broadcast Event
        event(new \App\Events\OrderCreated($order));

        // Clear Cart
        session()->forget('cart');
        $this->cart = [];
        $this->showCart = false;
        
        // Dispatch success event
         $this->dispatch('order-placed');
         
         return redirect()->route('order.history');
    }

    public function getTotalProperty()
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function getCountProperty()
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }

    public function render()
    {
        return view('livewire.client.cart-button');
    }
}
