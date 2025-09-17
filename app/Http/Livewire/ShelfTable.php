<?php

namespace App\Http\Livewire;

use App\Models\Shelf;
use Livewire\Component;
use Livewire\WithPagination;

class ShelfTable extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $shelves = Shelf::with('shelfLocation')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('shelfLocation', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.shelf-table', [
            'shelves' => $shelves,
        ]);
    }
}
