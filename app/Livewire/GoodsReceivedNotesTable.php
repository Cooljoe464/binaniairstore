<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GoodsReceivedNote;

class GoodsReceivedNotesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $grType = '';
    public $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'grType' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function render()
    {
        $goodsReceivedNotes = GoodsReceivedNote::query()
            ->when($this->search, function ($query) {
                $query->where('gr_details', 'like', '%' . $this->search . '%')
                      ->orWhere('supplier_name', 'like', '%' . $this->search . '%')
                      ->orWhere('part_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->grType, function ($query) {
                $query->where('gr_type', $this->grType);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->paginate($this->perPage);

        return view('livewire.goods-received-notes-table', [
            'goodsReceivedNotes' => $goodsReceivedNotes,
        ]);
    }
}
