<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Purchase;

class Purchases extends Component
{

    public $invoice_no;
    public $purchase_date;
    public $items = [];
    public $total_cost = 0;
    public $userdata;
    public function mount()
    {
        $this->addItem();
        $this->userdata = session('userdata');
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => null, 'qty' => 1, 'unit_cost' => 0];
    }

    public function updatedItems()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total_cost = collect($this->items)->sum(function ($item) {
            $qty = is_numeric($item['qty']) ? $item['qty'] : 0;
            $unit_cost = is_numeric($item['unit_cost']) ? $item['unit_cost'] : 0;
            return $qty * $unit_cost;
        });
    }

    public function savePurchase()
    {
        $this->validate([
            'invoice_no' => 'required',
            'purchase_date' => 'required|date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $purchase = Purchase::create([
            'invoice_no' => $this->invoice_no,
            'purchase_date' => $this->purchase_date,
            'total_cost' => $this->total_cost,
            'status' => 1,
        ]);

        foreach ($this->items as $item) {
            $purchase->items()->create([
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'unit_cost' => $item['unit_cost'],
                'line_total' => $item['qty'] * $item['unit_cost'],
            ]);
        }
            audit($this->userdata->id, "Create", $purchase, "");
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Purchase created successfully.']);
        $this->reset();
        $this->addItem();
    }

    public function render()
    {

        return view('livewire.purchases', [
            'products' => Product::where('status', 1)->get()
        ]);
    }
}
