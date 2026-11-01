
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Short URLs
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold">
                            URL List
                        </h3>

                        <p class="text-sm text-gray-500">
                            Manage and track your short URLs.
                        </p>
                    </div>
                </div>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if($urls->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="w-full border-collapse border border-gray-200">

                            <thead>
                                <tr class="bg-gray-100">

                                    <th class="border p-3 text-left">
                                        #
                                    </th>

                                    <th class="border p-3 text-left">
                                        Created By
                                    </th>

                                    <th class="border p-3 text-left">
                                        Original URL
                                    </th>

                                    <th class="border p-3 text-left">
                                        Short URL
                                    </th>

                                    <th class="border p-3 text-center">
                                        Clicks
                                    </th>

                                    <th class="border p-3 text-left">
                                        Created At
                                    </th>

                                    <th class="border p-3 text-center">
                                        Actions
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                @foreach($urls as $url)

                                    @php
                                        $shortUrl = route('url.redirect', $url->short_code);
                                    @endphp

                                    <tr class="hover:bg-gray-50">

                                        {{-- Serial Number --}}
                                        <td class="border p-3">
                                            {{ $urls->firstItem() + $loop->index }}
                                        </td>

                                        {{-- Created By --}}
                                        <td class="border p-3">
                                            {{ $url->user->name ?? 'Unknown' }}
                                        </td>

                                        {{-- Original URL --}}
                                        <td class="border p-3">

                                            <a href="{{ $url->original_url }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="text-blue-600 underline">

                                                {{ Str::limit($url->original_url, 40) }}

                                            </a>

                                        </td>

                                        {{-- Short URL --}}
                                        <td class="border p-3">

                                            <a href="{{ $shortUrl }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="text-blue-600 underline">

                                                {{ $shortUrl }}

                                            </a>

                                        </td>

                                        {{-- Click Count --}}
                                        <td class="border p-3 text-center">

                                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full font-semibold">
                                                {{ $url->clicks ?? 0 }}
                                            </span>

                                        </td>

                                        {{-- Created At --}}
                                        <td class="border p-3 whitespace-nowrap">
                                            {{ $url->created_at->format('d-m-Y h:i A') }}
                                        </td>

                                        {{-- Actions --}}
                                        <td class="border p-3 text-center">

                                            <button
                                                type="button"
                                                onclick="copyShortUrl('{{ $shortUrl }}', this)"
                                                class="px-3 py-2 bg-indigo-600 text-black text-sm rounded hover:bg-indigo-700">

                                                Copy URL

                                            </button>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $urls->links() }}
                    </div>

                @else

                    <div class="text-center py-10">

                        <h3 class="text-lg font-semibold text-gray-700">
                            No Short URLs Found
                        </h3>

                        <p class="text-gray-500 mt-2">
                            There are currently no short URLs available.
                        </p>

                    </div>

                @endif

            </div>

        </div>
    </div>

    {{-- Copy URL Script --}}
    <script>
        function copyShortUrl(url, button) {

            navigator.clipboard.writeText(url)
                .then(() => {

                    const originalText = button.innerText;

                    button.innerText = 'Copied!';
                    button.classList.remove('bg-indigo-600');
                    button.classList.add('bg-green-600');

                    setTimeout(() => {
                        button.innerText = originalText;
                        button.classList.remove('bg-green-600');
                        button.classList.add('bg-indigo-600');
                    }, 2000);

                })
                .catch(() => {
                    alert('Unable to copy URL. Please copy it manually.');
                });

        }
    </script>

</x-app-layout>
