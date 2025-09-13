<?php

namespace App\Livewire;

use App\Models\ShelfLocation;
use Livewire\Component;
use Livewire\WithPagination;

class ShelfLocationTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function getShelfLocationsQuery()
    {
        return ShelfLocation::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('shelf_locations.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'shelf-locations.csv';
        $shelfLocations = $this->getShelfLocationsQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($shelfLocations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Created At']);

            foreach ($shelfLocations as $shelfLocation) {
                fputcsv($file, [
                    $shelfLocation->name,
                    $shelfLocation->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $shelfLocations = $this->getShelfLocationsQuery()->paginate(10);

        return view('livewire.shelf-location-table', [
            'shelfLocations' => $shelfLocations,
        ]);
    }
}
