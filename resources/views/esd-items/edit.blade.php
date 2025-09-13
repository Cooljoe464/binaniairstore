<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit ESD Item') }}
        </h2>
    </x-slot>
    <div class="container mx-auto">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form action="{{ route('esd-items.update', $esdItem) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="part_number" class="block text-sm font-medium text-gray-700">Part Number</label>
                                <input type="text" name="part_number" id="part_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('part_number', $esdItem->part_number) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
                                <input type="text" name="serial_number" id="serial_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('serial_number', $esdItem->serial_number) }}" required>
                            </div>

                            <div class="mb-4 md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $esdItem->description) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="received_quantity" class="block text-sm font-medium text-gray-700">Received Quantity</label>
                                <input type="number" name="received_quantity" id="received_quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('received_quantity', $esdItem->received_quantity) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="accepted_quantity" class="block text-sm font-medium text-gray-700">Accepted Quantity</label>
                                <input type="number" name="accepted_quantity" id="accepted_quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('accepted_quantity', $esdItem->accepted_quantity) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="binned_quantity" class="block text-sm font-medium text-gray-700">Binned Quantity</label>
                                <input type="number" name="binned_quantity" id="binned_quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('binned_quantity', $esdItem->binned_quantity) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="ak_reg" class="block text-sm font-medium text-gray-700">AK Reg</label>
                                <input type="text" name="ak_reg" id="ak_reg" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('ak_reg', $esdItem->ak_reg) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach(App\Enums\Status::cases() as $status)
                                        <option value="{{ $status->value }}" {{ old('status', $esdItem->status->value) == $status->value ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="airway_bill" class="block text-sm font-medium text-gray-700">Airway Bill</label>
                                <input type="text" name="airway_bill" id="airway_bill" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('airway_bill', $esdItem->airway_bill) }}">
                            </div>

                            <div class="mb-4">
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $esdItem->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="location_id" class="block text-sm font-medium text-gray-700">Shelf Location</label>
                                <select name="location_id" id="location_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id', $esdItem->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="received_date" class="block text-sm font-medium text-gray-700">Received Date</label>
                                <input type="date" name="received_date" id="received_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('received_date', $esdItem->received_date->format('Y-m-d')) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="store_officer_id" class="block text-sm font-medium text-gray-700">Store Officer</label>
                                <select name="store_officer_id" id="store_officer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach($storeOfficers as $officer)
                                        <option value="{{ $officer->id }}" {{ old('store_officer_id', $esdItem->store_officer_id) == $officer->id ? 'selected' : '' }}>{{ $officer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 md:col-span-2">
                                <label for="remark" class="block text-sm font-medium text-gray-700">Remark</label>
                                <textarea name="remark" id="remark" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('remark', $esdItem->remark) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('esd-items.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
