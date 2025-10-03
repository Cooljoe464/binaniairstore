<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Goods Received Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('goods-received-notes.update', $goodsReceivedNote) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="gr_details" class="block font-medium text-sm text-gray-700">GR
                                    Details</label>
                                <input id="gr_details" name="gr_details" type="text" class="mt-1 block w-full"
                                       value="{{ old('gr_details', $goodsReceivedNote->gr_details) }}"/>
                            </div>
                            <div>
                                <label for="gr_date" class="block font-medium text-sm text-gray-700">GR Date</label>
                                <input id="gr_date" name="gr_date" type="date" class="mt-1 block w-full"
                                       value="{{ old('gr_date', $goodsReceivedNote->gr_date) }}"/>
                            </div>
                            <div>
                                <label for="gr_type" class="block font-medium text-sm text-gray-700">GR Type</label>
                                <select id="gr_type" name="gr_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a type</option>
                                    <option value="Purchase Order" {{ old('gr_type', $goodsReceivedNote->gr_type) == 'Purchase Order' ? 'selected' : '' }}>Purchase Order</option>
                                    <option value="Transfer" {{ old('gr_type', $goodsReceivedNote->gr_type) == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                    <option value="Return" {{ old('gr_type', $goodsReceivedNote->gr_type) == 'Return' ? 'selected' : '' }}>Return</option>
                                </select>
                            </div>
                            <div>
                                <label for="order_info" class="block font-medium text-sm text-gray-700">Order
                                    Info</label>
                                <input id="order_info" name="order_info" type="text" class="mt-1 block w-full"
                                       value="{{ old('order_info', $goodsReceivedNote->order_info) }}"/>
                            </div>
                            <div>
                                <label for="supplier_id" class="block font-medium text-sm text-gray-700">Supplier Name</label>
                                <select id="supplier_id" name="supplier_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $goodsReceivedNote->supplier_name) == $supplier->name ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="order_details" class="block font-medium text-sm text-gray-700">Order
                                    Details</label>
                                <input id="order_details" name="order_details" type="text" class="mt-1 block w-full"
                                       value="{{ old('order_details', $goodsReceivedNote->order_details) }}"/>
                            </div>
                            <div>
                                <label for="waybill" class="block font-medium text-sm text-gray-700">Waybill</label>
                                <input id="waybill" name="waybill" type="text" class="mt-1 block w-full"
                                       value="{{ old('waybill', $goodsReceivedNote->waybill) }}"/>
                            </div>
                            <div>
                                <label for="part_id" class="block font-medium text-sm text-gray-700">Part Number</label>
                                <select id="part_id" name="part_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a part</option>
                                    @foreach($parts as $part)
                                        <option value="{{ $part->id }}" data-description="{{ $part->description }}" data-serial-no="{{ $part->serial_number ?? 'N/A' }}" {{ old('part_id', $goodsReceivedNote->part_number) == $part->part_number ? 'selected' : '' }}>{{ $part->part_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="description"
                                       class="block font-medium text-sm text-gray-700">Description</label>
                                <textarea id="description" name="description" readonly
                                          class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('description', $goodsReceivedNote->description) }}</textarea>
                            </div>
                            <div>
                                <label for="serial_no" class="block font-medium text-sm text-gray-700">Serial No</label>
                                <input id="serial_no" name="serial_no" type="text" readonly class="mt-1 block w-full"
                                       value="{{ old('serial_no', $goodsReceivedNote->serial_no) }}"/>
                            </div>
                            <div>
                                <label for="received_quantity" class="block font-medium text-sm text-gray-700">Received
                                    Quantity</label>
                                <input id="received_quantity" name="received_quantity" type="number"
                                       class="mt-1 block w-full"
                                       value="{{ old('received_quantity', $goodsReceivedNote->received_quantity) }}"/>
                            </div>
                            <div>
                                <label for="accepted_quantity" class="block font-medium text-sm text-gray-700">Accepted
                                    Quantity</label>
                                <input id="accepted_quantity" name="accepted_quantity" type="number"
                                       class="mt-1 block w-full"
                                       value="{{ old('accepted_quantity', $goodsReceivedNote->accepted_quantity) }}"/>
                            </div>
                            <div>
                                <label for="binned_quantity" class="block font-medium text-sm text-gray-700">Binned
                                    Quantity</label>
                                <input id="binned_quantity" name="binned_quantity" type="number"
                                       class="mt-1 block w-full"
                                       value="{{ old('binned_quantity', $goodsReceivedNote->binned_quantity) }}"/>
                            </div>
                            <div>
                                <label for="remark" class="block font-medium text-sm text-gray-700">Remark</label>
                                <textarea id="remark" name="remark"
                                          class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('remark', $goodsReceivedNote->remark) }}</textarea>
                            </div>
                            <div>
                                <label for="date" class="block font-medium text-sm text-gray-700">Date</label>
                                <input id="date" name="date" type="date" class="mt-1 block w-full"
                                       value="{{ old('date', $goodsReceivedNote->date) }}"/>
                            </div>
                            <div>
                                <label for="store_officer_id" class="block font-medium text-sm text-gray-700">Store
                                    Officer</label>
                                <select id="store_officer_id" name="store_officer_id"
                                        class="form-select block w-full mt-1">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option
                                            value="{{ $user->id }}" {{ old('store_officer_id', $goodsReceivedNote->store_officer_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="received_by_id" class="block font-medium text-sm text-gray-700">Received
                                    By</label>
                                <select id="received_by_id" name="received_by_id" class="form-select block w-full mt-1">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option
                                            value="{{ $user->id }}" {{ old('received_by_id', $goodsReceivedNote->received_by_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="inspected_by_id" class="block font-medium text-sm text-gray-700">Inspected
                                    By</label>
                                <select id="inspected_by_id" name="inspected_by_id"
                                        class="form-select block w-full mt-1">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option
                                            value="{{ $user->id }}" {{ old('inspected_by_id', $goodsReceivedNote->inspected_by_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="binned_by_id" class="block font-medium text-sm text-gray-700">Binned
                                    By</label>
                                <select id="binned_by_id" name="binned_by_id" class="form-select block w-full mt-1">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option
                                            value="{{ $user->id }}" {{ old('binned_by_id', $goodsReceivedNote->binned_by_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4">
                                Update
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
            const serialNoInput = document.getElementById('serial_no');

            partIdSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                descriptionInput.value = selectedOption.getAttribute('data-description');
                serialNoInput.value = selectedOption.getAttribute('data-serial-no');
            });
        });
    </script>
</x-app-layout>
