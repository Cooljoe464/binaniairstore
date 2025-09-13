<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function getPermissionsQuery()
    {
        return Permission::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('permissions.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'permissions.csv';
        $permissions = $this->getPermissionsQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($permissions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Created At']);

            foreach ($permissions as $permission) {
                fputcsv($file, [
                    $permission->name,
                    $permission->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $permissions = $this->getPermissionsQuery()->paginate(10);

        return view('livewire.permission-table', [
            'permissions' => $permissions,
        ]);
    }
}
