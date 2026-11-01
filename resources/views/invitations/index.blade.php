
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Invitation Management
            </h2>

            <a href="{{ route('invitations.create') }}"
                class="px-4 py-2 bg-indigo-600 text-black rounded-md">
                + Send Invitation
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

            @if(session('invitation_url'))
                <div class="mb-4 p-4 bg-blue-100 text-blue-800 rounded">
                    <p class="font-semibold">Invitation link (development only)</p>

                    <a href="{{ session('invitation_url') }}"
                        class="underline break-all"
                        target="_blank">
                        {{ session('invitation_url') }}
                    </a>

                    <p class="text-sm mt-2">
                        Share this link with the invited user. Email delivery will be configured separately.
                    </p>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Company</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Invited By</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Expires At</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($invitations as $invitation)
                            <tr class="border-t">
                                <td class="px-6 py-4">
                                    {{ $invitations->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $invitation->email }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $invitation->company->name ?? 'Company deleted' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ ucfirst($invitation->role) }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $invitation->inviter->name ?? 'Unknown' }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($invitation->accepted_at)
                                        <span class="text-green-600">Accepted</span>
                                    @elseif($invitation->expires_at->isPast())
                                        <span class="text-red-600">Expired</span>
                                    @else
                                        <span class="text-yellow-600">Pending</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    {{ $invitation->expires_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                                    No invitations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $invitations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
