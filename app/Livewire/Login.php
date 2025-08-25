<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\User;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public function render()
    {
        return view('livewire.login');
    }
    public $email = '';
    public $password = '';
    public $remember = false;

    
    public function login()
    {
        DB::transaction(function () {
            $this->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $userdata = User::with('roles')
                ->where('email', $this->email)
                ->first();



            if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
                $userdata = User::with('roles')
                    ->where('email', $this->email)
                    ->first();
                // $userdata->assignRole($userdata->roles[0]->name);
                audit($userdata->id, 'Login', null, null);
                session(['userdata' => $userdata]);
                return redirect()->intended('/dashboard');
            } else {
                $this->addError('email', 'The provided credentials do not match our records.');
            }
        });
    }
}
