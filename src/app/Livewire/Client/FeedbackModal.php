<?php

namespace App\Livewire\Client;

use Livewire\Component;

class FeedbackModal extends Component
{
    public $show = false;
    public $tableId;
    public $rating = 5;
    public $content = '';
    public $submitted = false;

    public function mount()
    {
        $this->tableId = session('table_id');
    }

    public function getListeners()
    {
        if (!$this->tableId) return [];

        return [
            "echo:tables.{$this->tableId},OrderCompleted" => 'openModal',
        ];
    }

    public function openModal()
    {
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function submit()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
        ]);

        \App\Models\Feedback::create([
            'table_id' => $this->tableId,
            'rating' => $this->rating,
            'content' => $this->content,
        ]);

        $this->submitted = true;
        // Close modal after 2 seconds
        $this->dispatch('feedback-submitted'); // Optional for JS if needed
    }

    public function render()
    {
        return view('livewire.client.feedback-modal');
    }
}
