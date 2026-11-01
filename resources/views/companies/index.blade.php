
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Company Management
            </h2>

            <a href="{{ route('companies.create') }}"
               class="px-4 py-2 bg-indigo-600 text-black rounded-md hover:bg-indigo-700">
                Add Company
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Company Name</th>
                            <th class="px-6 py-3">Total Users</th>
                            <th class="px-6 py-3">Created At</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($companies as $company)
                            <tr class="border-t">
                                <td class="px-6 py-4">
                                    {{ $companies->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $company->name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $company->users_count }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $company->created_at->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex gap-3">
                                        <a href="{{ route('companies.edit', $company) }}"
                                           class="text-blue-600 hover:underline">
                                            Edit
                                        </a>

                                        <form action="{{ route('companies.destroy', $company) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this company?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-red-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                    No companies found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $companies->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
