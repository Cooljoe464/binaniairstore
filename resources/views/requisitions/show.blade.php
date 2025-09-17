<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requisition Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">
                        Requisition: {{ $requisition->requisition_no }}
                    </h1>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Requisition No</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $requisition->requisition_no }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $requisition->status->value }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date Requested</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $requisition->created_at->format('d-M-Y') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border-t border-gray-200 pt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Part Details</h3>
                            <p><span class="font-medium">Part Number:</span> {{ $requisition->part->part_number ?? 'N/A' }}</p>
                            <p><span class="font-medium">Description:</span> {{ $requisition->part->description ?? 'N/A' }}</p>
                            <p><span class="font-medium">Quantity Required:</span> {{ $requisition->quantity_required }}</p>
                            <p><span class="font-medium">Quantity Issued:</span> {{ $requisition->quantity_issued }}</p>
                            <p><span class="font-medium">Serial Number:</span> {{ $requisition->serial_number ?? 'N/A' }}</p>
                            <p><span class="font-medium">Aircraft:</span> {{ $requisition->aircraft_registration ?? 'N/A' }}</p>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Workflow</h3>
                            <p><span class="font-medium">Requested By:</span> {{ $requisition->requested_by }}</p>
                            <p><span class="font-medium">Collector's Name:</span> {{ $requisition->collectors_name }}</p>
                            @if ($requisition->approvedBy)
                                <p><span class="font-medium">Approved By:</span> {{ $requisition->approvedBy->name }} on {{ $requisition->updated_at->format('d-M-Y') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8">
                        @if ($requisition->status === \App\Enums\RequisitionStatus::PENDING_APPROVAL)
{{--                            @can('requisitions-approve')--}}
                                <form action="{{ route('requisitions.approve', $requisition) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                                </form>
{{--                            @endcan--}}
{{--                            @can('requisitions-reject')--}}
                                <form action="{{ route('requisitions.reject', $requisition) }}" method="POST" class="inline ml-2">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reject</button>
                                </form>
{{--                            @endcan--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
