<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function getSuppliersQuery()
    {
        return Supplier::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('contact_person', 'like', '%' . $this->search . '%')
            ->orderBy('suppliers.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'suppliers.csv';
        $suppliers = $this->getSuppliersQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($suppliers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Contact Person', 'Email', 'Phone', 'Address', 'Created At']);

            foreach ($suppliers as $supplier) {
                fputcsv($file, [
                    $supplier->name,
                    $supplier->contact_person,
                    $supplier->email,
                    $supplier->phone,
                    $supplier->address,
                    $supplier->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $suppliers = $this->getSuppliersQuery()->paginate(10);

        return view('livewire.supplier-table', [
            'suppliers' => $suppliers,
        ]);
    }
}
