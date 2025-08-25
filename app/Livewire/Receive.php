<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Purchase;
use Livewire\Attributes\On;
class Receive extends Component
{
    protected $listeners = ['receiveConfirmed' => 'receivePurchase'];
    public $userdata;
    public function render()
    {
        return view('livewire.receive', [
            'purchases' => Purchase::withCount('items')->latest()->get()
        ]);
    }
    public function confirmReceive($purchaseId)
    {
        $this->dispatch('confirm-receive', ['id' => $purchaseId]);
    }

     public function mount()
    {
       $this->userdata = session('userdata');
    }


      #[On('receiveConfirmed')]
    public function receive(string $data) 
    {
       $purchase = Purchase::findOrFail($data);

    if ($purchase->status === 0) {
        $this->dispatch('notify', ['type' => 'error', 'message' => 'Already received.']);
        return;
    }

    foreach ($purchase->items as $item) {

        $item->product->increment('qty_on_hand', $item->qty);
    }
    audit($this->userdata->id, "Update", $purchase, $purchase->getOriginal());
    $purchase->update(['status' => 0]);

    $this->dispatch('notify', ['type' => 'success', 'message' => 'Purchase received.']);
    }
}
