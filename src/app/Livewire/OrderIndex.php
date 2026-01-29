<?php

namespace App\Livewire;

use Livewire\Component;

class OrderIndex extends Component
{
    public $tableId;
    public $categories;
    public $activeCategory = null;
    public $cart = [];
    public $showCart = false;

    public function mount()
    {
        $this->tableId = session('table_id');
        // Load cart from session if exists
        $this->cart = session()->get('cart', []);
        
        $this->categories = \App\Models\Category::where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();
        
        if ($this->categories->isNotEmpty()) {
            $this->activeCategory = $this->categories->first()->id;
        }
    }

    public function addToCart($productId)
    {
        $product = \App\Models\Product::find($productId);
        if (!$product) return;

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }
        $this->saveCart();
        $this->dispatch('cart-updated'); // Optional: for UI feedback
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity']--;
            } else {
                unset($this->cart[$productId]);
            }
            $this->saveCart();
        }
    }

    public function saveCart()
    {
        session()->put('cart', $this->cart);
    }

    public function checkout()
    {
        if (empty($this->cart)) return;

        $totalAmount = 0;
        foreach ($this->cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Create Order
        $order = \App\Models\Order::create([
            'table_id' => $this->tableId,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'note' => '',
        ]);

        // Create Order Items
        foreach ($this->cart as $item) {
            \App\Models\OrderItem::create([
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
        $this->cart = [];
        $this->saveCart();
        $this->showCart = false;

        $this->dispatch('order-placed'); 
        // We can also redirect to a "Success" page or show a toast
    }

    public function getCartTotalProperty()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getCartCountProperty()
    {
        $count = 0;
        foreach ($this->cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public function render()
    {
        return view('livewire.order-index')->layout('layouts.guest');
    }
}
