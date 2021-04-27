<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Request;

class RequestAdmin extends Component
{
	public $requests, $request, $now, $user, $action;
    public function render()
    {
        return view('livewire.Admin.request-admin');
    }
}
