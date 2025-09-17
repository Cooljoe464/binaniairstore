<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Requisition;
use Livewire\WithPagination;

class RequisitionTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    protected $queryString = ['search', 'status'];

    public function render()
    {
        $query = Requisition::with(['requestedBy', 'part']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('requisition_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('part', function ($partQuery) {
                        $partQuery->where('part_number', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('requestedBy', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $requisitions = $query->paginate(10);

        return view('livewire.requisition-table', [
            'requisitions' => $requisitions,
        ]);
    }
}
