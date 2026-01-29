<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class Menu extends Component
{
    public $categories;
    public $activeCategoryId = null;

    public $cart = [];
    public $showCart = false;
    public $tableId;
    public $toast = '';

    public function mount()
    {
        $this->tableId = session('table_id');
        $this->cart = session()->get('cart', []);

        $this->categories = Category::where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        if ($this->categories->isNotEmpty()) {
            $this->activeCategoryId = $this->categories->first()->id;
        }
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
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

        session()->put('cart', $this->cart);

        $this->toast = 'Đã thêm "' . $product->name . '"';
        $this->dispatch('show-toast');
    }

    public function updateQuantity($productId, $change)
    {
        $productId = (string) $productId;

        if (!isset($this->cart[$productId])) return;

        $this->cart[$productId]['quantity'] += $change;

        if ($this->cart[$productId]['quantity'] <= 0) {
            unset($this->cart[$productId]);
        }

        session()->put('cart', $this->cart);
    }

    public function removeFromCart($productId)
    {
        $productId = (string) $productId;

        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            session()->put('cart', $this->cart);
        }
    }

    public function toggleCart()
    {
        $this->showCart = !$this->showCart;
    }

    public function submitOrder()
    {
        if (empty($this->cart)) return;

        $totalAmount = 0;
        foreach ($this->cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'table_id' => $this->tableId,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'note' => '',
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'note' => '',
            ]);
        }

        event(new \App\Events\OrderCreated($order));

        session()->forget('cart');
        $this->cart = [];
        $this->showCart = false;

        return redirect()->route('order.history');
    }

    public function getCartTotalProperty()
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function getCartCountProperty()
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }

    public function render()
    {
        return view('livewire.client.menu')->layout('layouts.guest');
    }
}
