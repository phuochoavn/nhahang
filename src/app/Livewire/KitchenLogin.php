<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class KitchenLogin extends Component
{
    public $pin = '';
    public $error = '';

    public function login()
    {
        // Simple hardcoded PIN for now, can be moved to .env later
        if ($this->pin === '8888') {
            session(['kitchen_access' => true]);
            return redirect()->route('kitchen');
        }

        $this->error = 'Mã PIN sai. Vui lòng thử lại.';
        $this->pin = '';
    }

    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.kitchen-login');
    }
}
