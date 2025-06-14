<?php

namespace App\Http\Livewire;

use App\Models\Section_two;
use Livewire\Component;

class SectionTwo extends Component
{
    public $addMore = [0];
    public $section_name = [];
    public $section_status = [];

    public function mount()
    {
        // Initialize fields with one empty input by default
        $this->addMore = [0];
    }

    public function AddMore()
    {
        if (count($this->addMore) < 5) {
            $this->addMore[] = count($this->addMore);
        }
    }

    public function Remove($index)
    {
        unset($this->addMore[$index]);
        unset($this->section_name[$index]);
        unset($this->section_status[$index]);

        $this->addMore = array_values($this->addMore); // Reindex array
        $this->section_name = array_values($this->section_name); // Reindex names
        $this->section_status = array_values($this->section_status); // Reindex statuses
    }

    public function store()
    {
        $this->validate([
            'section_name.*' => 'required|string|max:255',
            'section_status.*' => 'boolean',
        ]);

        foreach ($this->addMore as $index) {
            Section_two::create([
                'section_name' => $this->section_name[$index],
                'status' => $this->section_status[$index] ?? 0, // Default to 0 if not set
            ]);
        }

        session()->flash('success', 'Sections added successfully!');

        $this->reset(['section_name', 'section_status', 'addMore']);
        $this->addMore = [0];
    }

    public function render()
    {
        $sections = Section_two::all();
        return view('livewire.section-two', ['sections' => $sections]);
    }
}
