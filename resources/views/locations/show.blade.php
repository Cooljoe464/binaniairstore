<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Location Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">
                        Location: {{ $location->name }}
                    </h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Name</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $location->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Created At</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $location->created_at->format('d-M-Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('locations.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Locations</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
