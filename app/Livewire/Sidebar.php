<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
     public $userdata;
    public function render()
    {
        return view('livewire.sidebar');
    }
    public function mount()
    {
        $this->userdata = session('userdata');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
