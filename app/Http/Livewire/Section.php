<?php

namespace App\Http\Livewire;

use App\Models\Section as SectionModel;
use Livewire\Component;

class Section extends Component
{
    public $addMore = [1];
    public $section_names = [];  // For multiple new inputs
    public $section_statuses = [];
    public $section_name = '';  // For single editing input
    public $section_status = false;
    public $editingSectionId = null;
    public $count = 0;
    public $checked = []; // Array to hold selected IDs
    public $checked_id;  
    public $selectAll = false;

    public function mount()
    {
        // Load existing sections from the database (for editing? or show)
        // Here we just reset the arrays for new inputs
        $this->section_names = [];
        $this->section_statuses = [];
        $this->addMore = [1];
    }

    public function addMore()
    {
        if (count($this->addMore) < 5) {
            $this->addMore[] = count($this->addMore) + 1;  // Add another input
        }
    }

    // public function store()
    // {
    //     $this->validate([
    //         'section_names.*' => 'required|string|max:255',
    //         'section_statuses.*' => 'sometimes|boolean',
    //     ]);

    //     foreach ($this->addMore as $key) {
    //         $name = $this->section_names[$key - 1] ?? null; // Set to null if not found
    //         $status = $this->section_statuses[$key - 1] ?? 0;

    //         // Only create a section if the name is not empty
    //         if (!empty($name)) {
    //             SectionModel::create([
    //                 'section_name' => $name,
    //                 'status' => $status,
    //             ]);
    //         }
    //     }

    //     $this->formReset();
    //     $this->SwalMessageDialog('Sections inserted successfully');
    // }
    public function store()
    {
        $this->validate([
            'section_names.*' => 'required|string|max:255',
            'section_statuses.*' => 'sometimes|boolean',
        ]);

        foreach ($this->addMore as $key) {
            $name = $this->section_names[$key - 1] ?? null;
            $status = $this->section_statuses[$key - 1] ?? 0;

            if (!empty($name)) {
                SectionModel::create([
                    'section_name' => $name,
                    'status' => $status,
                ]);
            }
        }

        $this->formReset();
        $this->SwalMessageDialog('Sections inserted successfully');
        $this->dispatchBrowserEvent('closeModel');
    }

    public function editSection($section_id)
    {
        $section = SectionModel::findOrFail($section_id);
        $this->editingSectionId = $section->id;
        $this->section_name = $section->section_name;
        $this->section_status = (bool) $section->status;  // cast to boolean for switch
    }

    public function formReset()
    {
        $this->section_names = [];
        $this->section_statuses = [];
        $this->addMore = [1];
        $this->section_name = '';
        $this->section_status = false;
        $this->editingSectionId = null;
    }

    public function delete($index)
    {
        unset($this->section_names[$index]);
        unset($this->section_statuses[$index]);
        unset($this->addMore[$index]);

        $this->addMore = array_values($this->addMore);
        $this->count--;
    }

 
    public function update()
    {
        $this->validate([
            'section_name' => 'required|string|max:255',
            'section_status' => 'sometimes|boolean',
        ]);

        $section = SectionModel::find($this->editingSectionId);
        if ($section) {
            $section->update([
                'section_name' => $this->section_name,
                'status' => $this->section_status,
            ]);

            $this->formReset();
            $this->SwalMessageDialog('Section updated successfully');
            $this->dispatchBrowserEvent('closeModel');
        } else {
            $this->SwalMessageDialog('Section not found');
        }
    }

    function isChecked($section_id)
    {
        return $this->checked && $this->selectAll
            ? in_array($section_id, $this->checked)
            : in_array($section_id, $this->checked);
    }

    function updatedSelectAll($value_in_array)
    {
        $this->checked = $value_in_array ? SectionModel::pluck('id')->toArray() : [];
    }

    // public function SwalMessageDialog($message)
    // {
    //     $this->dispatchBrowserEvent('MSGSuccessful', [
    //         'title' => $message,
    //     ]);

    // }

    // Delete Dialog show

    protected $listeners = ['RecordDeleted'];

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeletedRecord', [
            'title' => 'Are you sure you want to delete all selected records?',
            'id' => $this->checked_id // Ensure this is set correctly
        ]);
    }
    

    public function ConfirmDelete($section_id, $section_name)
    {
        $this->dispatchBrowserEvent('Swal:DeletedRecord', [
            'title' => 'Are you sure you want to delete <span class="text-danger">' . $section_name . '</span>',
            'id' => $section_id
        ]);
    }

    public function RecordDeleted($section_id)
    {
        if ($this->checked) {
            SectionModel::whereIn('id', $this->checked)->delete();
            $this->checked = [];
        } else {
            $section = SectionModel::find($section_id);
            if ($section) {
                $section->delete();
                $this->SwalMessageDialog('Section deleted successfully!');
            } else {
                $this->SwalMessageDialog('Section not found.');
            }
        }
    }
    

    public function SwalMessageDialog($message)
    {
        $this->dispatchBrowserEvent('MSGSuccessful', [
            'title' => $message,
        ]);
    }

    public function render()
    {
        $sections = SectionModel::all();
        return view('livewire.section', ['sections' => $sections]);
    }
}
