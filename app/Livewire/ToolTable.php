<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\Tool;
use Livewire\Component;
use Livewire\WithPagination;

class ToolTable extends Component
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

    private function getToolsQuery()
    {
        return Tool::query()
            ->with(['supplier', 'receivedBy', 'location'])
            ->when($this->search, function ($query) {
                $query->where('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('tools.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'tools.csv';
        $tools = $this->getToolsQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($tools) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Part Number', 'Description', 'Serial Number', 'Status', 'Calibration Date', 'Due Date', 'Supplier', 'Received By', 'Location', 'Date']);

            foreach ($tools as $tool) {
                fputcsv($file, [
                    (string)$tool->part_number,
                    $tool->description,
                    (string)$tool->serial_number,
                    $tool->status->value,
                    $tool->calibration_date->format('Y-m-d'),
                    $tool->due_date->format('Y-m-d'),
                    $tool->supplier->name ?? 'N/A',
                    $tool->receivedBy->name ?? 'N/A',
                    $tool->location->name ?? 'N/A',
                    $tool->date->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $tools = $this->getToolsQuery()->paginate(10);

        return view('livewire.tool-table', [
            'tools' => $tools,
            'statuses' => Status::cases(),
        ]);
    }
}
