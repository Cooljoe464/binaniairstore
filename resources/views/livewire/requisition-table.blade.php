<div>
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search requisitions..."
               class="w-1/3 px-3 py-2 border border-gray-300 rounded-md">
        <select wire:model.live="status" class="w-1/4 px-3 py-2 border border-gray-300 rounded-md">
            <option value="">All Statuses</option>
            <option value="Pending Approval">Pending Approval</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>
            <option value="Disbursed">Disbursed</option>
        </select>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requisition
                    No
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Number
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty
                    Required
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty Issued
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New Stock Balance
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Collector's
                    Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aircraft
                    Registration
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requester
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($requisitions as $requisition)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->requisition_no }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->part->part_number ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->part->description ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->stock_balance }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->quantity_required }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->quantity_issued }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->new_stock_balance }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->collectors_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->aircraft_registration ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->requested_by }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $requisition->status->value }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('requisitions.show', $requisition) }}"
                           class="text-indigo-600 hover:text-indigo-900">View</a>
                        <a href="{{ route('requisitions.edit', $requisition) }}"
                           class="ml-2 text-yellow-600 hover:text-yellow-900">Edit</a>
                        @can('delete', $requisition)
                            <form action="{{ route('requisitions.destroy', $requisition) }}" method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-2 text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $requisitions->links() }}
    </div>
</div>
