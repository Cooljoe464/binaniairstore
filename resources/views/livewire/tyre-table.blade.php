<div>
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-2 sm:space-y-0">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search tyres..." class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full sm:w-1/3">
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <button wire:click="export" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">Export to CSV</button>
            @can('tyres-create')
                <a href="{{ route('tyres.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto text-center">Create Tyre</a>
            @endcan
        </div>
    </div>

    <div class="flex flex-wrap justify-center sm:justify-start mb-4 space-x-2">
        <button wire:click="filterByStatus(null)" class="{{ !$status ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} font-bold py-2 px-4 rounded">All</button>
        @foreach ($statuses as $s)
            <button wire:click="filterByStatus('{{ $s->value }}')" class="{{ $status === $s->value ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} font-bold py-2 px-4 rounded">{{ $s->name }}</button>
        @endforeach
    </div>

    <!-- Desktop View -->
    <div class="hidden sm:block">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Number</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aircraft Registration</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remark</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received By</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Airway Bill</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tyres as $tyre)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tyre->part_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($tyre->description, 20) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tyre->serial_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ App\Enums\QuantityStatus::fromQuantity($tyre->quantity)->getColorClass() }}">{{ $tyre->quantity }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tyre->aircraft_registration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($tyre->remark, 15) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tyre->receivedBy->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @switch($tyre->status)
                                                    @case(App\Enums\Status::Serviceable)
                                                        bg-green-100 text-green-800
                                                        @break
                                                    @case(App\Enums\Status::Unserviceable)
                                                        bg-red-100 text-red-800
                                                        @break
                                                    @case(App\Enums\Status::Quarantined)
                                                        bg-yellow-100 text-yellow-800
                                                        @break
                                                    @case(App\Enums\Status::Expired)
                                                        bg-gray-100 text-gray-800
                                                        @break
                                                @endswitch
                                            ">
                                                {{ $tyre->status->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tyre->airway_bill }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tyre->supplier->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tyre->location->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tyre->date->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @can('tyres-edit')
                                                <a href="{{ route('tyres.edit', $tyre) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            @endcan
                                            @can('tyres-delete')
                                                <form action="{{ route('tyres.destroy', $tyre) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="block sm:hidden">
        <div class="grid grid-cols-1 gap-4">
            @foreach ($tyres as $tyre)
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">{{ $tyre->part_number }}</span>
                        <div class="text-right">
                            @can('tyres-edit')
                                <a href="{{ route('tyres.edit', $tyre) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            @endcan
                            @can('tyres-delete')
                                <form action="{{ route('tyres.destroy', $tyre) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        <div><strong>Description:</strong> {{ Str::limit($tyre->description, 30) }}</div>
                        <div><strong>Serial Number:</strong> {{ $tyre->serial_number }}</div>
                        <div><strong>Qty:</strong> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ App\Enums\QuantityStatus::fromQuantity($tyre->quantity)->getColorClass() }}">{{ $tyre->quantity }}</span></div>
                        <div><strong>Aircraft Registration:</strong> {{ $tyre->aircraft_registration }}</div>
                        <div><strong>Remark:</strong> {{ Str::limit($tyre->remark, 30) }}</div>
                        <div><strong>Received By:</strong> {{ $tyre->receivedBy->name ?? 'N/A' }}</div>
                        <div><strong>Airway Bill:</strong> {{ $tyre->airway_bill }}</div>
                        <div><strong>Supplier:</strong> {{ $tyre->supplier->name }}</div>
                        <div><strong>Location:</strong> {{ $tyre->location->name }}</div>
                        <div><strong>Date:</strong> {{ $tyre->date->format('d-m-Y') }}</div>
                        <div><strong>Status:</strong>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @switch($tyre->status)
                                    @case(App\Enums\Status::Serviceable)
                                        bg-green-100 text-green-800
                                        @break
                                    @case(App\Enums\Status::Unserviceable)
                                        bg-red-100 text-red-800
                                        @break
                                    @case(App\Enums\Status::Quarantined)
                                        bg-yellow-100 text-yellow-800
                                        @break
                                    @case(App\Enums\Status::Expired)
                                        bg-gray-100 text-gray-800
                                        @break
                                @endswitch
                            ">
                                {{ $tyre->status->name }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        {{ $tyres->links() }}
    </div>
</div>
