<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Goods Received Note Details') }}
            </h2>
            <div class="flex items-center">
                @if ($goodsReceivedNote->status === \App\Enums\GoodsReceivedNoteStatus::PENDING_APPROVAL)
                    @can('goods-received-notes-approve')
                        <form action="{{ route('goods-received-notes.approve', $goodsReceivedNote) }}" method="POST"
                              class="mr-2">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                                Approve
                            </button>
                        </form>
                    @endcan
                &nbsp;&nbsp;&nbsp;
                    @can('goods-received-notes-reject')
                        <form action="{{ route('goods-received-notes.reject', $goodsReceivedNote) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition">
                                Reject
                            </button>
                        </form>
                    @endcan
                @endif
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">GR Details</label>
                            <p>{{ $goodsReceivedNote->gr_details }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Status</label>
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @switch($goodsReceivedNote->status)
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
                            ">{{ $goodsReceivedNote->status->value }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">GR Date</label>
                            <p>{{ $goodsReceivedNote->gr_date }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">GR Type</label>
                            <p>{{ $goodsReceivedNote->gr_type }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Order Info</label>
                            <p>{{ $goodsReceivedNote->order_info }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Supplier Name</label>
                            <p>{{ $goodsReceivedNote->supplier_name }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Order Details</label>
                            <p>{{ $goodsReceivedNote->order_details }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Waybill</label>
                            <p>{{ $goodsReceivedNote->waybill }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Part Number</label>
                            <p>{{ $goodsReceivedNote->part_number }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Description</label>
                            <p>{{ $goodsReceivedNote->description }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Serial No</label>
                            <p>{{ $goodsReceivedNote->serial_no }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Received Quantity</label>
                            <p>{{ $goodsReceivedNote->received_quantity }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Accepted Quantity</label>
                            <p>{{ $goodsReceivedNote->accepted_quantity }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Binned Quantity</label>
                            <p>{{ $goodsReceivedNote->binned_quantity }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Remark</label>
                            <p>{{ $goodsReceivedNote->remark }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Date</label>
                            <p>{{ $goodsReceivedNote->date }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Store Officer</label>
                            <p>{{ $goodsReceivedNote->storeOfficer->name ?? '' }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Received By</label>
                            <p>{{ $goodsReceivedNote->receivedBy->name ?? '' }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Inspected By</label>
                            <p>{{ $goodsReceivedNote->inspectedBy->name ?? '' }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Binned By</label>
                            <p>{{ $goodsReceivedNote->binnedBy->name ?? '' }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Approved By</label>
                            <p>{{ $goodsReceivedNote->approvedBy->name ?? 'Not Approved Yet' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
