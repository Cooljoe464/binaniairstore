<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\Consumable;
use Livewire\Component;
use Livewire\WithPagination;

class ConsumableTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function filterByStatus($status = null)
    {
        $this->status = $status;
        $this->resetPage();
    }

    private function getConsumablesQuery()
    {
        return Consumable::query()
            ->with(['aircraft', 'receivedBy', 'supplier', 'location'])
            ->when($this->search, function ($query) {
                $query->where('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })->orderBy('consumables.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'consumables.csv';
        $consumables = $this->getConsumablesQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($consumables) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Part Number', 'Description', 'Quantity', 'Aircraft', 'Due Date', 'Received By', 'Status', 'Supplier', 'Location', 'Received Date']);

            foreach ($consumables as $consumable) {
                fputcsv($file, [
                    (string)$consumable->part_number,
                    $consumable->description,
                    $consumable->quantity_received,
                    $consumable->aircraft->name ?? 'N/A',
                    $consumable->due_date->format('Y-m-d'),
                    $consumable->receivedBy->name ?? 'N/A',
                    $consumable->status->value,
                    $consumable->supplier->name ?? 'N/A',
                    $consumable->location->name ?? 'N/A',
                    $consumable->received_date->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $consumables = $this->getConsumablesQuery()->paginate(10);

        return view('livewire.consumable-table', [
            'consumables' => $consumables,
            'statuses' => Status::cases(),
        ]);
    }
}
