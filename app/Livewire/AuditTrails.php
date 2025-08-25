<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AuditTrail;

class AuditTrails extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $logs = AuditTrail::with('user')
            ->when(
                $this->search,
                fn($q) =>
                $q->where('action', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.audit-trails', [
            'logs' => $logs,
        ]);
    }
}
