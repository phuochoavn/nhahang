<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

class Menu extends Component
{
    public $categories;
    public $activeCategoryId = null;

    public function mount()
    {
        $this->categories = Category::where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();
            
        if ($this->categories->isNotEmpty()) {
            $this->activeCategoryId = $this->categories->first()->id;
        }
    }
    
    // Listener for cart updates if needed, logic will be in CartButton component
    // But we might need 'addToCart' here to trigger the event
    
    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) return;

        // Simple Cart Logic using Session
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }
        
        session()->put('cart', $cart);
        
        // Dispatch event for CartButton to update
        $this->dispatch('cart-updated'); 
        
        // Dispatch resize/animation event if needed
    }

    public function render()
    {
        return view('livewire.client.menu')->layout('layouts.guest');
    }
}
