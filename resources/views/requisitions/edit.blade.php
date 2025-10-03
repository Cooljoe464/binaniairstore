<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit General Requisition') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">
                        Edit Requisition: {{ $requisition->requisition_no }}
                    </h1>

                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('requisitions.update', $requisition) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="requisition_no" class="block text-sm font-medium text-gray-700">Requisition No</label>
                                <input type="text" name="requisition_no" id="requisition_no" value="{{ $requisition->requisition_no }}" readonly class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="requested_by" class="block text-sm font-medium text-gray-700">Requested By</label>
                                <input type="text" name="requested_by" id="requested_by" value="{{ $requisition->requested_by }}" readonly class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="part_id" class="block text-sm font-medium text-gray-700">Part Number</label>
                                <select @if(auth()->user()->hasRole('Admin')) name="part_id" @else readonly name="part_id"  @endif  id="part_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a part</option>
                                    @foreach($parts as $part)
                                        <option value="{{ $part->id }}"
                                                data-description="{{ $part->description }}"
                                                data-quantity="{{ $part->quantity }}"
                                                {{ $requisition->part_id == $part->id ? 'selected' : '' }}>
                                            {{ $part->part_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" id="description" value="{{ $requisition->part->description ?? '' }}" readonly class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="stock_balance" class="block text-sm font-medium text-gray-700">Stock Balance</label>
                                <input type="text" name="stock_balance" id="stock_balance" value="{{ $requisition->part->quantity ?? '' }}" readonly class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="quantity_required" class="block text-sm font-medium text-gray-700">Quantity Required</label>
                                <input type="number" name="quantity_required" id="quantity_required" value="{{ $requisition->quantity_required }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="quantity_issued" class="block text-sm font-medium text-gray-700">Quantity Issued</label>
                                <input type="number" name="quantity_issued" id="quantity_issued" value="{{ $requisition->quantity_issued }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="new_stock_balance" class="block text-sm font-medium text-gray-700">New Stock Balance</label>
                                <input type="text" name="new_stock_balance" id="new_stock_balance" readonly class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="collectors_name" class="block text-sm font-medium text-gray-700">Collector's Name</label>
                                <input type="text"  name="collectors_name" id="collectors_name" value="{{ $requisition->collectors_name }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="location_to_id" class="block text-sm font-medium text-gray-700">Location To</label>
                                <select @if(auth()->user()->hasRole('Admin')) name="location_to_id" @else readonly @endif  id="location_to_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a location</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ $requisition->location_to_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="aircraft_registration" class="block text-sm font-medium text-gray-700">Aircraft</label>
                                <select @if(auth()->user()->hasRole('Admin')) name="aircraft_registration" @else readonly @endif  id="aircraft_registration" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select an aircraft</option>
                                    @foreach($aircrafts as $aircraft)
                                        <option value="{{ $aircraft->registration_number }}" {{ $requisition->aircraft_registration == $aircraft->registration_number ? 'selected' : '' }}>{{ $aircraft->registration_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="additional_notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                                <textarea @if(auth()->user()->hasRole('Admin')) name="additional_notes" @else readonly @endif  id="additional_notes" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">{{ $requisition->additional_notes }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Requisition
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const partIdSelect = document.getElementById('part_id');
            const descriptionInput = document.getElementById('description');
            const stockBalanceInput = document.getElementById('stock_balance');
            const quantityIssuedInput = document.getElementById('quantity_issued');
            const newStockBalanceInput = document.getElementById('new_stock_balance');

            partIdSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                descriptionInput.value = selectedOption.getAttribute('data-description');
                stockBalanceInput.value = selectedOption.getAttribute('data-quantity');
                updateNewStockBalance();
            });

            quantityIssuedInput.addEventListener('input', function() {
                updateNewStockBalance();
            });

            function updateNewStockBalance() {
                const stockBalance = parseInt(stockBalanceInput.value, 10);
                const quantityIssued = parseInt(quantityIssuedInput.value, 10);

                if (!isNaN(stockBalance) && !isNaN(quantityIssued)) {
                    newStockBalanceInput.value = stockBalance - quantityIssued;
                }
            }

            // Initial calculation on page load
            updateNewStockBalance();
        });
    </script>
</x-app-layout>
