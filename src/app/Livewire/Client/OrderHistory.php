<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;

class OrderHistory extends Component
{
    public $tableId;
    public $orders = [];

    public function getListeners()
    {
        return [
            "echo:tables.{$this->tableId},OrderItemUpdated" => 'refreshOrders',
            "echo:tables.{$this->tableId},OrderCreated" => 'refreshOrders', // Also refresh when new order placed
        ];
    }

    public function mount()
    {
        $this->tableId = session('table_id');
        if (!$this->tableId) {
            return redirect()->route('home');
        }
        $this->refreshOrders();
    }

    public function refreshOrders()
    {
        // Get all orders for this table session
        $this->orders = Order::where('table_id', $this->tableId)
            ->where('created_at', '>=', now()->subHours(24))
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function cancelItem($itemId)
    {
        $item = OrderItem::find($itemId);
        
        if ($item && $item->order->table_id == $this->tableId && $item->status === 'pending') {
            $item->status = 'cancelled';
            $item->save();
            $this->refreshOrders();
            // Optional: Broadcast event to kitchen
        }
    }

    public function render()
    {
        return view('livewire.client.order-history')->layout('layouts.guest');
    }
}
