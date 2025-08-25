<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Validator;

class Categories extends Component
{
    use WithPagination;

    public $code, $name, $is_active = 1, $categoryId;
    public $search = '';
    public $perPage = 10;
    public $userdata;
    public function mount()
    {
        $this->userdata = session('userdata');
    }
    public function render()
    {
        $categories = Category::withCount('products')
            ->when(
                $this->search,
                fn($q) =>
                $q->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('code', 'like', "%{$this->search}%");
                })
            )
            ->paginate($this->perPage);

        return view('livewire.categories', compact('categories'));
    }

    public function resetForm()
    {
        $this->reset(['code', 'name', 'is_active', 'categoryId']);
        $this->is_active = 1;
    }
    public function store()
    {
        $this->validate();

        Category::create([
            'code' => $this->code,
            'name' => $this->name,
            'is_active' => $this->is_active,
        ]);
        $this->dispatch('show-toast', message: 'Category added successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->code = $category->code;
        $this->name = $category->name;
        $this->is_active = $category->is_active;

        $this->dispatch('open-modal', [
            'title' => 'Edit Category',
            'category' => [
                'id' => $category?->id ?? '',
                'code' => $category?->code ?? '',
                'name' => $category?->name ?? '',
                'is_active' => $category?->is_active ?? '',
            ],
        ]);
    }


    #[On('save')]
    public function save($data)
    {

  
        $this->categoryId        = $data['id'] ?? null;
        $this->code      = $data['code'] ?? null;
        $this->name      = $data['name'] ?? null;
        $this->is_active = $data['is_active'] ?? 1;

        // Validation
        $validator = Validator::make([
            'code'      => $this->code,
            'name'      => $this->name,
            'is_active' => $this->is_active,
        ], [
            'code'      => 'required|string|max:100|unique:categories,code,' . $this->categoryId,
            'name'      => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            $this->dispatch('show-error', message: 'Invalid input');
            return;
        }
        $action = "";
        // Create or Update
        if ($this->categoryId) {
            $category = Category::withCount('products')->findOrFail($this->categoryId);
            $action = "Update";
        } else {
            $category = new Category();
            $action = "Created";
        }

        if ($category->products_count > 0) {
            $this->dispatch('show-error', message: 'Cannot change category with products assigned. Please reassign products first.');
            return;
        }
        $category->code      = $this->code;
        $category->name      = $this->name;
        $category->is_active = $this->is_active;
        $category->save();
         audit($this->userdata->id, $action, $category, $category->getOriginal());
        $message = $this->code ? 'Category updated successfully.' : 'Category created successfully.';
        $this->dispatch('show-toast', message: $message);

        // reset after save
        $this->reset(['categoryId', 'code', 'name', 'is_active']);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', categoryId: $id);
    }

    #[On('deleteConfirmed')]
    public function delete($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            $this->dispatch('show-error', message: 'Cannot delete category with products assigned. Please reassign products first.');
            return;
        }

        $category->delete();
         audit($this->userdata->id, "Delete", $category, $category->getOriginal());
        $this->dispatch('show-toast', message: 'Category deleted successfully.');
    }
}
