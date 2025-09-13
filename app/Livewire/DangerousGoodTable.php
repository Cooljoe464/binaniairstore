<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\DangerousGood;
use Livewire\Component;
use Livewire\WithPagination;

class DangerousGoodTable extends Component
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

    private function getDangerousGoodsQuery()
    {
        return DangerousGood::query()
            ->with(['supplier', 'location'])
            ->when($this->search, function ($query) {
                $query->where('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })->orderBy('dangerous_goods.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'dangerous-goods.csv';
        $dangerousGoods = $this->getDangerousGoodsQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($dangerousGoods) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Part Number', 'Description', 'Serial Number', 'Status', 'Supplier', 'Location', 'Received Date', 'Due Date']);

            foreach ($dangerousGoods as $dangerousGood) {
                fputcsv($file, [
                    (string)$dangerousGood->part_number,
                    $dangerousGood->description,
                    (string)$dangerousGood->serial_number,
                    $dangerousGood->status->value,
                    $dangerousGood->supplier->name ?? 'N/A',
                    $dangerousGood->location->name ?? 'N/A',
                    $dangerousGood->received_date->format('Y-m-d'),
                    $dangerousGood->due_date->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $dangerousGoods = $this->getDangerousGoodsQuery()->paginate(10);

        return view('livewire.dangerous-good-table', [
            'dangerousGoods' => $dangerousGoods,
            'statuses' => Status::cases(),
        ]);
    }
}
