<div>
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by GR details, supplier, or part number..."
               class="w-1/3 px-3 py-2 border border-gray-300 rounded-md">
        <div class="flex space-x-2">
            <select wire:model.live="grType" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">All Types</option>
                <option value="Purchase Order">Purchase Order</option>
                <option value="Transfer">Transfer</option>
                <option value="Return">Return</option>
            </select>
            <select wire:model.live="status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">All Statuses</option>
                <option value="Pending Approval">Pending Approval</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GR Details</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GR Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Number</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($goodsReceivedNotes as $note)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $note->gr_details }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $note->gr_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $note->supplier_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $note->part_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @switch($note->status)
                                @case(\App\Enums\GoodsReceivedNoteStatus::PENDING_APPROVAL)
                                    bg-yellow-100 text-yellow-800
                                    @break
                                @case(\App\Enums\GoodsReceivedNoteStatus::APPROVED)
                                    bg-green-100 text-green-800
                                    @break
                                @case(\App\Enums\GoodsReceivedNoteStatus::REJECTED)
                                    bg-red-100 text-red-800
                                    @break
                            @endswitch
                        ">{{ $note->status->value }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('goods-received-notes.show', $note) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                        <a href="{{ route('goods-received-notes.edit', $note) }}" class="ml-2 text-yellow-600 hover:text-yellow-900">Edit</a>
                        @can('goods-received-notes-delete')
                            <form action="{{ route('goods-received-notes.destroy', $note) }}" method="POST" class="inline">
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
        {{ $goodsReceivedNotes->links() }}
    </div>
</div>
