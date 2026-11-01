
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Welcome, {{ auth()->user()->name }}!
                </h3>

                <p class="text-gray-500">
                    Role: {{ ucfirst(auth()->user()->role) }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @if(auth()->user()->role === 'superadmin')

                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-gray-500">Total URLs</h3>
                        <h2 class="text-3xl font-bold">
                            {{ $stats['total_urls'] }}
                        </h2>
                    </div>

                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-gray-500">Total Users</h3>
                        <h2 class="text-3xl font-bold">
                            {{ $stats['total_users'] }}
                        </h2>
                    </div>

                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-gray-500">Total Companies</h3>
                        <h2 class="text-3xl font-bold">
                            {{ $stats['total_companies'] }}
                        </h2>
                    </div>

                @elseif(auth()->user()->role === 'admin')

                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-gray-500">Company URLs</h3>
                        <h2 class="text-3xl font-bold">
                            {{ $stats['total_urls'] }}
                        </h2>
                    </div>

                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-gray-500">Company Users</h3>
                        <h2 class="text-3xl font-bold">
                            {{ $stats['total_users'] }}
                        </h2>
                    </div>

                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-gray-500">Pending Invitations</h3>
                        <h2 class="text-3xl font-bold">
                            {{ $stats['pending_invitations'] }}
                        </h2>
                    </div>

                @elseif(auth()->user()->role === 'member')

                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-gray-500">My Short URLs</h3>
                        <h2 class="text-3xl font-bold">
                            {{ $stats['my_urls'] }}
                        </h2>
                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>
