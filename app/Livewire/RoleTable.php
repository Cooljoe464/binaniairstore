<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;

class RoleTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function getRolesQuery()
    {
        return Role::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('roles.created_at', 'desc');
    }

    public function export()
    {
        $fileName = 'roles.csv';
        $roles = $this->getRolesQuery()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($roles) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Permissions', 'Created At']);

            foreach ($roles as $role) {
                fputcsv($file, [
                    $role->name,
                    $role->permissions->pluck('name')->implode(', '),
                    $role->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $roles = $this->getRolesQuery()->paginate(10);

        return view('livewire.role-table', [
            'roles' => $roles,
        ]);
    }
}
