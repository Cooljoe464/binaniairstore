<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('General Requisitions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            Requisition List
                        </h1>
                        @if (session('notification_success'))
                            <div class="mb-4 rounded-lg bg-green-100 px-6 py-0 text-base text-green-700" role="alert">
                                {{ session('notification_success') }}
                            </div>
                        @endif

                        @if (session('notification_error'))
                            <div class="mb-4 rounded-lg bg-red-100 px-6 py-0 text-base text-red-700" role="alert">
                                {{ session('notification_error') }}
                            </div>
                        @endif

                        @can('requisitions-create')
                            <a href="{{ route('requisitions.create') }}"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Requisition
                            </a>
                        @endcan
                    </div>

                    @livewire('requisition-table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
