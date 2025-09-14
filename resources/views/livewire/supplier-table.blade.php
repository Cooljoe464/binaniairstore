<div>
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-2 sm:space-y-0">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search suppliers..." class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full sm:w-1/3">
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <button wire:click="export" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">Export to CSV</button>
            <a href="{{ route('suppliers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-center">Create Supplier</a>
        </div>
    </div>

    <!-- Desktop View -->
    <div class="hidden sm:block">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Person</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->contact_person }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="block sm:hidden">
        <div class="grid grid-cols-1 gap-4">
            @foreach ($suppliers as $supplier)
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">{{ $supplier->name }}</span>
                        <div class="text-right">
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        <div><strong>Contact:</strong> {{ $supplier->contact_person }}</div>
                        <div><strong>Email:</strong> {{ $supplier->email }}</div>
                        <div><strong>Phone:</strong> {{ $supplier->phone }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>
