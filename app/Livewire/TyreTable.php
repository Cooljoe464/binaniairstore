<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\Tyre;
use Livewire\Component;
use Livewire\WithPagination;

class TyreTable extends Component
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

    private function getTyresQuery()
    {
        return Tyre::query()
            ->with(['supplier', 'receivedBy', 'location'])
            ->when($this->search, function ($query) {
                $query->where('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('tyres.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'tyres.csv';
        $tyres = $this->getTyresQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($tyres) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Part Number', 'Description', 'Serial Number', 'Status', 'Supplier', 'Received By', 'Location', 'Date']);

            foreach ($tyres as $tyre) {
                fputcsv($file, [
                    (string)$tyre->part_number,
                    $tyre->description,
                    (string)$tyre->serial_number,
                    $tyre->status->value,
                    $tyre->supplier->name ?? 'N/A',
                    $tyre->receivedBy->name ?? 'N/A',
                    $tyre->location->name ?? 'N/A',
                    $tyre->date->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $tyres = $this->getTyresQuery()->paginate(10);

        return view('livewire.tyre-table', [
            'tyres' => $tyres,
            'statuses' => Status::cases(),
        ]);
    }
}
