<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryComponent extends Component
{
    public $subcategory_name;
    public $category_id;
    public $subcategories = [];
    public $checked = []; 
    public $category_component =[] ;
    protected $rules = [
        'subcategory_name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
    ];

    public function createSubCategory()
    {
        // Debugging: Check the input values
      
        
        $this->validate();
    
        try {
            SubCategory::create([
                'sub_category_name' => $this->subcategory_name,
                'category_id' => $this->category_id,
            ]);
            session()->flash('message', 'Subcategory created successfully.');
        } catch (\Exception $e) {
            dd('Error saving subcategory: ' . $e->getMessage());
        }
    
        $this->resetInputFields();
        $this->loadSubCategories(); // Refresh the list
    }
    

    public function loadSubCategories()
    {
        $this->subcategories = SubCategory::with('category')->get();
    }

    public function resetInputFields()
    {
        $this->subcategory_name = '';
        $this->category_id = '';
    }

    public function mount()
    {
        $this->loadSubCategories(); // Load subcategories on mount
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.sub-category-component', compact('categories'));
    }
}
