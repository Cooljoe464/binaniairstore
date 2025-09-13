<?php

namespace App\Livewire;

use App\Models\Aircraft;
use Livewire\Component;
use Livewire\WithPagination;

class AircraftTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function getAircraftsQuery()
    {
        return Aircraft::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('aircraft.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'aircrafts.csv';
        $aircrafts = $this->getAircraftsQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($aircrafts) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Created At']);

            foreach ($aircrafts as $aircraft) {
                fputcsv($file, [
                    $aircraft->name,
                    $aircraft->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $aircrafts = $this->getAircraftsQuery()->paginate(10);

        return view('livewire.aircraft-table', [
            'aircrafts' => $aircrafts,
        ]);
    }
}
