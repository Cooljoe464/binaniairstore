<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Goods Received Notes') }}
        </h2>
    </x-slot>
    <div class="container mx-auto">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <div class="flex justify-between mb-6">
                            <h1 class="text-2xl font-bold text-gray-900">
                                Goods Received Notes
                            </h1>
                            <a href="{{ route('goods-received-notes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create New
                            </a>
                        </div>

                        <livewire:goods-received-notes-table/>
                    </div>

                    <div class="p-6">

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
