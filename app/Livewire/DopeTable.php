<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\Dope;
use Livewire\Component;
use Livewire\WithPagination;

class DopeTable extends Component
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

    private function getDopesQuery()
    {
        return Dope::query()
            ->with(['supplier', 'receivedBy', 'location'])
            ->when($this->search, function ($query) {
                $query->where('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })->orderBy('dopes.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'dopes.csv';
        $dopes = $this->getDopesQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($dopes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Part Number', 'Description', 'Quantity', 'Status', 'Supplier', 'Airway Bill', 'Location', 'Received By', 'Date']);

            foreach ($dopes as $dope) {
                fputcsv($file, [
                    (string)$dope->part_number,
                    $dope->description,
                    $dope->quantity_received,
                    $dope->status->value,
                    $dope->supplier->name ?? 'N/A',
                    $dope->airway_bill,
                    $dope->location->name ?? 'N/A',
                    $dope->receivedBy->name ?? 'N/A',
                    $dope->date->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $dopes = $this->getDopesQuery()->paginate(10);

        return view('livewire.dope-table', [
            'dopes' => $dopes,
            'statuses' => Status::cases(),
        ]);
    }
}
