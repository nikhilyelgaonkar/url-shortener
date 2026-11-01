
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Create Company
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm rounded-lg">

                <form action="{{ route('companies.store') }}" method="POST">
                    @csrf

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">
                            Company Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            placeholder="Enter company name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >

                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-indigo-700">
                            Save Company
                        </button>

                        <a href="{{ route('companies.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
