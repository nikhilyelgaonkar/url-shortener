
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Send Invitation
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">

                <form action="{{ route('invitations.store') }}" method="POST">
                    @csrf

                    @if(auth()->user()->hasRole('superadmin'))
                        <div class="mb-4">
                            <label for="company_id" class="block text-sm font-medium text-gray-700">
                                Select Company
                            </label>

                            <select name="company_id" id="company_id"
                                class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Select Company</option>

                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}"
                                        @selected(old('company_id') == $company->id)>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('company_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address
                        </label>

                        <input type="email" name="email" id="email"
                            value="{{ old('email') }}"
                            placeholder="Enter email address"
                            class="mt-1 block w-full rounded-md border-gray-300">

                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">
                            Select Role
                        </label>

                        <select name="role" id="role"
                            class="mt-1 block w-full rounded-md border-gray-300">

                            @if(auth()->user()->hasRole('superadmin'))
                                <option value="admin">Admin</option>
                            @else
                                <option value="">Select Role</option>
                                <option value="admin" @selected(old('role') === 'admin')>
                                    Admin
                                </option>
                                <option value="member" @selected(old('role') === 'member')>
                                    Member
                                </option>
                            @endif
                        </select>

                        @error('role')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">
                            Send Invitation
                        </button>

                        <a href="{{ route('invitations.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
