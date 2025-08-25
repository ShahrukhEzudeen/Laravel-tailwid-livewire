<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Users extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $name, $email, $password, $userId;
    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 5;
    public $userdata;
    protected $queryString = ['search', 'sortField', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function mount()
    {
        $this->userdata = session('userdata');
    }

    public function render()
    {
        $users = User::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->where('is_active', 1) // Now this applies to all the above conditions
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.users', compact('users'));
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->dispatch('open-modal', [
            'title' => 'Edit User',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }

    #[On('save')]
    public function save($data)
    {

        $validator = Validator::make($data, [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'nullable'
        ]);

        if ($validator->fails()) {
            $this->dispatch('show-error', message: 'Input Invalid');
            return;
        }

        if (!empty($data['id'])) {

            if ($this->userdata->roles->name != "Admin") {
                $this->dispatch('show-error', message: 'Not Allow To Edit');
            }

            $user = User::findOrFail($data['id']);
            $user->name = $data['name'];
            $user->email = $data['email'];
            if (!empty($data['password'])) {
                $user->password = bcrypt($data['password']);
            }
            audit($this->userdata->id, "Updated", $user, $user->getOriginal());
            $user->save();
            $this->dispatch('show-toast', message: 'User updated successfully.');
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
            audit($this->userdata->id, "Create", $user, $user->getOriginal());
            $this->dispatch('show-toast', message: 'User created successfully.');
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', userId: $id);
    }

    #[On('deleteConfirmed')]
    public function delete($id)
    {
        if ($this->userdata->roles->name != "Admin") {
            $this->dispatch('show-error', message: 'Not Allow To Delete');
        }
        $user = User::findOrFail($id);
        $user->roles()->update(['is_active' => 0]);
        $user->update(['is_active' => 0]);


        audit($this->userdata->id, "Delete", $user, $user->getOriginal());
        $this->dispatch('show-toast', message: 'User deleted.');
    }
}
