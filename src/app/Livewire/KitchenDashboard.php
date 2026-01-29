<?php

namespace App\Livewire;

use Livewire\Component;

class KitchenDashboard extends Component
{
    public $orders;

    public function getListeners()
    {
        return [
            "echo:kitchen,OrderCreated" => 'refreshOrders',
        ];
    }

    public function mount()
    {
        $this->refreshOrders();
    }

    public function refreshOrders()
    {
        $this->orders = \App\Models\Order::whereIn('status', ['pending', 'confirmed', 'processing'])
            ->with(['items.product', 'table'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Dispatch event to play sound on frontend if this was triggered by broadcast
        $this->dispatch('play-new-order-sound');
    }

    public function updateStatus($orderId, $status)
    {
        $order = \App\Models\Order::find($orderId);
        if ($order) {
            $order->update(['status' => $status]);

            if ($status === 'completed') {
                event(new \App\Events\OrderCompleted($order));
            }

            $this->refreshOrders();
        }
    }

    public function render()
    {
        return view('livewire.kitchen-dashboard')->layout('layouts.guest');
    }
}
