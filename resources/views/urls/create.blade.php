
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Create Short URL
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('short_url'))
                    <div class="mb-4 p-3 bg-blue-100 rounded">
                        <strong>Your Short URL:</strong>

                        <a href="{{ session('short_url') }}"
                           target="_blank"
                           class="text-blue-700 underline">
                            {{ session('short_url') }}
                        </a>
                    </div>
                @endif

                <form method="POST" action="{{ route('urls.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Select Company
                        </label>

                        <select name="company_id"
                                class="w-full border-gray-300 rounded-md">
                            <option value="">Select Company</option>

                            @foreach(\App\Models\Company::all() as $company)
                                <option value="{{ $company->id }}"
                                    @selected(old('company_id') == $company->id)>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('company_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Original URL
                        </label>

                        <input type="url"
                               name="original_url"
                               value="{{ old('original_url') }}"
                               placeholder="https://example.com"
                               class="w-full border-gray-300 rounded-md">

                        @error('original_url')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">
                        Generate Short URL
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
