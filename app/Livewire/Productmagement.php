<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithFileUploads;

class Productmagement extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $id, $name, $sku, $cost_price, $sell_price, $qty_on_hand, $image, $category_code, $is_active = 1;
    public $status = '';
    public $category = '';
    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 5;
    public $userdata;
    protected $queryString = ['search', 'sortField', 'sortDirection'];

    public function applyFilters()
    {
        $this->resetPage();
    }
    public function mount()
    {
        $this->userdata = session('userdata');
    }

    public function render()
    {
        $item = Product::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('id', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== '', fn($q) => $q->where('status', (int) $this->status))
            ->when($this->category, fn($q) => $q->where('category_code', $this->category))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $categories = Category::all();

        return view('livewire.productmagement', compact('item', 'categories'));
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

    public function edit($id = null)
    {
        if ($id) {
            // Edit mode
            $product = Product::findOrFail($id);
            $title   = 'Edit Product';
        } else {
            // Add mode
            $product = null;
            $title   = 'Add Product';
        }
        $this->dispatch('open-modal', [
            'title' => 'Edit Product',
            'product' => [
                'id' => $product?->id ?? '',
                'name' => $product?->name ?? '',
                'sku' => $product?->sku ?? '',
                'category_code' => $product?->category_code ?? '',
                'cost_price' => $product?->cost_price,
                'is_active' => $product?->is_active ?? $this->is_active,
                'sell_price' => $product?->sell_price,
                'qty_on_hand' => $product?->qty_on_hand,
                'status' => $product?->status ?? '',
                'thumbnail_path' => $product?->thumbnail_path ?? '',
            ],
            'categories' => Category::where('is_active', 1)->get(['code', 'name']),
        ]);
    }

    #[On('save')]
    public function save($data)
    {
        $this->id   = $data['id'] ?? null;
        $this->name        = $data['name'];
        $this->sku         = $data['sku'];
        $this->category_code = $data['category_code'];
        $this->cost_price  = $data['cost_price'];
        $this->sell_price  = $data['sell_price'];
        $this->qty_on_hand = $data['qty_on_hand'];
        $this->is_active = $data['is_active'];
        $validator = Validator::make([
            'name'        => $this->name,
            'sku'         => $this->sku,
            'category_code' => $this->category_code,
            'cost_price'  => $this->cost_price,
            'sell_price'  => $this->sell_price,
            'qty_on_hand' => $this->qty_on_hand,
            'image'       => $this->image,
        ], [
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:100|unique:products,sku',
            'category_code' => 'required',
            'cost_price'  => 'required|numeric|min:0',
            'sell_price'  => 'required|numeric|min:0',
            'qty_on_hand' => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        if ($validator->fails()) {
            $this->dispatch('show-error', message: 'Input Invalid');
            return;
        }
        $action = '';

        if ($this->id) {
            if ($this->userdata->roles->name != "Admin") {
                $this->dispatch('show-error', message: 'Not Allow To Edit');
                return;
            }
            $product = Product::findOrFail($this->id);
            $action = "Update";
        } else {
            $product = new Product();
            $action = "Create";
        }

        $old =  $product;
        $product->name        = $this->name;
        $product->sku         = $this->sku;
        $product->category_code = $this->category_code;
        $product->cost_price  = $this->cost_price;
        $product->sell_price  = $this->sell_price;
        $product->qty_on_hand = $this->qty_on_hand;
        $product->status = $this->is_active;
        if ($this->image) {
            $path = $this->image->store('products', 'public');
            $product->thumbnail_path = $path;
        }
        audit($this->userdata->id, $action, $product, $old->getOriginal());
        $product->save();
        $message = $this->id ? 'Product updated successfully.' : 'Product created successfully.';
        $this->dispatch('show-toast', message: $message);
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
            return;
        }
        $product = Product::findOrFail($id)->delete();
        audit($this->userdata->id, "Delete", $product, '');
        $this->dispatch('show-toast', message: 'User deleted.');
    }
}
