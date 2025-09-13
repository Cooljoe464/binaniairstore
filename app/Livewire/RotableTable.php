<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\Rotable;
use Livewire\Component;
use Livewire\WithPagination;

class RotableTable extends Component
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

    private function getRotablesQuery()
    {
        return Rotable::query()
            ->with(['supplier', 'location'])
            ->when($this->search, function ($query) {
                $query->where('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })->orderBy('rotables.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'rotables.csv';
        $rotables = $this->getRotablesQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($rotables) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Part Number', 'Description', 'Serial Number', 'Status', 'Supplier', 'Location', 'Received Date']);

            foreach ($rotables as $rotable) {
                fputcsv($file, [
                    (string)$rotable->part_number,
                    $rotable->description,
                    (string)$rotable->serial_number,
                    $rotable->status->value,
                    $rotable->supplier->name ?? 'N/A',
                    $rotable->location->name ?? 'N/A',
                    $rotable->received_date->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $rotables = $this->getRotablesQuery()->paginate(10);
        return view('livewire.rotable-table', [
            'rotables' => $rotables,
            'statuses' => Status::cases(),
        ]);
    }
}
