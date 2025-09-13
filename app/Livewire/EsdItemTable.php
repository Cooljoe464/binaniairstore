<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\EsdItem;
use Livewire\Component;
use Livewire\WithPagination;

class EsdItemTable extends Component
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

    private function getEsdItemsQuery()
    {
        return EsdItem::query()
            ->with(['supplier', 'location'])
            ->when($this->search, function ($query) {
                $query->where('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })->orderBy('esd_items.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'esd-items.csv';
        $esdItems = $this->getEsdItemsQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($esdItems) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Part Number', 'Description', 'Serial Number', 'Status', 'Supplier', 'Location', 'Received Date']);

            foreach ($esdItems as $esdItem) {
                fputcsv($file, [
                    (string)$esdItem->part_number,
                    $esdItem->description,
                    (string)$esdItem->serial_number,
                    $esdItem->status->value,
                    $esdItem->supplier->name ?? 'N/A',
                    $esdItem->location->name ?? 'N/A',
                    $esdItem->received_date->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $esdItems = $this->getEsdItemsQuery()->paginate(10);

        return view('livewire.esd-item-table', [
            'esdItems' => $esdItems,
            'statuses' => Status::cases(),
        ]);
    }
}
