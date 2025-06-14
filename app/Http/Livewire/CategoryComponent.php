<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Section;

class CategoryComponent extends Component
{
    public $addMore = [1];
    public $category_names = [];  
    public $category_name = '';   
    public $category_status = false;
    public $editingCategoryId = null;
    public $count = 0;
    public $checked = []; 
    public $checked_id;  
    public $selectAll = false;
    public $section_id = null; 
    public $sections = []; 
    public $discount = 0; 
    public $description = '';
    public $status;
    public $categoryId;
    public $categories = [];
    
    protected $rules = [
        'category_name' => 'required|string|max:255',
        'category_status' => 'boolean',
        'section_id' => 'required|exists:sections,id',
        'discount' => 'nullable|numeric|min:0',
        'description' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        $this->sections = Section::all(); 
        $this->categories = Category::all(); 
    }

    public function store()
    {
        $this->validate();
    
        Category::create([
            'section_id' => $this->section_id,
            'category_name' => $this->category_name,
            'status' => $this->category_status,
            'discount' => $this->discount,
            'description' => $this->description,
        ]);
    
        $this->resetInputFields();
        session()->flash('message', 'Category added successfully.');
        $this->dispatchBrowserEvent('closeModel');
    }

    public function resetInputFields()
    {
        $this->category_name = '';
        $this->category_status = false;
        $this->section_id = null; 
        $this->discount = 0;
        $this->description = '';
    }

    public function ConfirmDelete($id, $categoryName)
    {
        $this->checked_id = $id;
        $this->dispatchBrowserEvent('Swal:DeletedRecord', [
            'title' => "Delete Category: $categoryName",
            'id' => $id,
        ]);
    }

    protected $listeners = [
        'deleteCategory' => 'deleteCategory',
    ];

    public function deleteCategory()
    {
        if ($this->checked_id) {
            Category::find($this->checked_id)->delete();
            session()->flash('message', 'Category deleted successfully.');
            $this->checked_id = null; 
            $this->categories = Category::all(); // Refresh categories
        }
    }


  
 public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->category_name = $category->category_name;
        $this->category_status = $category->status;
        $this->discount = $category->discount;
        $this->description = $category->description;

        // Modal will be displayed based on the presence of categoryId
    }

    public function updateCategory()
    {
        $this->validate([
            'category_name' => 'required|string|max:255',
            'discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'category_name' => $this->category_name,
            'status' => $this->category_status,
            'discount' => $this->discount,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Category updated successfully.');
        $this->resetInputFields();
        $this->categories = Category::all(); // Refresh categories
    }

    


  


    public function render()
    {
        return view('livewire.category-component', [
            'sections' => $this->sections,
            'category_component' => $this->categories, // Use the updated categories
        ]);
    }
}
