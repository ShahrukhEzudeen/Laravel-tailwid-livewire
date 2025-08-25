<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductPage extends Component
{
    public $products = [];
    public $item;
    public $cart = [];
    public $maxPrice = 11000;
    public $filteritem;
    public function mount()
    {

        $this->products = Product::where('price', '<=', $this->maxPrice)->get();
        $this->cart = session()->get('cart', []);
    }

    public function addToCart($productId)
    {
        $product = $this->products->firstWhere('id', $productId);

        if ($product) {
            if (isset($this->cart[$productId])) {
                $this->cart[$productId]['quantity'] += 1;
            } else {
                $this->cart[$productId] = [
                    'id'       => $product->id,
                    'name'     => $product->name,
                    'price'    => $product->price,
                    'quantity' => 1,
                ];
            }
            session()->put('cart', $this->cart);
            $this->dispatch('cart-updated');
        }
    }

    public function render()
    {
        return view('livewire.product-page', [
            'products' => $this->products,
            'cart'     => $this->cart,
        ]);
    }


    public function filter()
    {
        $filtercategory = $this->filteritem;

        $query = Product::where('price', '<=', $this->maxPrice);

        if ($filtercategory) {
            $query->where('category', $filtercategory);
        }

        $this->products = $query->get(); // store the results
    }
}
