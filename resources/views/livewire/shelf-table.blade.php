<div>
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search shelves..." class="w-1/3 px-3 py-2 border border-gray-300 rounded-md">
        <a href="{{ route('shelves.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Shelf</a>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shelf Location</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($shelves as $shelf)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $shelf->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $shelf->shelfLocation->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('shelves.edit', $shelf) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('shelves.destroy', $shelf) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $shelves->links() }}
    </div>
</div>
