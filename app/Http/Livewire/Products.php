<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class Products extends Component {

    public $products, $title, $description, $product_id;
    public $isOpen = false;

    public function render() {

        $this->products = Product::all();
        return view('livewire.products');

    }

    public function create() {

        $this->resetInputFields();
        $this->openModal();

    }

    public function openModal() {
        $this->isOpen = true;
    }

    public function closeModal() {
        $this->isOpen = false;
    }

    private function resetInputFields() {

        $this->title = '';
        $this->description = '';
        $this->product_id = '';

    }

    public function store() {

        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Product::updateOrCreate(['id' => $this->product_id], [
            'title' => $this->title,
            'description' => $this->description
        ]);

        session()->flash('message',
        $this->product_id ? 'Product Updated Successfully' : 'Product Created Successfully');

        $this->closeModal();
        $this->resetInputFields();

    }

    public function edit($id) {

        $product = Product::findOrFail($id);

        $this->product_id = $id;
        $this->description = $product->description;
        $this->title = $product->title;

        $this->openModal();

    }

    public function delete($id) {
        Product::find($id)->delete();
        session()->flash('message', 'Post Delete Successfully');
    }

}
