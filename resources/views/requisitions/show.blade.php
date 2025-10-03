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
                            @if ($requisition->disbursedBy)
                                <p><span class="font-medium">Disbursed By:</span> {{ $requisition->disbursedBy->name }} on {{ $requisition->disbursed_at->format('d-M-Y') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8">
                        @if ($requisition->status === \App\Enums\RequisitionStatus::PENDING_APPROVAL)
                            @can('requisitions-approve')
                                <form action="{{ route('requisitions.approve', $requisition) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                                </form>
                            @endcan
                            @can('requisitions-reject')
                                <form action="{{ route('requisitions.reject', $requisition) }}" method="POST" class="inline ml-2">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reject</button>
                                </form>
                            @endcan
                        @endif

                        @if ($requisition->status === \App\Enums\RequisitionStatus::APPROVED && !$requisition->disbursed_by_id)
                            @can('requisitions-disburse')
                                <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Disburse</button>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Disbursement Modal -->
    <div id="disbursementModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('requisitions.disburse', $requisition) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Disburse Requisition
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Select the user who is disbursing this requisition.
                            </p>
{{--                            @dd($users)--}}
                            <div class="mt-4">
                                <label for="disbursed_by_id" class="block text-sm font-medium text-gray-700">Disbursed By</label>
                                <select id="disbursed_by_id" name="disbursed_by_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select User</option>

                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Submit
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('disbursementModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('disbursementModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
